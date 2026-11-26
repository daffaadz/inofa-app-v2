<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ProjectController;
use App\Http\Controllers\Admin\PaymentController;
use App\Http\Controllers\Admin\ComplaintController as AdminComplaintController;
use App\Http\Controllers\Admin\AgreementValidationController;

Route::middleware(['web', 'auth', 'role:admin'])
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
        Route::post('/projects/{id}/approve', [ProjectController::class, 'approve'])->name('projects.approve');
        Route::post('/projects/{id}/reject', [ProjectController::class, 'reject'])->name('projects.reject');

        /* ---------------- PAYMENTS ---------------- */
        Route::get('/payments/{id}',         [PaymentController::class, 'show'])->name('payments.show');
        Route::post('/payments/{id}/approve', [PaymentController::class, 'approve'])->name('payments.approve');
        Route::post('/payments/{id}/reject', [PaymentController::class, 'reject'])->name('payments.reject');
        Route::post('/payments/{id}/review', [PaymentController::class, 'review'])->name('payments.review');
        Route::post('/payments/{id}/transfer', [PaymentController::class, 'transfer'])->name('payments.transfer');

        /* ---------------- COMPLAINTS ---------------- */
        Route::get('/complaints', [AdminComplaintController::class, 'index'])->name('complaints.index');
        Route::get('/complaints/{id}', [AdminComplaintController::class, 'show'])->name('complaints.show');
        Route::get('/complaints/{id}/response', [AdminComplaintController::class, 'response'])->name('complaints.response');
        Route::patch('/complaints/{id}/resolve', [AdminComplaintController::class, 'resolve'])->name('complaints.resolve');
        Route::patch('/complaints/{id}/reject', [AdminComplaintController::class, 'reject'])->name('complaints.reject');
    });

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\SocialAuthController;
use App\Http\Controllers\Auth\RegistrationFlowController;
use App\Http\Controllers\Auth\RedirectAfterLoginController;
use App\Http\Controllers\Customer\SearchController as SearchDevelopers;
use App\Http\Controllers\Developer\SearchController as SearchProjects;
use App\Http\Controllers\Developer\SkillController;
use App\Http\Controllers\PortfolioController;
use App\Http\Controllers\Developer\PortfolioController as DevPortfolio;
use App\Http\Controllers\ComplaintController;

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
Route::middleware(['auth', 'admin.access'])
    ->get('/dashboard', [DashboardController::class, 'index'])
    ->name('dashboard');

// Complaint routes
Route::middleware(['auth', 'admin.access'])->group(function () {
    Route::post('/complaints', [ComplaintController::class, 'store'])->name('complaints.store');
    Route::get('/complaints', [ComplaintController::class, 'index'])->name('complaints.index');
    Route::get('/complaints/{id}', [ComplaintController::class, 'show'])->name('complaints.show');
});

// Profile Management
Route::middleware(['auth', 'admin.access'])->group(function () {
    // Profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Password update route
    Route::put('/password', [ProfileController::class, 'updatePassword'])->name('password.update');

    // Avatar update route
    Route::post('/profile/avatar', [ProfileController::class, 'updateAvatar'])->name('profile.avatar.update');

    // Availability update route (for developers)
    Route::post('/profile/availability', [ProfileController::class, 'updateAvailability'])->name('profile.availability.update');

    // Skills routes (for developers only)
    Route::middleware('role:developer')->group(function () {
        Route::get('/profile/skills/search', [SkillController::class, 'search'])->name('skills.search');
        Route::post('/profile/skills', [SkillController::class, 'store'])->name('skills.store');
        Route::delete('/profile/skills/{skill}', [SkillController::class, 'destroy'])->name('skills.destroy');
        Route::patch('/profile/skills/{skill}/proficiency', [SkillController::class, 'updateProficiency'])->name('skills.proficiency');

        // Education routes
        Route::post('/profile/education', [ProfileController::class, 'storeEducation'])->name('education.store');
        Route::delete('/profile/education/{index}', [ProfileController::class, 'destroyEducation'])->name('education.destroy');

        // Certification routes
        Route::post('/profile/certifications', [ProfileController::class, 'storeCertification'])->name('certifications.store');
        Route::delete('/profile/certifications/{index}', [ProfileController::class, 'destroyCertification'])->name('certifications.destroy');

        // Portfolio routes
        Route::post('/profile/portfolios', [PortfolioController::class, 'store'])->name('portfolios.store');
        Route::patch('/profile/portfolios/{portfolio}', [DevPortfolio::class, 'update'])->name('portfolios.update');
        Route::delete('/profile/portfolios/{portfolio}', [PortfolioController::class, 'destroy'])->name('portfolios.destroy');
        Route::post('/profile/portfolios/{portfolio}/toggle-featured', [DevPortfolio::class, 'toggleFeatured'])->name('portfolios.toggle-featured');

        // Payment details route
        Route::patch('/profile/payment-details', [ProfileController::class, 'updatePaymentDetails'])->name('profile.payment-details.update');
    });
});

