<?php

namespace App\Http\Controllers\Admin\Billetterie;

use App\Http\Controllers\Controller;
use App\Services\MaliTransApiService;
use Illuminate\Http\Request;

class BilletController extends Controller
{
    public function __construct(private readonly MaliTransApiService $api) {}

    public function index()
    {
        $billetsResp = $this->api->get('/billets');
        $billets = $billetsResp->successful() ? $billetsResp->json() : [];

        $affectationsResp = $this->api->get('/admin/affectations');
        $affectations = $affectationsResp->successful() ? $affectationsResp->json() : [];

        $passagersResp = $this->api->get('/admin/passagers');
        $passagers = $passagersResp->successful() ? $passagersResp->json() : [];

        return view('admin.billetterie.billets.index', compact(
            'billets',
            'affectations',
            'passagers'
        ));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'passagerId'        => 'nullable|integer',
            'affectationId'     => 'required|integer',
            'siegeId'           => 'nullable|integer',
            'modePaiement'      => 'required|string|max:50',
            'referencePaiement' => 'nullable|string|max:100',
        ]);

        $reference = !empty($validated['referencePaiement'])
            ? trim($validated['referencePaiement'])
            : 'BIL-' . now()->format('YmdHis') . '-' . strtoupper(bin2hex(random_bytes(2)));

        $payload = [
            'passagerId'        => !empty($validated['passagerId']) ? (int) $validated['passagerId'] : null,
            'affectationId'     => (int) $validated['affectationId'],
            'siegeId'           => !empty($validated['siegeId']) ? (int) $validated['siegeId'] : null,
            'modePaiement'      => $validated['modePaiement'],
            'referencePaiement' => $reference,
        ];

        $response = $this->api->post('/billets/acheter', $payload);

        if ($response->failed()) {
            $errorMsg = $response->json('message') ?? 'Erreur lors de l’émission du billet.';
            return back()->withInput()->with('error', $errorMsg);
        }

        return redirect()
            ->route('admin.billetterie.billets.index')
            ->with('success', 'Billet émis avec succès (Réf: ' . $reference . ').');
    }

    public function annuler($id)
    {
        $response = $this->api->patch("/billets/{$id}/annuler");

        if ($response->failed()) {
            $errorMsg = $response->json('message') ?? 'Impossible d’annuler ce billet.';
            return back()->with('error', $errorMsg);
        }

        return redirect()
            ->route('admin.billetterie.billets.index')
            ->with('success', 'Le billet a bien été annulé.');
    }
}
