<?php
namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Client\Response;

class MaliTransApiService
{
    protected string $baseUrl;

    public function __construct()
    {
        // Récupère l'URL depuis config/services.php ou le fichier .env
        $this->baseUrl = config('services.springboot.url', 'http://localhost:8080/api');
    }

    /**
     * Crée une instance HTTP configurée avec le token JWT de l'admin.
     */
    protected function client()
    {
        $token = Session::get('admin_token');

        $pendingRequest = Http::baseUrl($this->baseUrl)
            ->acceptJson()
            ->timeout(10);

        if ($token) {
            $pendingRequest->withToken($token);
        }

        return $pendingRequest;
    }

    public function get(string $endpoint, array $query = []): Response
    {
        return $this->client()->get($endpoint, $query);
    }

    public function post(string $endpoint, array $data = []): Response
    {
        return $this->client()->post($endpoint, $data);
    }

    public function put(string $endpoint, array $data = []): Response
    {
        return $this->client()->put($endpoint, $data);
    }

    public function delete(string $endpoint): Response
    {
        return $this->client()->delete($endpoint);
    }
}
