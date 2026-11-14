<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class EnsureAdminAuthenticated
{
public function handle(Request $request, Closure $next): Response
{
// Vérifie si le token d'authentification admin existe en session
if (!Session::has('admin_token')) {
return redirect()->route('admin.login')
->withErrors(['email' => 'Veuillez vous connecter pour accéder à l’administration.']);
}

return $next($request);
}
}
