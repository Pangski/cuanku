<?php

use App\Http\Controllers\{
    AnnualReportController,
    AssetController,
    BalanceController,
    BudgetController,
    DashboardController,
    ExpenseController,
    GoalController,
    IncomeController,
    LiabilityController,
    NetWorthAssetController,
    NetWorthController,
    NetWorthLiabilityController,
    PaymentController,
    PrivacyController,
    ProfileController,
    ReportTrackingController,
    TermAndConditionController
};
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('testing', fn () => Inertia::render('Testing'));

// Dashboard
Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

// Group routes with 'auth' middleware
Route::middleware('auth')->group(function () {

    // Payments
    Route::controller(PaymentController::class)->group(function () {
        Route::get('payments', 'index')->name('payments.index');
        Route::get('payments/create', 'create')->name('payments.create');
        Route::post('payments', 'store')->name('payments.store');
        Route::get('payments/{payment}/edit', 'edit')->name('payments.edit');
        Route::put('payments/{payment}', 'update')->name('payments.update');
        Route::delete('payments/{payment}', 'destroy')->name('payments.destroy');
    });

    // Goals & Balances
    Route::controller(GoalController::class)->group(function () {
        Route::get('goals', 'index')->name('goals.index');
        Route::get('goals/create', 'create')->name('goals.create');
        Route::post('goals', 'store')->name('goals.store');
        Route::get('goals/{goal}/edit', 'edit')->name('goals.edit');
        Route::put('goals/{goal}', 'update')->name('goals.update');
        Route::delete('goals/{goal}', 'destroy')->name('goals.destroy');
    });

    Route::controller(BalanceController::class)->group(function () {
        Route::get('goals/{goal}/balances', 'index')->name('balances.index');
        Route::get('goals/{goal}/balances/create', 'create')->name('balances.create');
        Route::post('goals/{goal}/balances', 'store')->name('balances.store');
        Route::delete('goals/{goal}/balances/{balance}', 'destroy')->name('balances.destroy');
    });

    // Budgets
    Route::controller(BudgetController::class)->group(function () {
        Route::get('budgets', 'index')->name('budgets.index');
        Route::get('budgets/create', 'create')->name('budgets.create');
        Route::post('budgets', 'store')->name('budgets.store');
        Route::get('budgets/{budget}/edit', 'edit')->name('budgets.edit');
        Route::put('budgets/{budget}', 'update')->name('budgets.update');
        Route::delete('budgets/{budget}', 'destroy')->name('budgets.destroy');
    });

    // Income & Expense
    foreach ([
        'incomes' => IncomeController::class,
        'expenses' => ExpenseController::class,
    ] as $prefix => $controller) {
        Route::controller($controller)->group(function () use ($prefix) {
            Route::get($prefix, 'index')->name("$prefix.index");
            Route::get("$prefix/create", 'create')->name("$prefix.create");
            Route::post($prefix, 'store')->name("$prefix.store");
            Route::get("$prefix/{id}/edit", 'edit')->name("$prefix.edit");
            Route::put("$prefix/{id}", 'update')->name("$prefix.update");
            Route::delete("$prefix/{id}", 'destroy')->name("$prefix.destroy");
        });
    }

    // Net Worth
    Route::controller(NetWorthController::class)->group(function () {
        Route::get('net-worths', 'index')->name('net-worths.index');
        Route::get('net-worths/create', 'create')->name('net-worths.create');
        Route::post('net-worths', 'store')->name('net-worths.store');
        Route::get('net-worths/{netWorth}/detail', 'show')->name('net-worths.show');
        Route::get('net-worths/{netWorth}/edit', 'edit')->name('net-worths.edit');
        Route::put('net-worths/{netWorth}', 'update')->name('net-worths.update');
        Route::delete('net-worths/{netWorth}', 'destroy')->name('net-worths.destroy');
    });

    // Asset & Liability
    Route::controller(AssetController::class)->group(function () {
        Route::get('net-worths/{netWorth}/assets', 'index')->name('assets.index');
        Route::get('net-worths/{netWorth}/assets/create', 'create')->name('assets.create');
        Route::post('net-worths/{netWorth}/assets', 'store')->name('assets.store');
        Route::get('net-worths/{netWorth}/assets/{asset}/edit', 'edit')->name('assets.edit');
        Route::put('net-worths/{netWorth}/assets/{asset}', 'update')->name('assets.update');
        Route::delete('net-worths/{netWorth}/assets/{asset}', 'destroy')->name('assets.destroy');
    });

    Route::post('net-worths/{netWorth}/assets/{asset}/net-worth-assets', NetWorthAssetController::class)->name('net-worth-asset');

    Route::controller(LiabilityController::class)->group(function () {
        Route::get('net-worths/{netWorth}/liabilities', 'index')->name('liabilities.index');
        Route::get('net-worths/{netWorth}/liabilities/create', 'create')->name('liabilities.create');
        Route::post('net-worths/{netWorth}/liabilities', 'store')->name('liabilities.store');
        Route::get('net-worths/{netWorth}/liabilities/{liability}/edit', 'edit')->name('liabilities.edit');
        Route::put('net-worths/{netWorth}/liabilities/{liability}', 'update')->name('liabilities.update');
        Route::delete('net-worths/{netWorth}/liabilities/{liability}', 'destroy')->name('liabilities.destroy');
    });

    Route::post('net-worths/{netWorth}/liabilities/{liability}/net-worth-liability', NetWorthLiabilityController::class)->name('net-worth-liability');

    // Reports
    Route::get('report-trackings', ReportTrackingController::class)->name('report-trackings');
    Route::get('report-trackings/download-pdf', [ReportTrackingController::class, 'downloadPdf'])->name('report-trackings.download-pdf');

    Route::get('annual-reports', [AnnualReportController::class, 'index'])->name('annual-reports');
    Route::get('annual-reports/download-pdf', [AnnualReportController::class, 'downloadPdf'])->name('annual-reports.download-pdf');

    // Static Pages
    Route::get('privacy', [PrivacyController::class, 'index'])->name('privacy.index');
    Route::get('term-and-condition', [TermAndConditionController::class, 'index'])->name('term-and-condition.index');

    // Profile
    Route::controller(ProfileController::class)->group(function () {
        Route::get('profile', 'edit')->name('profile.edit');
        Route::patch('profile', 'update')->name('profile.update');
        Route::delete('profile', 'destroy')->name('profile.destroy');
    });

});

require __DIR__.'/auth.php';
