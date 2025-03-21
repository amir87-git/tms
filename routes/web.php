<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DriverController;
use App\Http\Controllers\VehicleController;
use App\Http\Controllers\ShipmentController;
use App\Http\Controllers\AssignedShipmentController;
use App\Http\Controllers\ReceiveShipmentController;
use App\Http\Controllers\TripController;
use App\Http\Controllers\ApprovalController;
use App\Http\Controllers\ManagerController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\PdfController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('welcome');
});

// Driver, Vehicle, Shipment CRUD
Route::resource('/driver', DriverController::class);
Route::resource('/vehicle', VehicleController::class);
Route::resource('/shipment', ShipmentController::class);
Route::get('home', [HomeController::class, 'index'])->name('home');

// Assign shipments to drivers and vehicles
Route::get('/shipment/{id}/assign', [ShipmentController::class, 'assign'])->name('shipment.assign');
Route::post('/shipment/{id}/assign', [ShipmentController::class, 'storeAssignment'])->name('shipment.storeAssignment');

// Assigned and Received Shipments

Route::resource('trips', TripController::class);
Route::middleware(['auth:driver', 'preventBackHistory'])->group(function () {
    Route::resource('receive-shipments', ReceiveShipmentController::class);
    Route::get('/receive-shipments/{id}/form', [ReceiveShipmentController::class, 'showForm'])->name('receive-shipments.form');
});

Route::middleware(['auth:manager', 'preventBackHistory'])->group(function () {
    Route::resource('assigned-shipments', AssignedShipmentController::class);
});

Route::resource('approval', ApprovalController::class);
Route::get('approval/{id}/approve', [ApprovalController::class, 'approveForm'])->name('approval.approveForm');
Route::post('approval/{id}/approve', [ApprovalController::class, 'approve'])->name('approval.approve');
Route::get('/completed-shipments', [ShipmentController::class, 'completedShipments'])->name('completedShipments.index');

Route::middleware(['auth', 'preventBackHistory'])->group(function () {
    Route::resource('manager', ManagerController::class);
});


Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');


Route::get('completed-shipments/pdf/{shipment}', [PdfController::class, 'generatePDF'])->name('completed-shipments.pdf');
Route::post('/save-draft', [TripController::class, 'saveDraft']);
Route::get('/get-draft/{shipment}', [TripController::class, 'getDraft']);


