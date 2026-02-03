<?php

use App\Http\Controllers\ChangelogController;
use App\Http\Controllers\ConfigurationController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\HelpCenterController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PeopleController;
use App\Http\Controllers\TermsController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('admin.dashboard');
    }
    return view('auth.login');
});



Route::name('admin.')->middleware(['auth', 'check.active'])->group(function () {

    //inqulinos
    Route::get('/inquilinos', [PeopleController::class, 'index'])->name('people.index');

    //notificações
    Route::get('/notificacoes', [NotificationController::class, 'index'])->name('notification.index');
    Route::get('/notificacoes/criar', [NotificationController::class, 'create'])->middleware('can:super-admin-access')->name('notification.create');
    Route::post('/notificacoes/enviar', [NotificationController::class, 'store'])->middleware('can:super-admin-access')->name('notification.store');
    Route::get('/notificacoes/mostrar/{id}', [NotificationController::class, 'show'])->name('notification.show');

    //helpcenter
    Route::get('helpcenter', [HelpCenterController::class, 'index'])->name('helpcenter.index');

    //rotas changelog
    Route::get('/suporte/changelog', [ChangelogController::class, 'index'])->name('changelog.index');
    Route::get('/suporte/changelog/criar', [ChangelogController::class, 'create'])->middleware('can:super-admin-access')->name('changelog.create');
    Route::post('/suporte/changelog', [ChangelogController::class, 'store'])->middleware('can:super-admin-access')->name('changelog.store');

    //rota termos
    Route::get('/suporte/termos', [TermsController::class, 'show'])->name('terms.show');


    // Perfil do usuário
    Route::get('usuarios/', [UserController::class, 'index'])->middleware('can:super-admin-access')->name('user.index');
    Route::get('usuarios/criar', [UserController::class, 'create'])->middleware('can:super-admin-access')->name('user.create');
    Route::get('usuarios/{id}/editar', [UserController::class, 'edit'])->middleware('can:user-access')->name('user.edit');
    Route::get('usuarios/inativos', [UserController::class, 'usersInativos'])->middleware('can:super-admin-access')->name('user.inativos');
    Route::post('usuarios/store', [UserController::class, 'store'])->middleware('can:user-access')->name('user.store');
    Route::get('usuario/{id}', [UserController::class, 'show'])->middleware('can:user-access')->name('user.perfil.show');
    Route::put('usuario/update/{id}', [UserController::class, 'update'])->middleware('can:user-access')->name('user.perfil.update');
    Route::put('usuario/update/password/{id}', [UserController::class, 'updatePassword'])->middleware('can:user-access')->name('user.perfil.updatePassword');

    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
});
