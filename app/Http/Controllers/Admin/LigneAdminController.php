<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class LigneAdminController extends Controller
{
    private string $baseUrl;

    public function __construct()
    {
        // Pointe vers /api/admin/lignes
        $this->baseUrl = config('services.springboot.url', 'http://localhost:8080/api') . '/admin/lignes';
    }

    /**
     * Helper pour injecter automatiquement le token JWT de l'administrateur connecté.
     */
    private function api()
    {
        $token = Session::get('admin_token');
        return Http::withToken($token);
    }

    public function index()
    {
        $response = $this->api()->get($this->baseUrl);
        $lignes = $response->successful() ? $response->json() : [];

        return view('admin.exploitation.lignes.index', compact('lignes'));
    }

    public function create()
    {
        return view('admin.exploitation.lignes.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'numero' => 'required|string|max:50',
            'nom' => 'required|string|max:255',
            'tarif' => 'nullable|numeric',
            'distance' => 'nullable|numeric',
        ]);

        // Utilisation de $this->api()->post(...) pour inclure le token JWT
        $response = $this->api()->post($this->baseUrl, [
            'numero' => $request->numero,
            'nom' => $request->nom,
            'couleur' => $request->couleur,
            'distance' => $request->distance ? (float) $request->distance : null,
            'tarif' => $request->tarif ? (float) $request->tarif : null,
        ]);

        if ($response->successful()) {
            return redirect()->route('admin.lignes.index')->with('success', 'Ligne de transport créée avec succès.');
        }

        return back()->withErrors(['error' => 'Erreur Spring Boot (' . $response->status() . ') : ' . $response->body()])->withInput();
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'numero' => 'required|string|max:50',
            'nom' => 'required|string|max:255',
        ]);

        // Utilisation de $this->api()->put(...) pour inclure le token JWT
        $response = $this->api()->put("{$this->baseUrl}/{$id}", [
            'numero' => $request->numero,
            'nom' => $request->nom,
            'couleur' => $request->couleur,
            'distance' => $request->distance ? (float) $request->distance : null,
            'tarif' => $request->tarif ? (float) $request->tarif : null,
        ]);

        if ($response->successful()) {
            return back()->with('success', 'Ligne mise à jour avec succès.');
        }

        return back()->withErrors(['error' => 'Erreur lors de la mise à jour : ' . $response->body()]);
    }

    public function destroy($id)
    {
        // Utilisation de $this->api()->delete(...) pour inclure le token JWT
        $response = $this->api()->delete("{$this->baseUrl}/{$id}");

        if ($response->successful()) {
            return back()->with('success', 'Ligne supprimée avec succès.');
        }

        return back()->withErrors(['error' => 'Impossible de supprimer cette ligne.']);
    }
}
