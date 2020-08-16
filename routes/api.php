<?php

use Illuminate\Http\Request;

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

Route::prefix('v1')->group(function () {
    Route::prefix('guest')->group(function () {
        Route::get('/region', 'Api\v1\KatoController@get_region');
        Route::post('/list', 'Api\v1\HotelController@guest');
    });
    Route::middleware('auth:api')->get('/user', 'Api\v1\HotelController@user');

    // Logs Activity


    // Авторизация
    Route::prefix('auth')->group(function () {
        Route::post('/login', 'Api\v1\AuthController@login');
        Route::post('/register', 'Api\v1\AuthController@register');
        // Route::post('/refreshToken', 'Api\v1\AuthController@refresh_token');
        Route::middleware('auth:api')->group(function () {
            Route::post('/logout', 'Api\v1\AuthController@logout');
        });
    });

    Route::middleware('auth:api')->group(function () {

        Route::get('/all/logs', 'Api\v1\LogsController@index');

        Route::post('regula', 'Api\v1\UserController@regula');

        Route::prefix('user')->group(function () {
            
            Route::post('/update/data', 'Api\v1\PaySenderController@update_data');
            
            Route::get('/get/user/email', 'Api\v1\UserController@get_user_email');
            
            Route::get('/get/client', 'Api\v1\PaySenderController@getClient');
            
            Route::get('/get/transactions', 'Api\v1\PaySenderController@getTransactions');
            Route::post('/send/transaction', 'Api\v1\PaySenderController@sendTransaction');
            
            Route::post('/paysender/listbytype', 'Api\v1\PaySenderController@listByType');
            Route::get('/paysender/list', 'Api\v1\PaySenderController@index');
            Route::post('/paysender', 'Api\v1\PaySenderController@create');


            Route::post('/create/news', 'Api\v1\PaySenderController@createNews'); 
            
            Route::get('/get/news', 'Api\v1\PaySenderController@getNews');                
            Route::post('/delete/news/image', 'Api\v1\PaySenderController@deleteImageNews');
            Route::post('/delete/news', 'Api\v1\PaySenderController@deleteNews');
            Route::post('/upload/image/news', 'Api\v1\PaySenderController@uploadImageNews');
            


            Route::post('/delete/feedback', 'Api\v1\PaySenderController@deleteFeedback');
            Route::get('/get/feedback', 'Api\v1\PaySenderController@getFeedback');
            Route::post('/send/feedback/user', 'Api\v1\PaySenderController@sendFeedbackUser');
            Route::post('/send/feedback/client', 'Api\v1\PaySenderController@sendFeedbackClient');
        

            
            Route::post('/index', 'Api\v1\UserController@index');
            Route::post('/show', 'Api\v1\UserController@show');
            Route::post('/me', 'Api\v1\UserController@me');
            Route::post('/search', 'Api\v1\UserController@search');
            Route::post('/create', 'Api\v1\UserController@create');
            Route::post('/my_count', 'Api\v1\UserController@my_count');
            Route::post('/roles/get', 'Api\v1\UserController@get_roles');

            Route::post('/update', 'Api\v1\UserController@update');
            Route::post('/delete', 'Api\v1\UserController@delete');

            Route::post('/get/user/count', 'Api\v1\UserController@get_users_count');
        });


        Route::prefix('role')->group(function () {
            Route::post('/index', 'Api\v1\RoleController@index');
        });
        Route::prefix('hotel')->group(function () {
            Route::post('/all', 'Api\v1\HotelController@all');
            Route::post('/index', 'Api\v1\HotelController@index');
            Route::post('/create', 'Api\v1\HotelController@create');
            Route::post('/edit', 'Api\v1\HotelController@edit');
            Route::post('/show', 'Api\v1\HotelController@show');
            Route::post('/delete', 'Api\v1\HotelController@delete');
            Route::post('/get', 'Api\v1\HotelController@getByRegionId');

            Route::get('/email-messages', 'Api\v1\HotelController@showMessage'); // api триггера 
            Route::post('/email-messages', 'Api\v1\HotelController@editMessage'); // api триггера для редактирования
            Route::get('/profile-placement', 'Api\v1\HotelController@showPlacementProfile'); //apі мест размещения
            Route::post('/profile-placement', 'Api\v1\HotelController@editPlacementProfile'); //арі обновления мест размещения  
            Route::post('/profile-placement/image/upload', 'Api\v1\HotelController@uploadImagePlacementProfile'); // для загрузки фото
            Route::post('/profile-placement/image/delete', 'Api\v1\HotelController@deleteImagePlacementProfile');  // для удаления
            Route::get('/not-booking', 'Api\v1\HotelController@testUponBooking');
            Route::get('/not-arrival', 'Api\v1\HotelController@testUponArrival');
            Route::get('/not-departure', 'Api\v1\HotelController@testUponDeparture');
            Route::get('/email-management', 'Api\v1\HotelController@showTypesMessages');
            Route::post('/email-management', 'Api\v1\HotelController@editTypesMessages');


            // Route::get('/not', 'HomeController@test');

            // Route::get('/notification-day', 'Api\v1\HotelController@showDayNotice');
            // Route::put('/notification-day', 'Api\v1\HotelController@updateDayNotice');
        });
        Route::prefix('responsible')->group(function () {
            Route::post('/show', 'Api\v1\ResponsibleController@show');
            Route::post('/create', 'Api\v1\ResponsibleController@create');
            Route::post('/delete', 'Api\v1\ResponsibleController@delete');
        });
        Route::prefix('registry')->group(function () {

            Route::post('/delete', 'Api\v1\RegistryController@delete_transaction');
            Route::post('/show', 'Api\v1\RegistryController@show');
            Route::post('/migration', 'Api\v1\RegistryController@migration');
            Route::post('/migration/show', 'Api\v1\RegistryController@migrationHandbookShow');
            Route::post('/migration/update', 'Api\v1\RegistryController@migrationHandbookUpdate');
            Route::post('/update', 'Api\v1\RegistryController@update');
            Route::post('/create', 'Api\v1\RegistryController@create');
            Route::post('/count', 'Api\v1\RegistryController@count');
            Route::post('/list', 'Api\v1\RegistryController@list');
            Route::post('/notif', 'Api\v1\RegistryController@notif');
            Route::post('/client/show', 'Api\v1\RegistryController@show_client');
            Route::post('/client/list', 'Api\v1\RegistryController@list_client');
            Route::get('/client/list/export', 'Api\v1\RegistryController@exportClient');
        });
        Route::prefix('certificate')->group(function () {
            Route::post('/create', 'Api\v1\CertificateController@create');
            Route::post('/show', 'Api\v1\CertificateController@show');
        });
        Route::prefix('kato')->group(function () {
            Route::get('/region', 'Api\v1\KatoController@get_region');
            Route::post('/area', 'Api\v1\KatoController@get_area');
            Route::post('/areas', 'Api\v1\KatoController@get_areas');
            Route::post('/locality', 'Api\v1\KatoController@get_locality');
            Route::post('/localities', 'Api\v1\KatoController@get_localities');
        });

        Route::prefix('country')->group(function () {
            Route::get('/index', 'Api\v1\CountryController@index');
        });
        Route::prefix('target')->group(function () {
            Route::get('/index', 'Api\v1\TargetController@index');
        });
        Route::prefix('gender')->group(function () {
            Route::get('/index', 'Api\v1\GenderController@index');
        });
        Route::prefix('doctype')->group(function () {
            Route::get('/index', 'Api\v1\DoctypeController@index');
        });
        Route::prefix('status')->group(function () {
            Route::get('/check_in', 'Api\v1\StatusController@check_in');
            Route::get('/check_out', 'Api\v1\StatusController@check_out');
            Route::get('/index', 'Api\v1\StatusController@index');
        });
        Route::prefix('analytics')->group(function () {
            Route::post('/tour', 'Api\v1\AnalyticController@tour');
            Route::post('/tour/count_tourists_in_month_in_region', 'Api\v1\AnalyticController@count_tourists_in_month_in_region');
            Route::post('/portrait/tourist_age', 'Api\v1\AnalyticController@tourist_age');
            Route::post('/portrait', 'Api\v1\AnalyticController@portrait');
            Route::post('/dashboard', 'Api\v1\AnalyticController@dashboard');
        });
        Route::prefix('year')->group(function () {
            Route::get('/index', 'Api\v1\YearController@index');
        });
        Route::prefix('age')->group(function () {
            Route::get('/index', 'Api\v1\AgeController@index');
        });
        Route::prefix('support')->group(function () {
            Route::post('create', 'Api\v1\SupportController@create');
        });
        Route::prefix('notification')->group(function () {
            Route::post('list', 'Api\v1\NotificationController@index');
            Route::post('dashboard', 'Api\v1\NotificationController@dashboard');
            Route::post('create', 'Api\v1\NotificationController@create');
            Route::post('show', 'Api\v1\NotificationController@show');
            Route::post('update', 'Api\v1\NotificationController@update');
            Route::post('delete', 'Api\v1\NotificationController@delete');
        });

        Route::prefix('room-type')->group(function () {
            Route::get('/all', 'Api\v1\RoomTypeController@all');
            Route::post('/add', 'Api\v1\RoomTypeController@add');
            Route::get('/delete/{id}', 'Api\v1\RoomTypeController@delete');
            Route::get('/{id}', 'Api\v1\RoomTypeController@get');
            Route::get('/image/delete/{id}', 'Api\v1\RoomTypeController@deleteImage');
            Route::post('/price/show', 'Api\v1\RoomPriceController@show');
            Route::post('/price', 'Api\v1\RoomPriceController@edit');
            Route::post('/delete', 'Api\v1\RoomTypeController@delete');
          
            Route::post('/edit', 'Api\v1\RoomTypeController@editRoomType');
        });
        // Route::prefix('administration')->group(function () {
        //     // Route::post('/email-management', 'Api\v1\HotelController@showEmail');
        //     Route::post('/email-management', 'Api\v1\HotelController@editEmail');
        // });

        Route::prefix('room-sales')->group(function () {
            Route::get('/', 'Api\v1\RoomSaleController@all');
            Route::post('/filter', 'Api\v1\RoomSaleController@allByFilter');
            Route::post('/update', 'Api\v1\RoomSaleController@updateRoomSaleCount');
            // Route::post('/edit', 'Api\v1\RoomTypeController@editRoomType');
        });
    });
    //
});
