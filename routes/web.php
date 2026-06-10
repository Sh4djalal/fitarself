<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CarController;
use App\Http\Controllers\FaultCodeController;
use App\Http\Controllers\MechanicController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\LocaleController;
use App\Http\Controllers\ThemeController;
use App\Http\Controllers\Auth\OtpVerificationController;
use App\Http\Controllers\MechanicDocumentController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminRegisterController;
use App\Http\Controllers\Admin\AdminLoginController;
use App\Http\Controllers\Admin\AdminUsersController;
use App\Http\Controllers\UserCarController;
use App\Http\Controllers\SavedItemController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\CommunityController;
use App\Http\Controllers\SupportController;
use App\Http\Controllers\Admin\SupportController as AdminSupportController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Message;
use App\Models\OtpVerification;
use Illuminate\Http\Request;

// ============================================
// PUBLIC ROUTES
// ============================================
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/cars', [CarController::class, 'index'])->name('cars.index');
Route::get('/cars/model/{make}/{model}', [CarController::class, 'model'])->name('cars.model');
Route::get('/cars/{car}', [CarController::class, 'show'])->name('cars.show');
Route::get('/fault-codes', [FaultCodeController::class, 'index'])->name('fault-codes.index');
Route::get('/fault-codes/{faultCode}', [FaultCodeController::class, 'show'])->name('fault-codes.show');
Route::get('/mechanics', [MechanicController::class, 'index'])->name('mechanics.index');
Route::get('/mechanics/{mechanic}', [MechanicController::class, 'show'])->name('mechanics.show');
Route::get('/search', [SearchController::class, 'index'])->name('search');
Route::get('/language/{locale}', [LocaleController::class, 'switch'])->name('language.switch');
Route::post('/theme/toggle', [ThemeController::class, 'toggle'])->name('theme.toggle');
Route::get('/parts', [App\Http\Controllers\PartController::class, 'index'])->name('parts.index');
Route::get('/parts/{part}', [App\Http\Controllers\PartController::class, 'show'])->name('parts.show');

// Community Routes
Route::get('/community', [CommunityController::class, 'index'])->name('community.index');
Route::get('/community/search', [CommunityController::class, 'search'])->name('community.search');

// ============================================
// SUPPORT CHAT ROUTES
// ============================================
Route::get('/support/messages', [SupportController::class, 'index'])->name('support.messages');
Route::post('/support/send', [SupportController::class, 'send'])->name('support.send');
Route::post('/support/connect-agent', [SupportController::class, 'connectAgent'])->name('support.connect-agent');
Route::get('/support/check', [SupportController::class, 'checkNewMessages'])->name('support.check');

Route::get('/ads/click/{ad}', function ($adId) {
    $ad = \App\Models\Ad::findOrFail($adId);
    $ad->increment('clicks');
    return redirect($ad->link_url ?? '/');
});

Route::get('/api/search', function (Request $request) {
    $q = $request->get('q');
    $like = '%' . $q . '%';
    $cars = \App\Models\Car::where('make', 'like', $like)->orWhere('model', 'like', $like)->limit(8)->get(['id', 'make', 'model', 'year']);
    $faultCodes = \App\Models\FaultCode::where('code', 'like', $like)->orWhere('title_en', 'like', $like)->limit(8)->get(['id', 'code', 'title_en']);
    $mechanics = \App\Models\User::where('role', 'mechanic')->where(function ($query) use ($like) { 
        $query->where('name', 'like', $like)->orWhere('city', 'like', $like); 
    })->limit(5)->get(['id', 'name', 'city']);
    return response()->json(['cars' => $cars, 'faultCodes' => $faultCodes, 'mechanics' => $mechanics]);
});

// ============================================
// TEST ROUTES
// ============================================
Route::get('/test-gemini', function () {
    $response = Http::withoutVerifying()
        ->withHeaders(['Content-Type' => 'application/json'])
        ->post('https://generativelanguage.googleapis.com/v1beta/models/gemini-flash-latest:generateContent?key=' . env('GEMINI_API_KEY'), [
            'contents' => [['parts' => [['text' => 'Say hello']]]],
        ]);
    return ['status' => $response->status(), 'body' => $response->json()];
});

Route::get('/test-car-image/{make}/{model}/{year}', function ($make, $model, $year) {
    $unsplash = new \App\Services\UnsplashService();
    $image = $unsplash->searchCarImage($make, $model, $year);
    return response()->json($image);
});

Route::get('/test-otp', function () {
    $otp = OtpVerification::generateOtp();
    return response()->json(['otp' => $otp]);
});

// ============================================
// OTP VERIFICATION ROUTES
// ============================================
Route::get('/verify-otp', [OtpVerificationController::class, 'showForm'])->name('verification.otp.form');
Route::post('/verify-otp/send', [OtpVerificationController::class, 'sendOtp'])->name('verification.otp.send');
Route::post('/verify-otp/verify', [OtpVerificationController::class, 'verifyOtp'])->name('verification.otp.verify');
Route::post('/verify-otp/resend', [OtpVerificationController::class, 'resendOtp'])->name('verification.otp.resend');

