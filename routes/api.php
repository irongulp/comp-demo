<?php

use App\Http\Resources\CertificateCollection;
use App\Http\Resources\CertificateResource;
use App\Http\Resources\NoteCollection;
use App\Http\Resources\NoteResource;
use App\Http\Resources\PropertyCollection;
use App\Http\Resources\PropertyResource;
use App\Models\Certificate;
use App\Models\Note;
use App\Models\Property;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

/** Returns properties */
Route::get('property', function() {
    return new PropertyCollection(Property::get());
});

/** Returns a property */
Route::get('property/{id}', function($id) {
    return new PropertyResource(Property::findOrFail($id));
});

/** Creates a new property */
Route::post('property', function(Request $request) {
    return new PropertyResource(Property::create($request->input()));
});

/** Updates a property */
Route::patch('property/{id}', function($id, Request $request) {
    Property::findOrFail($id)
            ->fill($request->input())
            ->save();
    return response()->noContent();
});

/** Deletes a property */
Route::delete('property/{id}', function($id) {
    Property::findOrFail($id)->delete();
    return response()->noContent();
});

/** Returns the certificates of a property */
Route::get('property/{id}/certificate', function($id) {
    return new CertificateCollection(Property::findOrFail($id)->certificates);
});

/** Returns the notes of a property */
Route::get('property/{id}/note', function($id) {
    return new NoteCollection(Property::findOrFail($id)->notes);
});

/** Creates a note for a property */
Route::post('property/{id}/note', function(Request $request, $id) {
    $property = Property::findOrFail($id);
    $note = Note::make($request->input());
    $note->notable()->associate($property)->save();
    return new NoteResource($note);
});

/** Returns certificates */
Route::get('certificate', function() {
    return new CertificateCollection(Certificate::get());
});

/** Returns a certificate */
Route::get('certificate/{id}', function($id) {
    return new CertificateResource(Certificate::findOrFail($id));
});

/** Creates a certificate */
Route::post('certificate', function(Request $request) {
    return new CertificateResource(Certificate::create($request->input()));
});

/** Returns the notes of a certificate */
Route::get('certificate/{id}/note', function($id) {
    return new NoteCollection(Certificate::findOrFail($id)->notes);
});

/** Creates a note for a certificate */
Route::post('certificate/{id}/note', function(Request $request, $id) {
    $certificate = Certificate::findOrFail($id);
    $note = Note::make($request->input());
    $note->notable()->associate($certificate)->save();
    return new NoteResource($note);
});
