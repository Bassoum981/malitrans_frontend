<?php

use App\Http\Controllers\Admin\ExploitationAdminController;
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
    Route::get('/employes/chauffeurs/create', [AdminEmployeController::class, 'createChauffeur'])->name('chauffeurs.create');
    Route::get('/employes/chauffeurs', [AdminEmployeController::class, 'indexChauffeurs'])->name('chauffeurs.index');
    Route::post('/employes/chauffeurs', [AdminEmployeController::class, 'storeChauffeur'])->name('chauffeurs.store');
    Route::put('/employes/chauffeurs/{id}', [AdminEmployeController::class, 'updateChauffeur'])->name('chauffeurs.update');
    Route::delete('/employes/chauffeurs/{id}', [AdminEmployeController::class, 'destroyChauffeur'])->name('chauffeurs.destroy');

    // 2. Caissiers
    Route::get('/employes/caissiers/create', [AdminEmployeController::class, 'createCaissier'])->name('caissiers.create');
    Route::get('/employes/caissiers', [AdminEmployeController::class, 'indexCaissiers'])->name('caissiers.index');
    Route::post('/employes/caissiers', [AdminEmployeController::class, 'storeCaissier'])->name('caissiers.store');
    Route::put('/employes/caissiers/{id}', [AdminEmployeController::class, 'updateCaissier'])->name('caissiers.update');
    Route::delete('/employes/caissiers/{id}', [AdminEmployeController::class, 'destroyCaissier'])->name('caissiers.destroy');

    // 3. Mécaniciens
    Route::get('/employes/mecaniciens/create', [AdminEmployeController::class, 'createMecanicien'])->name('mecaniciens.create');
    Route::get('/employes/mecaniciens', [AdminEmployeController::class, 'indexMecaniciens'])->name('mecaniciens.index');
    Route::post('/employes/mecaniciens', [AdminEmployeController::class, 'storeMecanicien'])->name('mecaniciens.store');
    Route::put('/employes/mecaniciens/{id}', [AdminEmployeController::class, 'updateMecanicien'])->name('mecaniciens.update');
    Route::delete('/employes/mecaniciens/{id}', [AdminEmployeController::class, 'destroyMecanicien'])->name('mecaniciens.destroy');

    // 4. Responsables de Flotte
    Route::get('/employes/responsables-flotte/create', [AdminEmployeController::class, 'createResponsableFlotte'])->name('responsables-flotte.create');
    Route::get('/employes/responsables-flotte', [AdminEmployeController::class, 'indexResponsablesFlotte'])->name('responsables-flotte.index');
    Route::post('/employes/responsables-flotte', [AdminEmployeController::class, 'storeResponsableFlotte'])->name('responsables-flotte.store');
    Route::put('/employes/responsables-flotte/{id}', [AdminEmployeController::class, 'updateResponsableFlotte'])->name('responsables-flotte.update');
    Route::delete('/employes/responsables-flotte/{id}', [AdminEmployeController::class, 'destroyResponsableFlotte'])->name('responsables-flotte.destroy');

    // 5. Agents d'Exploitation
    Route::get('/employes/agents-exploitation/create', [AdminEmployeController::class, 'createAgentExploitation'])->name('agents-exploitation.create');
    Route::get('/employes/agents-exploitation', [AdminEmployeController::class, 'indexAgentsExploitation'])->name('agents-exploitation.index');
    Route::post('/employes/agents-exploitation', [AdminEmployeController::class, 'storeAgentExploitation'])->name('agents-exploitation.store');
    Route::put('/employes/agents-exploitation/{id}', [AdminEmployeController::class, 'updateAgentExploitation'])->name('agents-exploitation.update');
    Route::delete('/employes/agents-exploitation/{id}', [AdminEmployeController::class, 'destroyAgentExploitation'])->name('agents-exploitation.destroy');

    // --- 6. Gestion des Véhicules (Bus) ---
    Route::get('/vehicules/create', [ExploitationAdminController::class, 'createVehicule'])->name('vehicules.create');
    Route::get('/vehicules', [ExploitationAdminController::class, 'indexVehicules'])->name('vehicules.index');
    Route::post('/vehicules', [ExploitationAdminController::class, 'storeVehicule'])->name('vehicules.store');
    Route::put('/vehicules/{id}', [ExploitationAdminController::class, 'updateVehicule'])->name('vehicules.update');
    Route::delete('/vehicules/{id}', [ExploitationAdminController::class, 'destroyVehicule'])->name('vehicules.destroy');

    // --- 7. Gestion des Affectations ---
    Route::get('/affectations/create', [ExploitationAdminController::class, 'createAffectation'])->name('affectations.create');
    Route::get('/affectations', [ExploitationAdminController::class, 'indexAffectations'])->name('affectations.index');
    Route::post('/affectations', [ExploitationAdminController::class, 'storeAffectation'])->name('affectations.store');
    Route::put('/affectations/{id}', [ExploitationAdminController::class, 'updateAffectation'])->name('affectations.update');
    Route::delete('/affectations/{id}', [ExploitationAdminController::class, 'destroyAffectation'])->name('affectations.destroy');
});
