<?php

use App\Http\Requests\StoreRequest;
use App\Services\ProductParseService;
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

Route::get(
    '/',
    function () {
        return view('welcome');
    }
);

Route::post(
    'store',
    function (StoreRequest $request) {
        $request->file->storeAs('', 'MyFile.txt');

        $parseService = new ProductParseService();
        $parseService->put('MyFile.txt', 'MyFile.json');

        return redirect()->route('products');
    }
)->name('store');

Route::get(
    '/products',
    function () {
        $parseService = new ProductParseService();
        $products = $parseService->get('MyFile.json');

        return view('products', ['products' => $products]);
    }
)->name('products');

