<?php

use App\Http\Controllers\ChangelogController;
use App\Http\Controllers\ConfigurationController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\HelpCenterController;
use App\Http\Controllers\NotificationController;
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

    // configurações do sistema
    Route::resource('configurations', ConfigurationController::class)->middleware('can:super-admin-access');

    //rota para index do backup
    Route::get('backup', [ConfigurationController::class, 'backupPeopleIndex'])->name('backup.index');
    //rota para gerar backup
    Route::get('backup/generate', [ConfigurationController::class, 'generateBackup'])->name('backup.generate');
    //rota para download do backup
    Route::get('backup/download/{file}', [ConfigurationController::class, 'downloadBackup'])->name('backup.download');

    //notificações
    Route::get('/notificacoes', [NotificationController::class, 'index'])->name('notification.index');
    Route::get('/notificacoes/criar', [NotificationController::class, 'create'])->middleware('can:admin-or-super-admin')->name('notification.create');
    Route::post('/notificacoes/enviar', [NotificationController::class, 'store'])->middleware('can:admin-or-super-admin')->name('notification.store');
    Route::get('/notificacoes/mostrar/{id}', [NotificationController::class, 'show'])->name('notification.show');

    //Departamentos
    Route::get('departamentos/', [DepartmentController::class, 'index'])->middleware('can:super-admin-access')->name('departments.index');
    Route::get('departamento/cadastro', [DepartmentController::class, 'create'])->middleware('can:super-admin-access')->name('departments.create');
    Route::get('departamento/{id}/editar', [DepartmentController::class, 'edit'])->middleware('can:admin-or-super-admin')->name('departments.edit');
    Route::post('departamento/store', [DepartmentController::class, 'store'])->middleware('can:super-admin-access')->name('departments.store');
    Route::put('departmento/{id}/atualizar', [DepartmentController::class, 'update'])->middleware('can:admin-or-super-admin')->name('departments.update');


    //tickets
    Route::prefix('suporte')->name('suporte.')->group(function () {
        Route::get('tickets/', [TicketController::class, 'index'])->name('ticket.index');
        Route::get('ticket/criar', [TicketController::class, 'create'])->name('ticket.create');
        Route::get('/tickets/{uuid}', [TicketController::class, 'show'])->name('ticket.show');
    });

    //helpcenter
    Route::get('helpcenter', [HelpCenterController::class, 'index'])->name('helpcenter.index');

    //rotas changelog
    Route::get('/suporte/changelog', [ChangelogController::class, 'index'])->name('changelog.index');
    Route::get('/suporte/changelog/criar', [ChangelogController::class, 'create'])->middleware('can:super-admin-access')->name('changelog.create');
    Route::post('/suporte/changelog', [ChangelogController::class, 'store'])->middleware('can:super-admin-access')->name('changelog.store');

    // Perfil do usuário
    Route::get('usuarios/', [UserController::class, 'index'])->middleware('can:admin-or-super-admin')->name('user.index');
    Route::get('usuarios/criar', [UserController::class, 'create'])->middleware('can:admin-or-super-admin')->name('user.create');
    Route::get('usuarios/{id}/editar', [UserController::class, 'edit'])->middleware('can:user-access')->name('user.edit');
    Route::get('usuarios/inativos', [UserController::class, 'usersInativos'])->middleware('can:admin-or-super-admin')->name('user.inativos');
    Route::post('usuarios/store', [UserController::class, 'store'])->middleware('can:user-access')->name('user.store');
    Route::get('usuario/{id}', [UserController::class, 'show'])->middleware('can:user-access')->name('user.perfil.show');
    Route::put('usuario/update/{id}', [UserController::class, 'update'])->middleware('can:user-access')->name('user.perfil.update');
    Route::put('usuario/update/password/{id}', [UserController::class, 'updatePassword'])->middleware('can:user-access')->name('user.perfil.updatePassword');

    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('dashboard-analitico', [DashboardController::class, 'dashboardAnalitica'])->name('dashboard.analitico');

    Route::get('/admin/geocode-addresses', function () {
        \Illuminate\Support\Facades\Artisan::call('addresses:geocode', ['--limit' => 50]);
        return redirect()->back()->with('success', 'Geocodificação de 50 endereços iniciada em background.');
    })->name('geocode-addresses');

});
