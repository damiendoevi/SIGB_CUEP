<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use App\Models\Type;
use App\Models\User;
use App\Models\Category;
use App\Models\Resource;
use App\Models\Institute;

use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\ProfileRequest;

class MainController extends Controller
{
    public function createAdminAccount(Request $request)
    {
        $admin = User::where('role', 'Administrateur')->first();

        if($admin)
        {
            return response()->json("L'administrateur avait déja été enregistrer");
        }

        User::create([
            'firstname' => 'Guy',
            'lastname' => 'KPEDJO',
            'npi' => null,
            'email' => 'gkpedjo@gmail.com',
            'phone_number' => '63053905',
            'address' => null,
            'role' => 'Administrateur',
            'password' => Hash::make('password'),
        ]);

        return response()->json("L'administrateur a été bien enregistrer");
    }

    public function dashboard()
    {
        if(Auth::user()->role == "Administrateur")
        {
            $nbr_institutes = Institute::all()->count();
            $nbr_resources = Resource::all()->count();
            $nbr_librarians = User::where('role', 'Bibliothécaire')->get()->count();
        }
        elseif(Auth::user()->role == "Bibliothécaire")
        {
            $nbr_currents_loans = Loan::loan()->where('status', 'En cour')->get()->count();
            $nbr_currents_reservations = Reservation::reservation()->where('status', 'En cour')->get()->count();
            $nbr_lates_loans = Loan::loan()->where('status', 'Retard')->get()->count();
        }
        else
        {
            $nbr_reader_loans = Loan::loan()->where('status', 'En cour')->where(function($query){
                            $query->where('reader_id', Auth::user()->id)
                            ->orWhereHas('group', function($query){
                                $query->whereHas('readers', function($subQuery){
                                    $subQuery->where('users.id', Auth::user()->id);
                                });
                            });
                            })->get()->count();


            $nbr_reader_reservations = Reservation::reservation()->where('status', 'En cour')
                ->where('reader_id', Auth::user()->id)->get()->count();


            $nbr_current_lates = Loan::loan()->where('status', 'Retard')
                ->where(function($query) {
                    $query->where('reader_id', Auth::user()->id)->orWhereHas('group', function($subQuery){
                            $subQuery->orWhereHas('readers', function($subSubQuery){
                                $subSubQuery->where('users.id', Auth::user()->id);
                            });
                        });
                })->get()->count();
        }

        return view('dashboard', [
            'nbr_institutes' => $nbr_institutes ?? null,
            'nbr_resources' => $nbr_resources ?? null,
            'nbr_librarians' => $nbr_librarians ?? null,
            'nbr_currents_loans' => $nbr_currents_loans ?? null,
            'nbr_currents_reservations' => $nbr_currents_reservations ?? null,
            'nbr_lates_loans' => $nbr_lates_loans ?? null,
            'nbr_reader_loans' => $nbr_reader_loans ?? null,
            'nbr_reader_reservations' => $nbr_reader_reservations ?? null,
            'nbr_current_lates' => $nbr_current_lates ?? null,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateprofile(ProfileRequest $request ,$id)
    {
        $user = User::where([['id', Auth::user()->id], ['id', $id]])->firstOrFail();

        app('App\Http\Controllers\UserController')->update($request, $user);

        return redirect()->route('dashboard');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function editProfile($id)
    {
        $user = User::where([['id', Auth::user()->id], ['id', $id]])->firstOrFail();

        return view('profile', [
            'user' => $user
        ]);
    }

    public function welcome()
    {
        $types = Type::orderBy('name')->get();
        $categories = Category::orderBy('name')->get();

        $categories = $categories->map(function ($category) {
            $resourcesCount = $category->resources()->count();
            foreach ($category->sub_categories as $subCategory) {
                foreach ($subCategory->sub_sub_categories as $subSubCategory) {
                    $resourcesCount += $subSubCategory->resources()->count();
                }
            }
            $category->totalResourcesCount = $resourcesCount;
            return $category;
        });    

        return view('welcome', [ 
            'types' => $types,
            'categories' => $categories,
        ]);
    }
}
