<?php
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ProjectController;
use App\Http\Controllers\Admin\PaymentController;
use App\Http\Controllers\Admin\ComplainController;
use App\Http\Controllers\Admin\AgreementValidationController;

Route::middleware(['web','auth','role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

    // Dashboard export
    Route::get('/export', [DashboardController::class, 'export'])->name('export');

    /* ---------------- USERS ---------------- */
    Route::get('/users',                [UserController::class, 'index'])->name('users.index');
    Route::get('/users/{id}',           [UserController::class, 'show'])->name('users.show');
    Route::post('/users/{id}/suspend',  [UserController::class, 'suspend'])->name('users.suspend');
    Route::post('/users/{id}/activate', [UserController::class, 'activate'])->name('users.activate');

    /* ---------------- PROJECTS ---------------- */
    Route::get('/projects',              [ProjectController::class, 'index'])->name('projects.index');
    Route::get('/projects/{id}',         [ProjectController::class, 'show'])->name('projects.show');
    Route::post('/projects/{id}/approve',[ProjectController::class, 'approve'])->name('projects.approve');
    Route::post('/projects/{id}/reject', [ProjectController::class, 'reject'])->name('projects.reject');

    /* ---------------- PAYMENTS ---------------- */
    Route::get('/payments/{id}',         [PaymentController::class, 'show'])->name('payments.show');
    Route::post('/payments/{id}/approve',[PaymentController::class, 'approve'])->name('payments.approve');
    Route::post('/payments/{id}/reject', [PaymentController::class, 'reject'])->name('payments.reject');

    /* ---------------- COMPLAINTS ---------------- */
    Route::get('/complains', [ComplainController::class, 'index'])->name('complains.index');
    Route::get('/complains/{id}', [ComplainController::class, 'show'])->name('complains.show');

});

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\SocialAuthController;
use App\Http\Controllers\Auth\RegistrationFlowController;
use App\Http\Controllers\Auth\RedirectAfterLoginController;
use App\Http\Controllers\Customer\SearchController as SearchDevelopers;
use App\Http\Controllers\Developer\SearchController as SearchProjects;

Route::get('/', function () {
    return view('landing');
})->name('landing');

// Auth By Role
Route::middleware(['auth', 'role:consumer'])
    ->get('/consumer/dashboard', fn() => redirect()->route('dashboard'))
    ->name('consumer.dashboard');

Route::middleware(['auth', 'role:developer'])
    ->get('/developer/dashboard', fn() => redirect()->route('dashboard'))
    ->name('developer.dashboard');

Route::middleware(['auth', 'role:admin'])
    ->get('/admin/dashboard', [DashboardController::class, 'admin'])
    ->name('admin.dashboard');

// Redirect After Login
Route::middleware('auth')
    ->get('/redirect-after-login', RedirectAfterLoginController::class)
    ->name('redirect-after-login');

// Main dashbaord
Route::middleware(['auth'])
    ->get('/dashboard', [DashboardController::class, 'index'])
    ->name('dashboard');

// NEED CHANGE
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// socialite authentication
Route::get('/auth/{driver}', [SocialAuthController::class, 'redirect'])
    ->name('social.redirect');

Route::get('/auth/{driver}/callback', [SocialAuthController::class, 'callback'])
    ->name('social.callback');

// Registration flow routes
Route::middleware(['auth'])->group(function () {
    Route::get('/select-role', [RegistrationFlowController::class, 'showRoleSelection'])->name('select-role');
    Route::post('/select-role', [RegistrationFlowController::class, 'storeRole'])->name('select-role.store');

    Route::get('/personal-information', [RegistrationFlowController::class, 'showPersonalInformation'])->name('personal-information');
    Route::post('/personal-information', [RegistrationFlowController::class, 'storePersonalInformation'])->name('personal-information.store');

    Route::get('/developer/information', [RegistrationFlowController::class, 'showDeveloperInformation'])->name('developer.information');
    Route::post('/developer/information', [RegistrationFlowController::class, 'storeDeveloperInformation'])->name('developer.information.store');
});

// Search for Developers (public access - as guest or authenticated)
Route::get('/search/developers', [SearchDevelopers::class, 'index'])
    ->name('search.developers');
Route::get('/search/developers/{id}', [SearchDevelopers::class, 'show'])
    ->name('search.developers.show');

// Search for Projects (public access - for developers)
Route::get('/search/projects', [SearchProjects::class, 'index'])
    ->name('search.projects');
Route::get('/search/projects/{id}', [SearchProjects::class, 'show'])
    ->name('search.projects.show');

require __DIR__ . '/auth.php';

// CHAT ROUTING
use App\Http\Controllers\Chat\ConversationController;
use App\Http\Controllers\Chat\MessageController;
use App\Http\Controllers\Chat\AgreementController;

