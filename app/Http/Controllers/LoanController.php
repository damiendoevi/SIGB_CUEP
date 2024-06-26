<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use App\Models\User;
use App\Models\Group;
use App\Models\Resource;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Requests\LoanRequest;

class LoanController extends Controller
{
    public function __construct()
    {
        $this->middleware('librarian')->except(['index', 'manageDelays']);
        $this->middleware('librarianOrReader')->only(['index']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->manageDelays();
        return view('loans');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(session()->has('selections'))
        {
            return view('add-loan', [
                'selections' => session('selections')
            ]);
        }
        else  abort(403);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(LoanRequest $request)
    {
        if($request->has('group_id'))
        {
            $loaner = Group::where('id', intval($request->group_id))->first();
        }
        else
        {
            $loaner = User::user()->where([['role', '<>' ,'Administrateur'], ['role', '<>' ,'Bibliothécaire'], ['registration_number', intval($request->registration_number)]])->first();

            if($loaner == null)
            {
                return back()->with(['message' => "Nous n'avions pas trouvé de lecteur avec ce matricule dans votre bibliotheque"]);
            }
        }

        if($loaner->loans()->latest()->first() && ($loaner->loans()->latest()->first()->status == "En cour" || $loaner->loans()->latest()->first()->status == "Retard"))
        {
            return back()->with(['message' => "Nous ne pouvons pas éffectuer de pret pour ce lecteur / groupe"]);
        }

        $start_date = Carbon::now();

        $loan = new Loan([
            'start_date' => $start_date,
            'end_date' => $request->end_date,
            'status' => "En cour",
        ]);

        $loaner->loans()->save($loan);

        $loan->resources()->attach(session('selections'));

        foreach (session('selections') as $id) {

            $resource = Resource::find($id);

            if ($resource) {
                $resource->decrement('available_number');
            }
        }

        session()->forget('selections');

        if(session()->has('reader_registration_number'))
        {
            session()->forget('reader_registration_number');
            $reservation = Reservation::orderByDesc('id')->where('reader_id', $loaner->id)->first();

            $reservation->status = "Terminé";
            $reservation->loan_id = $loan->id;

            $reservation->save();
        }

        return redirect()->route('loans.index')->with(['message' => 'Enregistrement réussi']);
    }


    public function manageDelays()
    {
        $today = Carbon::today();
        $loans = Loan::where('end_date', '<', $today)
                ->where('status', 'En cour')
                ->get();

        foreach ($loans as $loan) {
            $loan->update(['status' => "Retard"]);
        }
    }
}
