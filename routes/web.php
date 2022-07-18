<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/', function() {
    return view('welcome');
});

Route::get('prepare-to-login', function () {
    $state = Str::random(40);

    session([
        'state' => $state
    ]);

    $query = http_build_query(([
        'client_id' => env('CLIENT_ID'),
        'redirect_url' => env('REDIRECT_URL'),
        'response_type' => 'code',
        'scope' => '',
        'state' => $state,
    ]));

    return redirect(env('API_URL').'oauth/authorize?'.$query);

})->name('prepare.login');

Route::get('callback', function(Request $request) {
    // dd($request->all());

    // Verificação de state
    $response = Http::post(env('API_URL').'oauth/token', [
        'grant_type' => 'authorization_code',
        'client_id' => env('CLIENT_ID'),
        'client_secret' => env('CLIENT_SECRET'),
        'redirect_url' => env('REDIRECT_URL'),
        'code' => $request->code,
    ]);

    dd($response->json());

});

Route::get('grant-password', function(Request $request) {
    // dd($request->all());

    // Verificação de state
    $response = Http::post(env('API_URL').'oauth/token', [
        'grant_type' => 'password',
        'client_id' => 4,
        'client_secret' =>  'UMX81YcGm7WXF8egyDKqFUJofbEIBQCi6zl6aPeT',
        'username' => 'andre.paiva@cmexx.com.br',
        'password' => '12345678',
        'scope' => ''
    ]);

    dd($response->json());

});

Route::get('grant-client', function(Request $request) {
    // dd($request->all());

    // Verificação de state
    $response = Http::post(env('API_URL').'oauth/token', [
        'grant_type' => 'client_credentials',
        'client_id' => 5,
        'client_secret' =>  '7BGVyWFzAxDVzkdmUptZmQjgssVuaO9iBn0xqK7U',
        'scope' => ''
    ]);

    dd($response->json());

});