// socialite authentication
Route::get('/auth/{driver}', [SocialAuthController::class, 'redirect'])
    ->name('social.redirect');

Route::get('/auth/{driver}/callback', [SocialAuthController::class, 'callback'])
    ->name('social.callback');

// Registration flow routes
Route::middleware(['auth', 'admin.access'])->group(function () {
    Route::get('/select-role', [RegistrationFlowController::class, 'showRoleSelection'])->name('select-role');
    Route::post('/select-role', [RegistrationFlowController::class, 'storeRole'])->name('select-role.store');

    Route::get('/personal-information', [RegistrationFlowController::class, 'showPersonalInformation'])->name('personal-information');
    Route::post('/personal-information', [RegistrationFlowController::class, 'storePersonalInformation'])->name('personal-information.store');

    Route::get('/developer/information', [RegistrationFlowController::class, 'showDeveloperInformation'])->name('developer.information');
    Route::post('/developer/information', [RegistrationFlowController::class, 'storeDeveloperInformation'])->name('developer.information.store');
});

// Search for Developers (requires authentication)
Route::middleware(['auth', 'admin.access'])->group(function () {
    Route::get('/search/developers', [SearchDevelopers::class, 'index'])
        ->name('search.developers');
    Route::get('/search/developers/{id}', [SearchDevelopers::class, 'show'])
        ->name('search.developers.show');

    // Search for Projects (for developers)
    Route::get('/search/projects', [SearchProjects::class, 'index'])
        ->name('search.projects');
    Route::get('/search/projects/{id}', [SearchProjects::class, 'show'])
        ->name('search.projects.show');
});

require __DIR__ . '/auth.php';

// PROPOSAL ROUTING
use App\Http\Controllers\ProposalController;

// Proposal Routes
Route::middleware(['auth', 'admin.access'])->group(function () {
    // Hanya developer yang bisa membuat proposal
    Route::middleware(['role:developer'])->group(function () {
        Route::get('/proposals/create', [ProposalController::class, 'create'])
            ->name('proposals.create');
        Route::post('/proposals', [ProposalController::class, 'store'])
            ->name('proposals.store');
        Route::get('/proposals/{agreement}/edit', [ProposalController::class, 'edit'])
            ->name('proposals.edit');
        Route::put('/proposals/{agreement}', [ProposalController::class, 'update'])
            ->name('proposals.update');
        Route::post('/projects/{project}/quick-apply', [ProposalController::class, 'quickApply'])
            ->name('projects.quick-apply');
    });

    // Client (consumer) yang bisa accept/reject
    Route::middleware(['role:consumer'])->group(function () {
        Route::post('/proposals/{agreementId}/accept', [ProposalController::class, 'accept'])
            ->name('proposals.accept');
        Route::post('/proposals/{agreementId}/reject', [ProposalController::class, 'reject'])
            ->name('proposals.reject');
    });
});

// DEVELOPER ROUTING
use App\Http\Controllers\Developer\AgreementController as DevAgreement;
use App\Http\Controllers\Developer\ProjectController as DevProject;
use App\Http\Controllers\Developer\EarningsController as DevEarnings;
use App\Http\Controllers\Developer\SearchController as DevSearch;

