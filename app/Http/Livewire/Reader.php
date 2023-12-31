<?php

namespace App\Http\Livewire;

use App\Models\User;
use Livewire\Component;
use App\Models\Registration;
use Livewire\WithPagination;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class Reader extends Component
{

    use WithPagination;

    public $searchInput = '';
    public $readersLength;

    public function mount()
    {
        $this->readersLength = User::user()->orderByDesc('id')
        ->where('role', '<>' ,'Bibliothécaire')
        ->where('role', '<>' ,'Administrateur')->count();
    }


    public function updating($name, $value)
    {
        if($name === 'searchInput')
        {
            $this->resetPage();
        }
    }

    public function paginationView()
    {
        return 'livewire.pagination';
    }

    public function changeStatus(int $currentCategoryId, bool $status)
    {
        $reader = User::where('id', $currentCategoryId)
                ->where('role', '<>' ,'Bibliothécaire')
                ->where('role', '<>' ,'Administrateur')->firstOrFail();

        if($status)
        {
            $reader->status = false;
        }
        else
        {
            $registration = Registration::where('reader_id', $reader->id)->first();

            if($registration->status == false)
            {
                $start_date = Carbon::now()->format('Y-m-d');
                $end_date = Carbon::now()->addYear()->format('Y-m-d');
                $institute = Institute::where('librarian_id', Auth::user()->id)->first();

                Registration::create([
                    'start_date' => $start_date,
                    'end_date' => $end_date,
                    'reader_id' => $reader->id,
                    'institute_id' => $institute->id,
                ]);
            }

            $reader->status = true;
        }

        $reader->save();

        session()->flash('message', $status ? 'Désactivation de compte réussie' : 'Activation de compte réussie');
        $this->emit('closeModal');

        $this->resetPage();
    }

    public function render()
    {
        $readers = User::user()->where(function($query) {
            $query->where('lastname', 'LIKE', '%'.$this->searchInput.'%')
            ->orWhere('firstname', 'LIKE', '%'.$this->searchInput.'%')
            ->orWhere('npi', 'LIKE', '%'.$this->searchInput.'%')
            ->orWhere('registration_number', 'LIKE', '%'.$this->searchInput.'%')
            ->orWhere('phone_number', 'LIKE', '%'.$this->searchInput.'%')
            ->orWhere('email', 'LIKE', '%'.$this->searchInput.'%');
        })->where('role', '<>' ,'Bibliothécaire')
        ->where('role', '<>' ,'Administrateur')
        ->orderByDesc('id')->paginate(10);

        return view('livewire.reader', [
            'readers' => $readers
        ]);
    }
}
