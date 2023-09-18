<?php

use App\Http\Controllers\MeetingController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/meeting/add', [MeetingController::class, 'add'])->name('meeting.add');
Route::post('/meeting/add-user', [MeetingController::class, 'addUser'])->name('meeting.addUser');
Route::post('/meeting/remove-user', [MeetingController::class, 'removeUser'])->name('meeting.removeUser');