Route::middleware('auth')->prefix('chat')->group(function () {
    Route::get('conversations', [ConversationController::class, 'index']);
    Route::post('conversations', [ConversationController::class, 'store']);
    Route::get('conversations/{conversation}', [ConversationController::class, 'show']);
    Route::get('conversations/{conversation}/messages', [MessageController::class, 'index']);
    Route::post('conversations/{conversation}/messages', [MessageController::class, 'send']);
    Route::post('conversations/{conversation}/read', [MessageController::class, 'markRead']);
    Route::post('conversations/{conversation}/agreements', [AgreementController::class, 'send']);
    Route::patch('agreements/{agreement}', [AgreementController::class, 'updateStatus']);
});

// COSTUMER SERVICE ROUTING
Route::get('/chat/admin', function () {return redirect('/chat?user=admin');})->name('chat.admin');


// DEVELOPER ROUTING
use App\Http\Controllers\Developer\AgreementController as DevAgreement;
use App\Http\Controllers\Developer\OfferController as DevOffer;
use App\Http\Controllers\Developer\ProjectController as DevProject;
use App\Http\Controllers\Developer\EarningsController as DevEarnings;
use App\Http\Controllers\Developer\SearchController as DevSearch;

Route::middleware(['auth', 'role:developer'])->prefix('developer')->as('developer.')->group(function () {

    /* ---------- Agreements (active / completed) ---------- */
    Route::get('/agreements', [DevAgreement::class, 'index'])
        ->name('agreements.index');
    Route::get('/agreements/{agreement}', [DevAgreement::class, 'show'])
        ->name('agreements.show');

    /* ---------- My Offers (penawaran saya) ---------- */
    Route::get('/offers', [DevOffer::class, 'index'])
        ->name('offers.index');
    Route::delete('/offers/{offer}', [DevOffer::class, 'destroy'])
        ->name('offers.destroy');   // withdraw

    /* ---------- Browse Open Projects ---------- */
    Route::get('/projects', [DevProject::class, 'index'])
        ->name('projects.index');
    Route::get('/projects/{project}', [DevProject::class, 'show'])
        ->name('projects.show');

    /* ---------- Earnings & Payment History ---------- */
    Route::get('/earnings', [DevEarnings::class, 'index'])
        ->name('earnings.index');

    /* ---------- Search (API) ---------- */
    Route::get('/search', [DevSearch::class, 'index'])
        ->name('search');
});

// ADMIN ESCROW ROUTING
use App\Http\Controllers\Admin\EscrowController;

Route::middleware(['auth', 'role:admin'])->prefix('admin')->as('admin.')->group(function () {
    Route::get('/escrow', [EscrowController::class, 'index'])->name('escrow.index');
    Route::post('/escrow/{id}/confirm', [EscrowController::class, 'confirm'])->name('escrow.confirm');
    Route::post('/escrow/{id}/transfer', [EscrowController::class, 'transfer'])->name('escrow.transfer');
    Route::post('/escrow/{id}/refund', [EscrowController::class, 'refund'])->name('escrow.refund');
});


// CUSTOMER ROUTING
use App\Http\Controllers\Customer\ProjectController as CustProject;
    // Agreement Detail Controller & Payment Controller
    use App\Http\Controllers\Customer\AgreementDetailController As AgreementDetail;
    use App\Http\Controllers\Customer\CheckoutController as PaymentCheckout;

Route::middleware(['auth', 'role:consumer'])->prefix('consumer')->as('consumer.')->group(function () {
    Route::resource('project', CustProject::class);

    /* ---------- custom CREATE (view) ---------- */
    Route::get('project/create/skills',      [CustProject::class, 'createSkills'])->name('project.createSkills');
    Route::get('project/create/budget',      [CustProject::class, 'createBudget'])->name('project.createBudget');
    Route::get('project/create/requirements',  [CustProject::class, 'createRequirements'])->name('project.createRequirements');

    /* ---------- Agreement Detail & Payment Detail ---------- */
    Route::get('/agreements/{agreement}', [AgreementDetail::class, 'show'])
        ->name('payments.offer-detail');

    // payment flow
    Route::get('/payments/create/{agreement}', [PaymentCheckout::class, 'create'])->name('payments.create');
    Route::get('/payments/checkout/{payment}', [PaymentCheckout::class, 'checkout'])->name('payments.checkout');

    Route::post('/payments/checkout/{payment}', [PaymentCheckout::class, 'checkout'])->name('payments.checkout');
    Route::post('/payments/confirm/{payment}', [PaymentCheckout::class, 'confirm'])->name('payments.confirm');

    // Additional custom routes (must be registered manually)
    Route::post('project/store-details',     [CustProject::class, 'storeDetails'])->name('project.storeDetails');
    Route::post('project/store-skills',      [CustProject::class, 'storeSkills'])->name('project.storeSkills');
    Route::post('project/store-budget',      [CustProject::class, 'storeBudget'])->name('project.storeBudget');
    Route::post('project/store-requirements',  [CustProject::class, 'storeRequirements'])->name('project.storeRequirements');
    Route::post('project/reset-session',     [CustProject::class, 'resetSession'])->name('project.resetSession');
});