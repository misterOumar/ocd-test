<?php

namespace App\Http\Controllers;

use App\Models\Person;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class PersonController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth')->only(['create', 'store']);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $people = Person::with('creator')->get();
        return view('people.index', compact('people'));
    }


    /**
     * Display the specified resource.
     */
    public function show(Person $person)
    {
       
        $person->load('children', 'parents');
        // dd($person);
        return view('people.show', compact('person'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        
        return view('people.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'birth_name' => 'nullable|string|max:255',
            'middle_names' => 'nullable|string|max:255',
            'date_of_birth' => 'nullable|date',
        ]);

        $person = new Person();

        $person->created_by = Auth::id();
        $person->first_name = ucfirst(strtolower($request->first_name));
        $person->last_name = strtoupper($request->last_name);
        $person->birth_name = $request->filled('birth_name') ? strtoupper($request->birth_name) : strtoupper($request->last_name);

        if ($request->filled('middle_names')) {
            $middleNames = explode(',', $request->middle_names);
            $formattedMiddleNames = array_map(function ($name) {
                return ucfirst(strtolower(trim($name)));
            }, $middleNames);
            $person->middle_names = implode(', ', $formattedMiddleNames);
        } else {
            $person->middle_names = null;
        }

        $person->date_of_birth = $request->filled('date_of_birth') ? $request->date_of_birth : null;

        try {
            $person->save();
            return redirect()->route('people.index')->with('success', 'Personne créée avec succès.');
        } catch (\Exception $e) {
            return redirect()->route('people.index')->with('error', 'Erreur lors de la création de la personne.');
        }
    }



 
}
