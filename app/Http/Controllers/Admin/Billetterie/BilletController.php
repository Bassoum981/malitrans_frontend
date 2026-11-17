<?php

namespace App\Http\Controllers\Admin\Billetterie;

use App\Http\Controllers\Controller;
use App\Services\MaliTransApiService;
use Illuminate\Http\Request;

class BilletController extends Controller
{
    protected MaliTransApiService $api;

    public function __construct(MaliTransApiService $api)
    {
        $this->api = $api;
    }

    public function index()
    {
        $response = $this->api->get('/admin/billets');
        $billets = $response->successful() ? $response->json() : [];

        // Récupération des affectations et passagers pour le modal d'émission au guichet
        $affectationsResp = $this->api->get('/admin/affectations');
        $affectations = $affectationsResp->successful() ? $affectationsResp->json() : [];

        $passagersResp = $this->api->get('/admin/passagers');
        $passagers = $passagersResp->successful() ? $passagersResp->json() : [];

        return view('admin.billetterie.index', compact('billets', 'affectations', 'passagers'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'passagerId'        => 'required|integer',
            'affectationId'     => 'required|integer',
            'siegeId'           => 'nullable|integer',
            'modePaiement'      => 'required|string',
            'referencePaiement' => 'nullable|string|max:100',
        ]);

        // Cast explicite des IDs en entiers pour Spring Boot
        $payload = [
            'passagerId'        => (int) $validated['passagerId'],
            'affectationId'     => (int) $validated['affectationId'],
            'siegeId'           => !empty($validated['siegeId']) ? (int) $validated['siegeId'] : null,
            'modePaiement'      => $validated['modePaiement'],
            'referencePaiement' => $validated['referencePaiement'] ?? null,
        ];

        $response = $this->api->post('/admin/billets', $payload);

        if ($response->failed()) {
            $errorMsg = $response->json('message') ?? 'Erreur lors de l’émission du billet.';
            return back()->withInput()->with('error', $errorMsg);
        }

        return redirect()
            ->route('admin.billetterie.index')
            ->with('success', 'Billet émis et validé avec succès.');
    }

    public function annuler($id)
    {
        $response = $this->api->patch("/admin/billets/{$id}/annuler");

        if ($response->failed()) {
            $errorMsg = $response->json('message') ?? 'Impossible d’annuler ce billet.';
            return back()->with('error', $errorMsg);
        }

        return redirect()
            ->route('admin.billetterie.index')
            ->with('success', 'Le billet a bien été annulé.');
    }
}