Route::middleware(['auth', 'role:developer'])->prefix('developer')->as('developer.')->group(function () {

    /* ---------- Agreements (active / completed) ---------- */
    Route::get('/agreements', [DevAgreement::class, 'index'])
        ->name('agreements.index');
    Route::get('/agreements/{agreement}', [DevAgreement::class, 'show'])
        ->name('agreements.show');
    Route::patch('/agreements/{agreement}/progress', [DevAgreement::class, 'updateProgress'])
        ->name('agreements.updateProgress');
    Route::post('/agreements/{agreement}/terminate', [DevAgreement::class, 'terminate'])
        ->name('agreements.terminate');

    /* ---------- Proposals (pending / accepted) ---------- */
    Route::get('/proposals', [DevAgreement::class, 'proposals'])
        ->name('proposals.index');

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
use App\Http\Controllers\Customer\AgreementController as CustAgreement;
use App\Http\Controllers\Customer\AgreementDetailController as AgreementDetail;
use App\Http\Controllers\Customer\CheckoutController as PaymentCheckout;
use App\Http\Controllers\Customer\ProposalsController;
use App\Http\Controllers\Customer\ReviewController;

Route::middleware(['auth', 'role:consumer'])->prefix('consumer')->as('consumer.')->group(function () {
    Route::resource('project', CustProject::class)->except('edit');

    /* ---------- custom CREATE (view) ---------- */
    Route::get('project/create/skills',      [CustProject::class, 'createSkills'])->name('project.createSkills');
    Route::get('project/create/budget',      [CustProject::class, 'createBudget'])->name('project.createBudget');
    Route::get('project/create/requirements',  [CustProject::class, 'createRequirements'])->name('project.createRequirements');

    /* ---------- Agreement Management ---------- */
    Route::post('/agreements/{agreement}/complete', [CustAgreement::class, 'complete'])->name('agreements.complete');
    Route::post('/agreements/{agreement}/stop', [CustAgreement::class, 'stop'])->name('agreements.stop');

    /* ---------- Review Management ---------- */
    Route::post('/agreements/{agreement}/review', [ReviewController::class, 'store'])->name('agreements.review');

    /* ---------- Agreement Detail & Payment Detail ---------- */
    Route::get('/agreements/{agreement}', [AgreementDetail::class, 'show'])
        ->name('payments.agreement-detail');

    // payment flow
    Route::get('/payments/create/{agreement}', [PaymentCheckout::class, 'create'])->name('payments.create');
    Route::get('/payments/checkout/{payment}', [PaymentCheckout::class, 'checkout'])->name('payments.checkout');

    Route::post('/payments/checkout/{payment}', [PaymentCheckout::class, 'checkout'])->name('payments.checkout.process');
    Route::post('/payments/confirm/{payment}', [PaymentCheckout::class, 'confirm'])->name('payments.confirm');

    /* ---------- Proposals Management ---------- */
    Route::get('/proposals', [ProposalsController::class, 'index'])->name('proposals.index');

    // Additional custom routes (must be registered manually)
    Route::post('project/store-details',     [CustProject::class, 'storeDetails'])->name('project.storeDetails');
    Route::post('project/store-skills',      [CustProject::class, 'storeSkills'])->name('project.storeSkills');
    Route::post('project/store-budget',      [CustProject::class, 'storeBudget'])->name('project.storeBudget');
    Route::post('project/store-requirements',  [CustProject::class, 'storeRequirements'])->name('project.storeRequirements');
    Route::post('project/reset-session',     [CustProject::class, 'resetSession'])->name('project.resetSession');
});


/**
 * -----------------------------------------------------------------
 * CHATIFY OVERRIDE ROUTES
 * -----------------------------------------------------------------
 */

use App\Http\Controllers\Chat\MessagesController;

Route::group([
    'middleware' => config('chatify.routes.middleware'),
    'prefix' => config('chatify.routes.prefix'),
], function () {

    // 1. View Index
    Route::get('/', [MessagesController::class, 'index'])->name('chat');

    // 2. Fetch Info
    Route::post('/idInfo', [MessagesController::class, 'idFetchData']);

    // 3. Send Message
    Route::post('/sendMessage', [MessagesController::class, 'send'])->name('send.message');

    // 4. Fetch Messages
    Route::post('/fetchMessages', [MessagesController::class, 'fetch'])->name('fetch.messages');

    // 5. Download
    Route::get('/download/{fileName}', [MessagesController::class, 'download'])->name(config('chatify.attachments.download_route_name'));

    // 6. Auth Pusher
    Route::post('/chat/auth', [MessagesController::class, 'pusherAuth'])->name('pusher.auth');

    // 7. Make Seen
    Route::post('/makeSeen', [MessagesController::class, 'seen'])->name('messages.seen');

    // 8. Get Contacts
    Route::get('/getContacts', [MessagesController::class, 'getContacts'])->name('contacts.get');

    // 9. Update Contact
    Route::post('/updateContacts', [MessagesController::class, 'updateContactItem'])->name('contacts.update');

    // 10. Favorites
    Route::post('/star', [MessagesController::class, 'favorite'])->name('star');
    Route::post('/favorites', [MessagesController::class, 'getFavorites'])->name('favorites');

    // 11. Search
    Route::get('/search', [MessagesController::class, 'search'])->name('search');

    // 12. Shared Photos
    Route::post('/shared', [MessagesController::class, 'sharedPhotos'])->name('shared');

    // 13. Delete Conversation/Message
    Route::post('/deleteConversation', [MessagesController::class, 'deleteConversation'])->name('conversation.delete');
    Route::post('/deleteMessage', [MessagesController::class, 'deleteMessage'])->name('message.delete');

    // 14. Settings & Status
    Route::post('/updateSettings', [MessagesController::class, 'updateSettings'])->name('avatar.update');
    Route::post('/setActiveStatus', [MessagesController::class, 'setActiveStatus'])->name('activeStatus.set');

    // 15. Update Project Topic & Conversation Title
    Route::post('/update-project-topic/{conversationId}', [MessagesController::class, 'updateProjectTopic'])->name('chat.updateProjectTopic');
    Route::post('/update-conversation-title/{conversationId}', [MessagesController::class, 'updateConversationTitle'])->name('chat.updateConversationTitle');
    Route::post('/send-agreement-request/{conversationId}', [MessagesController::class, 'sendAgreementRequest'])->name('chat.sendAgreementRequest');

    // 16. Specific User/Group Routes (Harus ditaruh di akhir karena wildcard {id})
    Route::get('/group/{id}', [MessagesController::class, 'index'])->name('group');
    Route::get('/{id}', [MessagesController::class, 'index'])->name('user');

    // COSTUMER SERVICE ROUTING
    Route::get('/1',[MessagesController::class, 'index'])->name('chat.admin');
});
