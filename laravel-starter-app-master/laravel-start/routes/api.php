<?php

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// Route::get('/products','ProductController@index');
// Route::post('/products','ProductController@store');

// Route::post('/products/{product}', 'ProductController@update');
// Route::put('/products/{product}', 'ProductController@update');
// Route::delete('/products/{product}', 'ProductController@destroy');



// Route::get('/products/{product}','ProductController@show');



// Route::get('/products/create',function(){
    //  return view ('products.create');
    // });
    
    
    // Route::get('/categories',function(){
        //     $category =  Category::orderBy('name')->get();
        //     return CategoryResource::collection($category);
        //  //return response()->json(['Category1', 'Category2']);<
        // // return ['Category1', 'Category2'];
        // });
        // Route::get('/categories/{category}',function(Category $category){
            //     //$category =  Category::orderBy('name')->get();
            //     return new CategoryResource($category);
            //  //return response()->json(['Category1', 'Category2']);<
            // // return ['Category1', 'Category2'];
            // });
            
            Route::get('/categories', 'CategoryController');
            Route::apiResource('/products', 'ProductController');
            