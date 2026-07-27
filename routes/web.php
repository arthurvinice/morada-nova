<?php

use App\Http\Controllers\ChangelogController;
use App\Http\Controllers\ConfigurationController;
use App\Http\Controllers\ContractController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HelpCenterController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PeopleController;
use App\Http\Controllers\PropertyController;
use App\Http\Controllers\TermsController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('admin.dashboard');
    }
    return view('auth.login');
});

Route::get('/cadastro', [ConfigurationController::class, 'createPublic'])->name('configurations.create-public');

Route::name('admin.')->middleware(['auth', 'check.active'])->group(function () {

    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

    //inquilinos
    Route::get('/inquilinos', [PeopleController::class, 'index'])->name('people.index');
    Route::get('/inquilinos/cadastrar', [PeopleController::class, 'create'])->name('people.create');
    Route::get('/inquilinos/{people}/editar', [PeopleController::class, 'edit'])->name('people.edit');

    //propriedades
    Route::get('/propriedades', [PropertyController::class, 'index'])->name('properties.index');
    Route::get('/propriedades/cadastrar', [PropertyController::class, 'create'])->name('properties.create');
    Route::get('/propriedades/{property}/editar', [PropertyController::class, 'edit'])->name('properties.edit');

    //contratos
    Route::get('/contratos', [ContractController::class, 'index'])->name('contracts.index');
    Route::get('/contratos/cadastrar', [ContractController::class, 'create'])->name('contracts.create');
    Route::get('/contratos/{contract}/editar', [ContractController::class, 'edit'])->name('contracts.edit');

    //helpcenter
    Route::get('helpcenter', [HelpCenterController::class, 'index'])->name('helpcenter.index');

    //suporte
    Route::get('/suporte/changelog', [ChangelogController::class, 'index'])->name('changelog.index');
    Route::get('/suporte/termos', [TermsController::class, 'show'])->name('terms.show');

    //perfil (qualquer usuário autenticado edita o próprio perfil)
    Route::get('perfil', [UserController::class, 'show'])->name('user.perfil.show');

    //notificação
    Route::get('/notificacoes', [NotificationController::class, 'index'])->name('notification.index');
    Route::get('/notificacoes/criar', [NotificationController::class, 'create'])->name('notification.create');
    Route::post('/notificacoes/enviar', [NotificationController::class, 'store'])->name('notification.store');
    Route::get('/notificacoes/mostrar/{id}', [NotificationController::class, 'show'])->name('notification.show');

    //ROTAS ADMIN
    Route::middleware('can:admin-access')->group(function () {
        Route::get('usuarios', [UserController::class, 'index'])->name('user.index');
        Route::get('usuarios/criar', [UserController::class, 'create'])->name('user.create');
        Route::get('usuarios/{id}/editar', [UserController::class, 'edit'])->name('user.edit');
    });

    //ROTAS SOMENTE SUPERADMIN
    Route::middleware('can:super-admin-access')->group(function () {
        Route::get('/configuracoes', [ConfigurationController::class, 'index'])->name('configurations.index');
        Route::get('/configuracoes/cadastrar', [ConfigurationController::class, 'create'])->name('configurations.create');
        Route::get('/configuracoes/{configuration}/editar', [ConfigurationController::class, 'edit'])->name('configurations.edit');

        Route::get('/suporte/changelog/criar', [ChangelogController::class, 'create'])->name('changelog.create');
        Route::post('/suporte/changelog', [ChangelogController::class, 'store'])->name('changelog.store');
    });
});
