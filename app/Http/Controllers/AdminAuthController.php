<?php
namespace App\Http\Controllers;

use App\Services\MaliTransApiService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class AdminAuthController extends Controller
{
    protected MaliTransApiService $api;

    public function __construct(MaliTransApiService $api)
    {
        $this->api = $api;
    }

    public function showLoginForm()
    {
        if (Session::has('admin_token')) {
            return redirect()->route('admin.dashboard');
        }
        return view('admin.auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Appel vers l'endpoint d'authentification de votre backend Spring Boot
        // Adaptez l'URL '/auth/connexion' selon votre configuration Spring Security / Auth API
        $response = $this->api->post('/auth/connexion', [
            'email' => $request->email,
            'motDePasse' => $request->password,
        ]);

        if ($response->successful()) {
            $data = $response->json();

            // Stockage sécurisé du token JWT et des infos de l'admin
            Session::put('admin_token', $data['token'] ?? $data['accessToken']);
            Session::put('admin_user', $data);

            return redirect()->route('admin.dashboard')
                ->with('success', 'Connexion réussie. Bienvenue sur le panneau d\'administration.');
        }

        return back()->withErrors([
            'email' => 'Identifiants invalides ou accès non autorisé.'
        ])->withInput();
    }

    public function logout()
    {
        Session::forget(['admin_token', 'admin_user']);
        Session::invalidate();
        Session::regenerateToken();

        return redirect()->route('admin.login')
            ->with('success', 'Vous avez été déconnecté avec succès.');
    }
}

