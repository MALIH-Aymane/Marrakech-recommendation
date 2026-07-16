<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Notifications\NewAttractionNotification;
use App\Notifications\DeleteAttractionNotification;
use App\Models\Attraction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Notifications\UpdateAttractionNotification;
class AttractionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
 public function home()
{
    $attractions = Attraction::where('type', '!=', 'Excursion')
        ->whereNotNull('photo')
        ->where('photo', '!=', '')
        ->orderBy('id', 'asc')   
        ->take(6)
        ->get();

    return view('home', compact('attractions'));
}
 public function index(Request $request)
{
    // Cas Admin
    if (auth()->check() && auth()->user()->hasRole('Admin')) {

        $query = Attraction::query();

        // Filtre Activités / Attractions
        if ($request->type == 'activities') {

            $query->where('type', 'Excursion');

        } else {

            $query->where('type', '!=', 'Excursion');

        }

        // Recherche
        if ($request->filled('search')) {

            $query->where('attraction', 'like', '%' . $request->search . '%');

        }

       $attractions = $query->orderBy('id', 'asc')->get();

        return view('attractions.index', compact('attractions'));
    }

    // Cas Visiteur / Utilisateur
   $attractions = Attraction::where('type', '!=', 'Excursion')
    ->whereNotNull('photo')
    ->where('photo', '!=', '')
    ->get();

    return view('attractions.cards', compact('attractions'));
}
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    $validated = $request->validate([

        'attraction' => 'required|string|max:255',
        'rate' => 'nullable|numeric|min:0|max:5',
        'details' => 'nullable|string',
        'reviews' => 'nullable|string',
        'attraction_url' => 'nullable|url',
        'reviews_url' => 'nullable|url',
        'uuid' => 'required|string|unique:attractions,uuid',
        'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',

    ]);

    if($request->hasFile('photo')){

        $validated['photo'] = $request
            ->file('photo')
            ->store('attractions','public');

    }

    $attraction=Attraction::create($validated);
    //notifier tous les administrateurs
    $admins=User::role('Admin')->get();
    foreach($admins as $admin){
        $admin->notify(new NewAttractionNotification($attraction));
    }

    return redirect()
        ->route('attractions.index')
        ->with('success','Attraction ajoutée avec succès.');

}

    /**
     * Display the specified resource.
     */
    public function show(Attraction $attraction)
    {

        if(auth()->check() && auth()->user()->hasRole('Admin')){
        return view("attractions.show", compact('attraction'));
    }   return view("attractions.show-user", compact('attraction'));
}
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Attraction $attraction)
    {
        return view("attractions.edit", compact('attraction'));
    }

    /**
     * Update the specified resource in storage.
     */
   public function update(Request $request, Attraction $attraction)
{
    $validated = $request->validate([

        'attraction' => 'required|string|max:255',
        'rate' => 'nullable|numeric|min:0|max:5',
        'details' => 'nullable|string',
        'reviews' => 'nullable|string',
        'attraction_url' => 'nullable|url',
        'reviews_url' => 'nullable|url',
        'uuid' => 'required|string|unique:attractions,uuid,'.$attraction->id,
        'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',

    ]);

    if($request->hasFile('photo')){

        if($attraction->photo){

            \Storage::disk('public')->delete($attraction->photo);

        }

        $validated['photo'] = $request
            ->file('photo')
            ->store('attractions','public');

    }

    $attraction->update($validated);
    // Notifier tous les administrateurs
    $admins = User::role('Admin')->get();

            foreach ($admins as $admin) {

                $admin->notify(new UpdateAttractionNotification($attraction));

}

    return redirect()
        ->route('attractions.index')
        ->with('success','Attraction modifiée avec succès.');

}

    /**
     * Remove the specified resource from storage.
     */
 public function destroy(Attraction $attraction)
{
    // Notifier tous les administrateurs AVANT la suppression
    $admins = User::role('Admin')->get();

    foreach ($admins as $admin) {

        $admin->notify(new DeleteAttractionNotification($attraction));

    }

    if ($attraction->photo) {

        Storage::disk('public')->delete($attraction->photo);

    }

    $attraction->delete();

    return redirect()
            ->route('attractions.index')
            ->with('success', 'Attraction supprimée avec succès.');
}
}
