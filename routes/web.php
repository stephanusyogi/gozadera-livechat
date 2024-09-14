<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\TableController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/signin', [AuthController::class, 'auth'])->name('auth.index')->middleware('guest');
Route::post('/signin', [AuthController::class, 'signin'])->name('auth.action')->middleware('guest');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/', [DashboardController::class, 'dashboard'])->name('dashboard.index');

    // Route::post('/save-color-mode', function (Request $request) {
    //     $request->session()->put('color_mode', $request->input('mode')); 
    //     return response()->json(['success' => true]);
    // });

    Route::get('/all-administrator', [AdminController::class, 'all'])->name('all-administrator');
    Route::get('/all-administrator/add', [AdminController::class, 'add'])->name('all-administrator.add');
    Route::post('/all-administrator/add', [AdminController::class, 'create'])->name('all-administrator.add-action');
    Route::get('/all-administrator/edit/{id}', [AdminController::class, 'update'])->name('all-administrator.update');
    Route::post('/all-administrator/edit/{id}', [AdminController::class, 'edit'])->name('all-administrator.edit-action');
    Route::get('/all-administrator/delete/{id}', [AdminController::class, 'delete'])->name('all-administrator.delete');
    Route::get('/all-administrator/restore/{id}', [AdminController::class, 'restore'])->name('all-administrator.restore');    
    
    Route::get('/all-table', [TableController::class, 'all'])->name('all-table');
    Route::get('/all-table/add', [TableController::class, 'add'])->name('all-table.add');
    Route::post('/all-table/add', [TableController::class, 'create'])->name('all-table.add-action');
    Route::get('/all-table/edit/{id}', [TableController::class, 'update'])->name('all-table.update');
    Route::post('/all-table/edit/{id}', [TableController::class, 'edit'])->name('all-table.edit-action');
    Route::get('/all-table/delete/{id}', [TableController::class, 'delete'])->name('all-table.delete');
    Route::get('/all-table/restore/{id}', [TableController::class, 'restore'])->name('all-table.restore');

    Route::get('/all-event', [EventController::class, 'all'])->name('all-event');
    Route::get('/all-event/event/{id}', [EventController::class, 'detail'])->name('all-event.detail');
    Route::post('/all-event/event/{id}', [EventController::class, 'edit'])->name('all-event.edit-action');
    Route::get('/all-event/event/delete/{id}', [EventController::class, 'delete'])->name('all-event.delete');
    Route::get('/all-event/event/restore/{id}', [EventController::class, 'restore'])->name('all-event.restore');
    Route::get('/all-event/add', [EventController::class, 'create'])->name('all-event.add');
    Route::post('/all-event/add', [EventController::class, 'add'])->name('all-event.add-action');
    Route::get('/all-event/event/create-new/set-default-style', [EventController::class, 'set_default_style'])->name('all-event.set-default-style');
    Route::get('/all-event/event/qr-code/{id}', [EventController::class, 'qr_code'])->name('all-event.qr-code');

    Route::get('/all-event/event/start-livechat/{id}', [EventController::class, 'start_livechat'])->name('all-event.start-livechat');
    Route::get('/all-event/event/stop-livechat/{id}', [EventController::class, 'stop_livechat'])->name('all-event.stop-livechat');


    Route::get('/all-event/event/all-chat/{id}', [EventController::class, 'all_chat'])->name('all-event.event-all-chat');
    Route::get('/all-event/event/all-chat/delete/{id}', [EventController::class, 'all_chat_delete'])->name('all-event.event-all-chat-delete');

    Route::get('/all-event/event/demo/videotron/{id}', [EventController::class, 'demo_videotron'])->name('all-event.demo-videotron');
    Route::get('/all-event/event/demo/visitor/{id}', [EventController::class, 'demo_visitor'])->name('all-event.demo-visitor');

    Route::delete('/all-event/event/livechat/delete-chat/{id_event}/{id_chat}', [EventController::class, 'delete_chat'])->name('all-event.delete-livechat');
});

Route::get('/all-event/event/all-song-request/{id}', [EventController::class, 'all_song'])->name('all-event.event-all-song');
Route::get('/all-event/event/all-song-request/delete/{id_event}/{id_song}', [EventController::class, 'all_song_delete'])->name('all-event.event-all-song-delete');
Route::get('/all-event/event/all-song-request/get/{id}', [EventController::class, 'getSongRequests'])->name('all-event.event-all-song-get');


Route::get('/all-event/event/livechat/videotron/{id}', [EventController::class, 'livechat_videotron'])->name('all-event.livechat-videotron');
Route::get('/all-event/event/livechat/get-videotron/{id}', [EventController::class, 'get_chat_videotron'])->name('all-event.get-chat-videotron');

Route::get('/all-event/event/livechat/visitor-onboard/{id}', [EventController::class, 'livechat_visitor_onboard'])->name('all-event.livechat-visitor-onboard');
Route::post('/all-event/event/livechat/visitor-onboard/{id}', [EventController::class, 'livechat_visitor_onboard_action'])->name('all-event.livechat-visitor-onboard-action');

Route::get('/all-event/event/livechat/visitor/{id}', [EventController::class, 'livechat_visitor'])->name('all-event.livechat-visitor');
Route::get('/all-event/event/livechat/get-visitor/{id}', [EventController::class, 'get_chat_visitor'])->name('all-event.get-chat-visitor');

Route::post('/all-event/event/livechat/send/{id}', [EventController::class, 'send_chat'])->name('all-event.send-chat');
Route::post('/all-event/event/all-song-request/send/{id}', [EventController::class, 'storeSongRequest'])->name('all-event.event-all-song-send');
Route::post('/all-event/event/all-song-request/update_flag/{id}', [EventController::class, 'updateFlagDone'])->name('all-event.event-all-song-update-flag');