// ============================================
// DASHBOARD ROUTES
// ============================================
Route::get('/dashboard', function () {
    $user = Auth::user();
    if (!$user) return redirect('/login');
    if ($user->role === 'mechanic') return redirect('/mechanic/dashboard');
    if ($user->role === 'admin') return redirect('/admin/dashboard');
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::get('/mechanic/dashboard', function () {
    return view('mechanic-dashboard');
})->middleware(['auth'])->name('mechanic.dashboard');

// ============================================
// MECHANIC DOCUMENT ROUTES
// ============================================
Route::middleware(['auth'])->group(function () {
    Route::get('/mechanic/verify', [MechanicDocumentController::class, 'showForm'])->name('mechanic.verify-form');
    Route::post('/mechanic/submit-documents', [MechanicDocumentController::class, 'submitDocuments'])->name('mechanic.submit-documents');
});

// ============================================
// ADMIN AUTH ROUTES
// ============================================
Route::get('/admin/register', [AdminRegisterController::class, 'showRegistrationForm'])->name('admin.register');
Route::post('/admin/register', [AdminRegisterController::class, 'register'])->name('admin.register.submit');
Route::get('/admin/login', [AdminLoginController::class, 'showLoginForm'])->name('admin.login');
Route::post('/admin/login', [AdminLoginController::class, 'login'])->name('admin.login.submit');
Route::post('/admin/logout', [AdminLoginController::class, 'logout'])->name('admin.logout');

// ============================================
// ADMIN DASHBOARD ROUTES
// ============================================
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('/verifications', [AdminDashboardController::class, 'verifications'])->name('admin.verifications');
    Route::get('/document/{id}', [AdminDashboardController::class, 'viewDocumentPage'])->name('admin.document.view');
    Route::post('/approve/{id}', [AdminDashboardController::class, 'approve'])->name('admin.approve');
    Route::post('/reject/{id}', [AdminDashboardController::class, 'reject'])->name('admin.reject');
    Route::delete('/delete/{id}', [AdminDashboardController::class, 'delete'])->name('admin.delete');
    Route::get('/file/{id}/{type}', [AdminDashboardController::class, 'viewDocument'])->name('admin.file');
    
    Route::get('/users', [AdminUsersController::class, 'index'])->name('admin.users');
    Route::get('/users/{id}', [AdminUsersController::class, 'show'])->name('admin.users.show');
    Route::delete('/users/{id}', [AdminUsersController::class, 'destroy'])->name('admin.users.destroy');
});

// ============================================
// PROFILE & EMAIL CHANGE ROUTES
// ============================================
Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    Route::get('/profile/{id}', [ProfileController::class, 'show'])->name('profile.show');
    
    Route::get('/profile/change-email', [ProfileController::class, 'showEmailChangeForm'])->name('profile.change-email');
    Route::post('/profile/send-email-otp', [ProfileController::class, 'sendEmailOtp'])->name('profile.send-email-otp');
    Route::get('/profile/verify-email', [ProfileController::class, 'showVerifyEmailChange'])->name('profile.verify-email');
    Route::post('/profile/verify-email-submit', [ProfileController::class, 'verifyEmailChange'])->name('profile.verify-email-submit');
    
    Route::post('/reviews', [ReviewController::class, 'store'])->name('reviews.store');
    Route::delete('/reviews/{review}', [ReviewController::class, 'destroy'])->name('reviews.destroy');
    
    Route::get('/my-reviews', [ReviewController::class, 'userReviews'])->name('user.reviews');
    
    Route::get('/saved-items', [SavedItemController::class, 'index'])->name('saved.items');
    
    Route::get('/chat', [App\Http\Controllers\ChatController::class, 'index'])->name('chat.index');
    Route::get('/chat/{conversationId}', [App\Http\Controllers\ChatController::class, 'show'])->name('chat.show');
    Route::post('/chat/send', [App\Http\Controllers\ChatController::class, 'send'])->name('chat.send');
    Route::get('/chat/{conversationId}/messages', [App\Http\Controllers\ChatController::class, 'getMessages'])->name('chat.messages');
    
    Route::get('/chat/start/{user}', function ($user) {
        $uid = Auth::id();
        
        if ($uid == $user) {
            return redirect()->back()->with('error', 'You cannot send a message to yourself.');
        }
        
        $otherUser = User::findOrFail($user);
        $existing = Message::where('sender_id', $uid)->where('receiver_id', $user)
            ->orWhere(function ($q) use ($uid, $user) { 
                $q->where('sender_id', $user)->where('receiver_id', $uid); 
            })->first();
        if ($existing) return redirect('/chat/' . $existing->conversation_id);
        $conversationId = Str::uuid()->toString();
        Message::create(['conversation_id' => $conversationId, 'sender_id' => $uid, 'receiver_id' => $user, 'message_text' => 'Hi! I found you on FitarSelf.']);
        return redirect('/chat/' . $conversationId);
    })->name('chat.start');
    
    Route::get('/my-cars', [UserCarController::class, 'index'])->name('profile.cars');
    Route::post('/my-cars', [UserCarController::class, 'store'])->name('profile.cars.store');
    Route::delete('/my-cars/{car}', [UserCarController::class, 'destroy'])->name('profile.cars.destroy');
    
    Route::post('/save/{type}/{id}', [SavedItemController::class, 'store'])->name('save.item');
    Route::delete('/save/{type}/{id}', [SavedItemController::class, 'destroy'])->name('unsave.item');
    Route::get('/check-saved/{type}/{id}', [SavedItemController::class, 'check'])->name('check.saved');
});

// ============================================
// ADMIN SUPPORT ROUTES
// ============================================
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/support', [AdminSupportController::class, 'index'])->name('admin.support');
    Route::get('/support/messages', [AdminSupportController::class, 'getMessages'])->name('admin.support.messages');
    Route::post('/support/reply', [AdminSupportController::class, 'reply'])->name('admin.support.reply');
});

require __DIR__.'/auth.php';