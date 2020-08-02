<?php

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

//Route::get('/', function () {
//    $api = file_get_contents('https://restcountries.eu/rest/v2/all');
//    $items = json_decode($api);
//    foreach ($items as $item) {
//        \App\Models\Country::where('country_code',$item->alpha2Code)->update(['flag' => $item->flag]);
////        return response()->json($item);
//    }
//});

use Illuminate\Support\Facades\Hash;

Route::get('/','HomeController@index');


Route::get("/directory", function()
{
   return View::make("directory");
});
// Route::view('/directory','directory');

Route::view('/description','description');

Route::view('/hotels','main');

Route::view('/main','main');

// Route::get('/h/otels','Api\v1\HotelController@public');

Route::get('/get/news', 'PaySenderController@getNew');


Route::get('/send-email', 'FeedbackController@send');
Route::get('/request/register', 'HomeController@requestRegister');
Auth::routes();

// Route::get('/home', 'HomeController@index')->name('home');
// Route::get('/test', function() {
//     return view('test-placement-profile');
// });
// Route::get('/test-placement', 'Api\v1\HotelController@showPlacementProfile');
// Route::post('/test-placement', 'Api\v1\HotelController@editPlacementProfile');
// Route::post('/test-placement/image/upload', 'Api\v1\HotelController@uploadImagePlacementProfile');
// Route::post('/test-placement/image/delete', 'Api\v1\HotelController@deleteImagePlacementProfile');
// Route::get('/test', 'HomeController@test');
// Route::get('/test', 'Api\v1\RegistryController@exportClient');
// Route::post('/test', 'Api\v1\HotelController@editMessage');
// Route::get('/test', function (){
//     return view('/test');
// });
// Route::get('/test/day', 'Api\v1\HotelController@show');
// Route::get('/not-booking', 'Api\v1\HotelController@testUponBooking');
// Route::get('/show', 'Api\v1\HotelController@showMessage');

// Route::get('/not-arrival', 'Api\v1\HotelController@testUponArrival');
// Route::get('/not-instant', 'HomeController@testInstant');
// Route::get('/show-type', 'Api\v1\HotelController@showTypesMessages');
// Route::get('/room', 'Api\v1\RoomPriceController@show');
// Route::post('/room', 'Api\v1\RoomPriceController@edit');

// Route::post('test', 'Api\v1\RoomSaleController@test');

// Route::get('/all', 'Api\v1\HotelController@getAllHotels');