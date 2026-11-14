<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminEmployeController;
use App\Http\Controllers\AdminAuthController;

// Auth Admin
Route::get('/admin/login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
Route::post('/admin/login', [AdminAuthController::class, 'login'])->name('admin.login.submit');
Route::post('/admin/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

// Routes protégées par le middleware admin.auth
Route::middleware(['admin.auth'])->prefix('admin')->name('admin.')->group(function () {

    Route::get('/dashboard', fn() => view('admin.dashboard'))->name('dashboard');

    // 1. Chauffeurs
    Route::get('/employes/chauffeurs', [AdminEmployeController::class, 'indexChauffeurs'])->name('chauffeurs.index');
    Route::post('/employes/chauffeurs', [AdminEmployeController::class, 'storeChauffeur'])->name('chauffeurs.store');
    Route::delete('/employes/chauffeurs/{id}', [AdminEmployeController::class, 'destroyChauffeur'])->name('chauffeurs.destroy');

    // 2. Caissiers
    Route::get('/employes/caissiers', [AdminEmployeController::class, 'indexCaissiers'])->name('caissiers.index');
    Route::post('/employes/caissiers', [AdminEmployeController::class, 'storeCaissier'])->name('caissiers.store');
    Route::delete('/employes/caissiers/{id}', [AdminEmployeController::class, 'destroyCaissier'])->name('caissiers.destroy');

    // 3. Mécaniciens
    Route::get('/employes/mecaniciens', [AdminEmployeController::class, 'indexMecaniciens'])->name('mecaniciens.index');
    Route::post('/employes/mecaniciens', [AdminEmployeController::class, 'storeMecanicien'])->name('mecaniciens.store');
    Route::delete('/employes/mecaniciens/{id}', [AdminEmployeController::class, 'destroyMecanicien'])->name('mecaniciens.destroy');

    // 4. Responsables de Flotte
    Route::get('/employes/responsables-flotte', [AdminEmployeController::class, 'indexResponsablesFlotte'])->name('responsables-flotte.index');
    Route::post('/employes/responsables-flotte', [AdminEmployeController::class, 'storeResponsableFlotte'])->name('responsables-flotte.store');
    Route::delete('/employes/responsables-flotte/{id}', [AdminEmployeController::class, 'destroyResponsableFlotte'])->name('responsables-flotte.destroy');

    // 5. Agents d'Exploitation
    Route::get('/employes/agents-exploitation', [AdminEmployeController::class, 'indexAgentsExploitation'])->name('agents-exploitation.index');
    Route::post('/employes/agents-exploitation', [AdminEmployeController::class, 'storeAgentExploitation'])->name('agents-exploitation.store');
    Route::delete('/employes/agents-exploitation/{id}', [AdminEmployeController::class, 'destroyAgentExploitation'])->name('agents-exploitation.destroy');
});
