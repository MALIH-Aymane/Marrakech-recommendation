<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\AI\ClipEmbeddingService;
use App\Services\AI\ImageSearchService;

class ImageSearchController extends Controller
{
    public function search(
        Request $request,
        ClipEmbeddingService $clip,
        ImageSearchService $search
    ) {

        $request->validate([
            'image' => 'required|image'
        ]);

        $path = $request->file('image')->store('search', 'public');

        $fullPath = storage_path('app/public/' . $path);

        $embedding = $clip->embedImage($fullPath);

        $results = $search->search($embedding);

        unlink($fullPath);

        return view('attractions.find', [
    'results' => $results
]);
    }
}