    <?php

    use App\Http\Controllers\AdminController;
    use App\Http\Controllers\DriveController;
    use App\Http\Controllers\RuteController;
    use App\Http\Controllers\TransactionController;
    use App\Http\Controllers\UserHomeController;
    use App\Http\Controllers\ReportController;
    use App\Http\Controllers\DriverChartController;
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Facades\Redirect;
    use Illuminate\Support\Facades\Route;

    /*
    |--------------------------------------------------------------------------
    | Web Routes
    |--------------------------------------------------------------------------
    |
    | Here is where you can register web routes for your application. These
    | routes are loaded by the RouteServiceProvider within a group which
    | contains the "web" middleware group. Now create something great!
    |
    */

    Route::get('/', function () {
        return view('auth/login');
    });
    Route::get('/home', [AdminController::class, 'index'])->name('admin.dashboard')->middleware(['auth', 'admin']);
    Route::get('/home', [UserHomeController::class, 'index'])->name('konsumen.dashboard')->middleware(['auth', 'konsumen']);
    // Route::get('/home', [UserHomeController::class, 'index'])->name('konsumen.dashboard')->middleware(['auth', 'konsumen']);

    Auth::routes();

    Route::group([
        'prefix' => 'admin',
        'middleware' => ['auth', 'admin']
    ], function () {
        Route::get('/home', [AdminController::class, 'index'])->name('admin.dashboard');

        Route::prefix('drivers')->group(function () {
            Route::get('/list', [DriveController::class, 'index'])->name('drivers.index');
            Route::get('/edit/{id}', [DriveController::class, 'edit'])->name('drivers.edit');
            Route::post('/store', [DriveController::class, 'store'])->name('drivers.store');
            Route::put('/update/{id}', [DriveController::class, 'update'])->name('drivers.update');
            Route::delete('/delete/{id}', [DriveController::class, 'delete'])->name('drivers.delete');
        });
        Route::prefix('rutes')->group(function () {
            Route::get('/list', [RuteController::class, 'index'])->name('rutes.index');
            Route::get('/edit/{id}', [RuteController::class, 'edit'])->name('rutes.edit');
            Route::post('/store', [RuteController::class, 'store'])->name('rutes.store');
            Route::put('/update/{id}', [RuteController::class, 'update'])->name('rutes.update');
            Route::delete('/delete/{id}', [RuteController::class, 'delete'])->name('rutes.delete');
        });

        Route::prefix('transactions')->group(function () {
            Route::get('/list', [TransactionController::class, 'index'])->name('transactions.index');
            Route::get('/edit/{id}', [TransactionController::class, 'edit'])->name('transactions.edit');
            Route::post('/store', [TransactionController::class, 'store'])->name('transactions.store');
            Route::get('/show/{id}', [TransactionController::class, 'show'])->name('transactions.show');
            Route::put('/update/{id}', [TransactionController::class, 'update'])->name('transactions.update');
            Route::delete('/delete/{id}', [TransactionController::class, 'delete'])->name('transactions.delete');
        });
        Route::prefix('report')->group(function () {
            Route::get('/list', [ReportController::class, 'index'])->name('reports.index');
            Route::get('/driver-charts', [DriverChartController::class, 'driverDistanceCostChart'])
                ->name('reports.driver_distance_cost');
        });
    });
