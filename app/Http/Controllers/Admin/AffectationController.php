<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class AffectationController extends Controller
{
    private string $baseUrl;

    public function __construct()
    {
        // Utilise l'URL qui contient déjà /api et pointe vers /admin/affectations
        $this->baseUrl = config('services.springboot.url', 'http://localhost:8080/api') . '/admin/affectations';
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
        $affectations = $response->successful() ? $response->json() : [];

        // Récupération des listes pour les selects du formulaire avec le token
        $baseApiUrl = config('services.springboot.url');
        $chauffeursResponse = $this->api()->get("{$baseApiUrl}/admin/employes/chauffeurs");
        $vehiculesResponse = $this->api()->get("{$baseApiUrl}/admin/vehicules");

        $chauffeurs = $chauffeursResponse->successful() ? $chauffeursResponse->json() : [];
        $vehicules = $vehiculesResponse->successful() ? $vehiculesResponse->json() : [];

        return view('admin.affectations.index', compact('affectations', 'chauffeurs', 'vehicules'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
            'chauffeur_id' => 'required|integer',
            'vehicule_id' => 'required|integer',
        ]);

        $response = $this->api()->post($this->baseUrl, [
            'date' => $request->date,
            'heureDebut' => $request->heure_debut,
            'heureFin' => $request->heure_fin,
            'statut' => $request->statut ?? 'Planifiée',
            'chauffeurId' => $request->chauffeur_id,
            'vehiculeId' => $request->vehicule_id,
        ]);

        if ($response->successful()) {
            return redirect()->route('admin.affectations.index')->with('success', 'Affectation créée avec succès.');
        }

        return back()->withErrors(['error' => 'Erreur Spring Boot : ' . $response->body()]);
    }

    public function destroy($id)
    {
        $response = $this->api()->delete("{$this->baseUrl}/{$id}");

        if ($response->successful()) {
            return redirect()->route('admin.affectations.index')->with('success', 'Affectation supprimée avec succès.');
        }

        return back()->withErrors(['error' => 'Impossible de supprimer cette affectation.']);
    }
}
