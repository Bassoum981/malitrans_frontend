<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\MaliTransApiService;
use Illuminate\Http\Request;

class AdminEmployeController extends Controller
{
    protected MaliTransApiService $api;

    public function __construct(MaliTransApiService $api)
    {
        $this->api = $api;
    }

    // ==========================================
    // 1. CHAUFFEURS
    // ==========================================
    public function indexChauffeurs()
    {
        $response = $this->api->get('/admin/employes/chauffeurs');
        $chauffeurs = $response->successful() ? $response->json() : [];
        return view('admin.employes.chauffeurs.index', compact('chauffeurs'));
    }

    public function storeChauffeur(Request $request)
    {
        $response = $this->api->post('/admin/employes/chauffeurs', $request->all());
        return $response->successful()
            ? redirect()->route('admin.chauffeurs.index')->with('success', 'Chauffeur créé avec succès.')
            : back()->withErrors($response->json()['message'] ?? 'Erreur lors de la création.')->withInput();
    }

    public function destroyChauffeur($id)
    {
        $this->api->delete("/admin/employes/chauffeurs/{$id}");
        return redirect()->route('admin.chauffeurs.index')->with('success', 'Chauffeur supprimé avec succès.');
    }

    // ==========================================
    // 2. CAISSIERS
    // ==========================================
    public function indexCaissiers()
    {
        $response = $this->api->get('/admin/employes/caissiers');
        $caissiers = $response->successful() ? $response->json() : [];
        return view('admin.employes.caissiers.index', compact('caissiers'));
    }

    public function storeCaissier(Request $request)
    {
        $response = $this->api->post('/admin/employes/caissiers', $request->all());
        return $response->successful()
            ? redirect()->route('admin.caissiers.index')->with('success', 'Caissier créé avec succès.')
            : back()->withErrors($response->json()['message'] ?? 'Erreur lors de la création.')->withInput();
    }

    public function destroyCaissier($id)
    {
        $this->api->delete("/admin/employes/caissiers/{$id}");
        return redirect()->route('admin.caissiers.index')->with('success', 'Caissier supprimé avec succès.');
    }

    // ==========================================
    // 3. MÉCANICIENS
    // ==========================================
    public function indexMecaniciens()
    {
        $response = $this->api->get('/admin/employes/mecaniciens');
        $mecaniciens = $response->successful() ? $response->json() : [];
        return view('admin.employes.mecaniciens.index', compact('mecaniciens'));
    }

    public function storeMecanicien(Request $request)
    {
        $response = $this->api->post('/admin/employes/mecaniciens', $request->all());
        return $response->successful()
            ? redirect()->route('admin.mecaniciens.index')->with('success', 'Mécanicien créé avec succès.')
            : back()->withErrors($response->json()['message'] ?? 'Erreur lors de la création.')->withInput();
    }

    public function destroyMecanicien($id)
    {
        $this->api->delete("/admin/employes/mecaniciens/{$id}");
        return redirect()->route('admin.mecaniciens.index')->with('success', 'Mécanicien supprimé avec succès.');
    }

    // ==========================================
    // 4. RESPONSABLES DE FLOTTE
    // ==========================================
    public function indexResponsablesFlotte()
    {
        $response = $this->api->get('/admin/employes/responsables-flotte');
        $responsables = $response->successful() ? $response->json() : [];
        return view('admin.employes.responsables-flotte.index', compact('responsables'));
    }

    public function storeResponsableFlotte(Request $request)
    {
        $response = $this->api->post('/admin/employes/responsables-flotte', $request->all());
        return $response->successful()
            ? redirect()->route('admin.responsables-flotte.index')->with('success', 'Responsable de flotte créé avec succès.')
            : back()->withErrors($response->json()['message'] ?? 'Erreur lors de la création.')->withInput();
    }

    public function destroyResponsableFlotte($id)
    {
        $this->api->delete("/admin/employes/responsables-flotte/{$id}");
        return redirect()->route('admin.responsables-flotte.index')->with('success', 'Responsable de flotte supprimé avec succès.');
    }

    // ==========================================
    // 5. AGENTS D'EXPLOITATION
    // ==========================================
    public function indexAgentsExploitation()
    {
        $response = $this->api->get('/admin/employes/agents-exploitation');
        $agents = $response->successful() ? $response->json() : [];
        return view('admin.employes.agents-exploitation.index', compact('agents'));
    }

    public function storeAgentExploitation(Request $request)
    {
        $response = $this->api->post('/admin/employes/agents-exploitation', $request->all());
        return $response->successful()
            ? redirect()->route('admin.agents-exploitation.index')->with('success', 'Agent d\'exploitation créé avec succès.')
            : back()->withErrors($response->json()['message'] ?? 'Erreur lors de la création.')->withInput();
    }

    public function destroyAgentExploitation($id)
    {
        $this->api->delete("/admin/employes/agents-exploitation/{$id}");
        return redirect()->route('admin.agents-exploitation.index')->with('success', 'Agent d\'exploitation supprimé avec succès.');
    }
}
