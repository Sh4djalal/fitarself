<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CarController;
use App\Http\Controllers\FaultCodeController;
use App\Http\Controllers\MechanicController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\LocaleController;
use App\Http\Controllers\ThemeController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Message;
use Illuminate\Http\Request;

// Public Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/cars', [CarController::class, 'index'])->name('cars.index');
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
Route::get('/ads/click/{ad}', function ($adId) {
    $ad = \App\Models\Ad::findOrFail($adId);
    $ad->increment('clicks');
    return redirect($ad->link_url ?? '/');
})->name('ads.click');
Route::get('/api/search', function (Request $request) {
    $q = $request->get('q');
    $cars = \App\Models\Car::where('make', 'like', "%{$q}%")->orWhere('model', 'like', "%{$q}%")->limit(8)->get(['id', 'make', 'model', 'year']);
    $faultCodes = \App\Models\FaultCode::where('code', 'like', "%{$q}%")->orWhere('title_en', 'like', "%{$q}%")->limit(8)->get(['id', 'code', 'title_en']);
    $mechanics = \App\Models\User::where('role', 'mechanic')->where(function($query) use ($q) { $query->where('name', 'like', "%{$q}%")->orWhere('city', 'like', "%{$q}%"); })->limit(5)->get(['id', 'name', 'city']);
    return response()->json(['cars' => $cars, 'faultCodes' => $faultCodes, 'mechanics' => $mechanics]);
});

// Dashboard
Route::get('/dashboard', function () {
    if (Auth::user()->role === 'mechanic') {
        return view('mechanic-dashboard');
    }
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Auth Routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/reviews', [App\Http\Controllers\ReviewController::class, 'store'])->name('reviews.store');
    Route::delete('/reviews/{review}', [App\Http\Controllers\ReviewController::class, 'destroy'])->name('reviews.destroy');
    Route::get('/chat', [App\Http\Controllers\ChatController::class, 'index'])->name('chat.index');
    Route::get('/chat/{conversationId}', [App\Http\Controllers\ChatController::class, 'show'])->name('chat.show');
    Route::post('/chat/send', [App\Http\Controllers\ChatController::class, 'send'])->name('chat.send');
    Route::get('/chat/{conversationId}/messages', [App\Http\Controllers\ChatController::class, 'getMessages'])->name('chat.messages');
    Route::get('/chat/start/{user}', function ($user) {
        $otherUser = User::findOrFail($user);
        $existing = Message::where(function ($q) use ($user) { $q->where('sender_id', Auth::id())->where('receiver_id', $user); })->orWhere(function ($q) use ($user) { $q->where('sender_id', $user)->where('receiver_id', Auth::id()); })->first();
        if ($existing) { return redirect('/chat/' . $existing->conversation_id); }
        $conversationId = Str::uuid()->toString();
        Message::create(['conversation_id' => $conversationId, 'sender_id' => Auth::id(), 'receiver_id' => $user, 'message_text' => 'Hi! I found you on FitarSelf.']);
        return redirect('/chat/' . $conversationId);
    })->name('chat.start');

    // My Cars
    Route::get('/my-cars', [App\Http\Controllers\UserCarController::class, 'index'])->name('profile.cars');
    Route::post('/my-cars', [App\Http\Controllers\UserCarController::class, 'store'])->name('profile.cars.store');
    Route::delete('/my-cars/{car}', [App\Http\Controllers\UserCarController::class, 'destroy'])->name('profile.cars.destroy');
});

require __DIR__.'/auth.php';