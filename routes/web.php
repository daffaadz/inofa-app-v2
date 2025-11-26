<?php
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\DashboardController;

// Admin utilities: export + action stubs used by admin dashboard components
Route::middleware(['web','auth','role:admin'])->prefix('admin')->name('admin.')->group(function () {
    // Export endpoint used by filters component
    Route::get('/export', [DashboardController::class, 'export'])->name('export');

    // Sidebar target index pages (stubs)
    Route::get('/users', function (Request $request) {
        // Temporary inline admin users listing with basic search & role filter
        $query = \App\Models\User::query();

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%$search%")->orWhere('email', 'like', "%$search%");
            });
        }
        if ($role = $request->input('role')) {
            $query->where('role', $role); // assumes `role` column exists
        }

        $users = $query->orderByDesc('created_at')->paginate(15)->withQueryString();

        return view('admin.users.index', [
            'users' => $users,
            'search' => $search,
            'selectedRole' => $role,
        ]);
    })->name('users.index');

    Route::get('/projects', function (Request $request) {
        $query = \App\Models\Project::query();

        // Basic search by title
        if ($search = $request->input('search')) {
            $query->where('title', 'like', "%$search%");
        }
        // Optional status filter
        if ($status = $request->input('status')) {
            $query->where('status', $status);
        }

        $projects = $query->orderByDesc('created_at')->paginate(15)->withQueryString();

        $stats = [
            'total'     => \App\Models\Project::count(),
            'ongoing'   => \App\Models\Project::where('status', 'in_progress')->count(),
            'completed' => \App\Models\Project::where('status', 'completed')->count(),
            'budget'    => (float) \App\Models\Project::sum('budget'),
        ];

        return view('admin.projects.index', [
            'projects' => $projects,
            'stats'    => $stats,
            'search'   => $search,
            'status'   => $status,
        ]);
    })->name('projects.index');

    // Projects actions (stubs for now)
    Route::get('/projects/{id}', function (int $id) {
        return back()->with('info', 'Admin project view not implemented yet.');
    })->name('projects.show');
    Route::post('/projects/{id}/approve', function (int $id) {
        return back()->with('success', 'Project approved (stub).');
    })->name('projects.approve');
    Route::post('/projects/{id}/reject', function (Request $request, int $id) {
        return back()->with('warning', 'Project rejected (stub): '.$request->input('reason'));
    })->name('projects.reject');

    // Payments actions (stubs for now)
    Route::get('/payments/{id}', function (int $id) {
        return back()->with('info', 'Admin payment view not implemented yet.');
    })->name('payments.show');
    Route::post('/payments/{id}/approve', function (int $id) {
        return back()->with('success', 'Payment approved (stub).');
    })->name('payments.approve');
    Route::post('/payments/{id}/reject', function (Request $request, int $id) {
        return back()->with('warning', 'Payment rejected (stub): '.$request->input('reason'));
    })->name('payments.reject');

    // Complaints actions (stubs for now)
    Route::get('/complaints/{id}', function (int $id) {
        return back()->with('info', 'Complaint detail not implemented yet.');
    })->name('complaints.show');
    Route::post('/complaints/{id}/process', function (int $id) {
        return back()->with('success', 'Complaint marked in progress (stub).');
    })->name('complaints.process');
    Route::post('/complaints/{id}/close', function (Request $request, int $id) {
        return back()->with('success', 'Complaint closed (stub): '.$request->input('reason'));
    })->name('complaints.close');
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