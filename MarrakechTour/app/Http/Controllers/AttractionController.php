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
              $attractions = $query->orderBy('id', 'asc')->paginate(12)->withQueryString();
        return view('attractions.index', compact('attractions'));
    }

    // Cas Visiteur / Utilisateur
   $attractions = Attraction::where('type', '!=', 'Excursion')
    ->whereNotNull('photo')
    ->where('photo', '!=', '')
    ->paginate(12)
    ->withQueryString();

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
public function find(Request $request)
{
    $request->validate([
        'image'  => 'nullable|image|max:2048',
        'prompt' => 'nullable|string|max:1000',
    ]);

    $query = Attraction::query()
        ->whereNotNull('photo')
        ->where('photo', '!=', '');

    if ($request->filled('prompt')) {

        $prompt = strtolower($request->prompt);

        /*
        |--------------------------------------------------------------------------
        | Garden
        |--------------------------------------------------------------------------
        */
        if (
            str_contains($prompt,'garden') ||
            str_contains($prompt,'park') ||
            str_contains($prompt,'nature') ||
            str_contains($prompt,'flowers') ||
            str_contains($prompt,'green') ||
            str_contains($prompt,'peaceful') ||
            str_contains($prompt,'quiet') ||
            str_contains($prompt,'relax')
        ) {

            $query->where('type','Jardin');

        }

        /*
        |--------------------------------------------------------------------------
        | Museum
        |--------------------------------------------------------------------------
        */
        elseif (
            str_contains($prompt,'museum') ||
            str_contains($prompt,'art') ||
            str_contains($prompt,'culture') ||
            str_contains($prompt,'painting') ||
            str_contains($prompt,'history')
        ) {

            $query->where('type','Musée');

        }

        /*
        |--------------------------------------------------------------------------
        | Palace
        |--------------------------------------------------------------------------
        */
        elseif (
            str_contains($prompt,'palace') ||
            str_contains($prompt,'royal') ||
            str_contains($prompt,'architecture')
        ) {

            $query->where('type','Palais');

        }

        /*
        |--------------------------------------------------------------------------
        | Historical Site
        |--------------------------------------------------------------------------
        */
        elseif (
            str_contains($prompt,'historical') ||
            str_contains($prompt,'historic') ||
            str_contains($prompt,'monument') ||
            str_contains($prompt,'old')
        ) {

            $query->where('type','Site historique');

        }

        /*
        |--------------------------------------------------------------------------
        | Tourist Attractions
        |--------------------------------------------------------------------------
        */
        elseif (
            str_contains($prompt,'mosque') ||
            str_contains($prompt,'medina') ||
            str_contains($prompt,'market') ||
            str_contains($prompt,'square') ||
            str_contains($prompt,'souk') ||
            str_contains($prompt,'tourist') ||
            str_contains($prompt,'visit')
        ) {

            $query->where('type','Attraction touristique');

        }

        /*
        |--------------------------------------------------------------------------
        | Sunset / View
        |--------------------------------------------------------------------------
        */
        elseif (
            str_contains($prompt,'sunset') ||
            str_contains($prompt,'sunrise') ||
            str_contains($prompt,'view') ||
            str_contains($prompt,'photography')
        ) {

            $query->where('rate','>=',4);

        }

        /*
        |--------------------------------------------------------------------------
        | Family
        |--------------------------------------------------------------------------
        */
        elseif (
            str_contains($prompt,'family') ||
            str_contains($prompt,'kids') ||
            str_contains($prompt,'children')
        ) {

            $query->where('rate','>=',4);

        }
    }

    $recommendations = $query
    ->inRandomOrder()
    ->get()
    ->unique(function ($item) {
        return strtolower(trim($item->attraction));
    })
    ->values()
    ->take(6);
    $type = $recommendations->first()
    ? __('attractions.types.' . $recommendations->first()->type)
    : __('find_attraction.attractions');

/*
|--------------------------------------------------------------------------
|  le pluriel suivant la langue
|--------------------------------------------------------------------------
*/
if ($recommendations->count() > 1) {

    switch (app()->getLocale()) {

        case 'en':

            $plural = [
                'Garden'                 => 'Gardens',
                'Museum'                 => 'Museums',
                'Palace'                 => 'Palaces',
                'Historical Site'        => 'Historical Sites',
                'Tourist Attraction'     => 'Tourist Attractions',
                'Excursion'              => 'Excursions',
            ];

            break;

        case 'fr':

            $plural = [
                'Jardin'                 => 'Jardins',
                'Musée'                  => 'Musées',
                'Palais'                 => 'Palais',
                'Site historique'        => 'Sites historiques',
                'Attraction touristique' => 'Attractions touristiques',
                'Excursion'              => 'Excursions',
            ];

            break;

        case 'ar':

            $plural = [
                'حديقة'            => 'الحدائق',
                'متحف'             => 'المتاحف',
                'قصر'              => 'القصور',
                'موقع تاريخي'      => 'المواقع التاريخية',
                'معلم سياحي'       => 'المعالم السياحية',
                'رحلة'             => 'الرحلات',
            ];

            break;

        default:

            $plural = [];
    }

    $type = $plural[$type] ?? $type;
}
    // Si aucun résultat n'est trouvé, afficher 6 attractions aléatoires
    if ($recommendations->isEmpty()) {

        $recommendations = Attraction::whereNotNull('photo')
            ->where('photo','!=','')
            ->inRandomOrder()
            ->take(6)
            ->get();

    }
         $aiMessage = __('find_attraction.ai_message', [
         'type' => $type,
]);
    return view('attractions.find', compact(
    'recommendations',
    'aiMessage'
));
}
}
