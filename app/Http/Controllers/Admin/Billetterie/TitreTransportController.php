<?php

namespace App\Http\Controllers\Admin\Billetterie;

use App\Http\Controllers\Controller;
use App\Services\MaliTransApiService;
use Illuminate\Http\Request;

class TitreTransportController extends Controller
{
    public function __construct(private readonly MaliTransApiService $api) {}

    public function index()
    {
        $titresResp = $this->api->get('/titres-transport');
        $titresTransport = $titresResp->successful() ? $titresResp->json() : [];

        $passagersResp = $this->api->get('/admin/passagers');
        $passagers = $passagersResp->successful() ? $passagersResp->json() : [];

        return view('admin.billetterie.titres.index', compact(
            'titresTransport',
            'passagers'
        ));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'passagerId'        => 'required|integer',
            'modePaiement'      => 'required|string|max:50',
            'referencePaiement' => 'nullable|string|max:100',
        ]);

        $reference = !empty($validated['referencePaiement'])
            ? trim($validated['referencePaiement'])
            : 'ABO-' . now()->format('YmdHis') . '-' . strtoupper(bin2hex(random_bytes(2)));

        $payload = [
            'passagerId'        => (int) $validated['passagerId'],
            'modePaiement'      => $validated['modePaiement'],
            'referencePaiement' => $reference,
        ];

        $response = $this->api->post('/titres-transport/souscrire', $payload);

        if ($response->failed()) {
            $errorMsg = $response->json('message') ?? 'Erreur lors de la création du titre de transport.';
            return back()->withInput()->with('error', $errorMsg);
        }

        return redirect()
            ->route('admin.billetterie.titres.index')
            ->with('success', 'Titre de transport créé avec succès (Réf: ' . $reference . ').');
    }
}
