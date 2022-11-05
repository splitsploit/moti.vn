<?php

Route::redirect('/', '/login');
Route::get('/home', function () {
    $routeName = 'admin.home';
    if (session('status')) {
        return redirect()->route($routeName)->with('status', session('status'));
    }

    return redirect()->route($routeName);
});

Auth::routes(['register' => false]);
// Admin

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'namespace' => 'Admin', 'middleware' => ['auth']], function () {
    Route::get('/', 'HomeController@index')->name('home');
    // Permissions
    Route::delete('permissions/destroy', 'PermissionsController@massDestroy')->name('permissions.massDestroy');
    Route::resource('permissions', 'PermissionsController');

    // Roles
    Route::delete('roles/destroy', 'RolesController@massDestroy')->name('roles.massDestroy');
    Route::resource('roles', 'RolesController');

    // Users
    Route::delete('users/destroy', 'UsersController@massDestroy')->name('users.massDestroy');
    Route::resource('users', 'UsersController');

    // Available Booking Time
    Route::post('availableBookingTime/massStore', 'AvailableBookingTimeController@massStore')->name('availableBookingTime.massStore');
    Route::delete('availableBookingTime/destroy', 'AvailableBookingTimeController@massDestroy')->name('availableBookingTime.massDestroy');
    Route::resource('availableBookingTime', 'AvailableBookingTimeController');

    // Special Time
    Route::post('specialTime/massStore', 'SpecialTimeController@massStore')->name('specialTime.massStore');
    Route::delete('specialTime/destroy', 'SpecialTimeController@massDestroy')->name('specialTime.massDestroy');
    Route::resource('specialTime', 'SpecialTimeController');

    // Timekeeping
    Route::delete('timekeeping/destroy', 'TimekeepingController@massDestroy')->name('timekeeping.massDestroy');
    Route::resource('timekeeping', 'TimekeepingController');

    // Booking Time
    Route::post('bookingTime/massStore', 'BookingTimeController@massStore')->name('bookingTime.massStore');
    Route::delete('bookingTime/destroy', 'BookingTimeController@massDestroy')->name('bookingTime.massDestroy');
    Route::resource('bookingTime', 'BookingTimeController');

    // Timesheets
    Route::get('timesheets/checkIn', 'TimesheetsController@checkIn')->name('timesheets.checkIn');
    Route::get('timesheets/checkOut', 'TimesheetsController@checkOut')->name('timesheets.checkOut');
    Route::delete('timesheets/destroy', 'TimesheetsController@massDestroy')->name('timesheets.massDestroy');
    Route::resource('timesheets', 'TimesheetsController');

    // Calendar
    Route::get('calendar', 'CalendarController@index')->name('calendar.index');

    // Configurations
    Route::get('configurations', 'ConfigurationsController@index')->name('configurations.index');
    Route::resource('configurations', 'ConfigurationsController');
});

Route::group(['prefix' => 'api', 'as' => 'api.admin.', 'namespace' => 'Api\V1\Admin', 'middleware' => ['auth']], function () {
    // Booking Time
    Route::apiResource('bookingTime', 'BookingTimeApiController');
});

Route::group(['prefix' => 'profile', 'as' => 'profile.', 'namespace' => 'Auth', 'middleware' => ['auth']], function () {
    // Change Password
    if (file_exists(app_path('Http/Controllers/Auth/ChangePasswordController.php'))) {
        Route::get('password', 'ChangePasswordController@edit')->name('password.edit');
        Route::post('password', 'ChangePasswordController@update')->name('password.update');
    }
});
