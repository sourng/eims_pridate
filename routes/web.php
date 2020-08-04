<?php

use App\Http\Controllers\Settings\LanguagesController;
use App\Models\Roles;
use Illuminate\Support\Facades\Auth;
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

Auth::routes();
Route::any('/',     ['uses'  => 'FrontController@index']);
Route::any('/home', ['uses'  => 'FrontController@home'])->name('home');
Route::any('/training', ['uses'  => 'FrontController@training'])->name('training');
Route::any('/news-even', ['uses'  => 'FrontController@newsEven'])->name('news-even');
Route::any('/about', ['uses'  => 'FrontController@about'])->name('about');
Route::any('/contact', ['uses'  => 'FrontController@contact'])->name('contact');
Route::any('/ajax', ['uses'  => 'FrontController@ajax'])->name('ajax');


//SocialAuth
Route::group(['prefix' => 'auth'], function () {
    Route::any('/{param1}', ['uses'  => 'SocialAuthController@index']);
    Route::any('/{param1}/{param2}', ['uses'  => 'SocialAuthController@index']);
});

Route::any('/language/set/{locale}', function ($locale) {
    $lng  = new LanguagesController;
    return $lng->setLocale($locale);
});

// Route::any('/holiday/{args?}',function (args){
//     args = explode('/', args);
//     return args;
// })->where('args', '(.*)');

Route::group(['prefix' => 'holiday', 'namespace' => 'General\\'], function () {
    Route::any('/{param1}', ['uses'  => 'HolidayController@index']);
});
Route::group(['prefix' => 'mailbox', 'namespace' => 'Mailbox\\'], function () {
    Route::any('/', ['uses'  => 'MailboxController@index']);
    Route::any('/{param1}', ['uses'  => 'MailboxController@index']);
    Route::any('/{param1}/{param2}', ['uses'  => 'MailboxController@index']);
    Route::any('/{param1}/{param2}/{param3}', ['uses'  => 'MailboxController@index']);
    Route::any('/{param1}/{param2}/{param3}/{param4}', ['uses'  => 'MailboxController@index']);
});

Route::group(['middleware' => ['web']], function () {
    // For Adminitrator
    Route::group(['prefix' => Roles::find(1)->name, 'namespace' => Roles::find(1)->view_path.'\\', 'middleware' => 'CheckUserLoginRoles'], function () {
        Route::any('/', ['uses'  => 'AdministratorController@index']);
        Route::any('/{param1}', ['uses'  => 'AdministratorController@index']);
        Route::any('/{param1}/{param2}', ['uses'  => 'AdministratorController@index']);
        Route::any('/{param1}/{param2}/{param3}', ['uses'  => 'AdministratorController@index']);
        Route::any('/{param1}/{param2}/{param3}/{param4}', ['uses'  => 'AdministratorController@index']);
        Route::any('/{param1}/{param2}/{param3}/{param4}/{param5}', ['uses'  => 'AdministratorController@index']);
        Route::any('/{param1}/{param2}/{param3}/{param4}/{param5}/{param6}', ['uses'  => 'AdministratorController@index']);
    });

    // For Manager
    Route::group(['prefix' => Roles::find(2)->name, 'namespace' => Roles::find(2)->view_path.'\\', 'middleware' => 'CheckUserLoginRoles'], function () {

        Route::any('/', ['uses'  => 'ManagerController@index']);
        Route::any('/{param1}', ['uses'  => 'ManagerController@index']);
        Route::any('/{param1}/{param2}', ['uses'  => 'ManagerController@index']);
        Route::any('/{param1}/{param2}/{param3}', ['uses'  => 'ManagerController@index']);
        Route::any('/{param1}/{param2}/{param3}/{param4}', ['uses'  => 'ManagerController@index']);
        Route::any('/{param1}/{param2}/{param3}/{param4}/{param5}', ['uses'  => 'ManagerController@index']);
        Route::any('/{param1}/{param2}/{param3}/{param4}/{param5}/{param6}', ['uses'  => 'ManagerController@index']);
    });

     // For Department
     Route::group(['prefix' => Roles::find(10)->name, 'namespace' => Roles::find(10)->view_path.'\\', 'middleware' => 'CheckUserLoginRoles'], function () {

        Route::any('/', ['uses'  => 'DepartmentController@index']);
        Route::any('/{param1}', ['uses'  => 'DepartmentController@index']);
        Route::any('/{param1}/{param2}', ['uses'  => 'DepartmentController@index']);
        Route::any('/{param1}/{param2}/{param3}', ['uses'  => 'DepartmentController@index']);
        Route::any('/{param1}/{param2}/{param3}/{param4}', ['uses'  => 'DepartmentController@index']);
        Route::any('/{param1}/{param2}/{param3}/{param4}/{param5}', ['uses'  => 'DepartmentController@index']);
        Route::any('/{param1}/{param2}/{param3}/{param4}/{param5}/{param6}', ['uses'  => 'DepartmentController@index']);
    });



    // For Student
    Route::group(['prefix' => Roles::find(6)->name, 'namespace' => Roles::find(6)->view_path.'\\', 'middleware' => 'CheckUserLoginRoles'], function () {
        Route::any('/', ['uses' => 'StudentController@index']);
        Route::any('/{param1}', ['uses' => 'StudentController@index']);
        Route::any('/{param1}/{param2}', ['uses' => 'StudentController@index']);
        Route::any('/{param1}/{param2}/{param3}', ['uses' => 'StudentController@index']);
        Route::any('/{param1}/{param2}/{param3}/{param4}', ['uses' => 'StudentController@index']);
        Route::any('/{param1}/{param2}/{param3}/{param4}/{param5}', ['uses' => 'StudentController@index']);

        Route::any('general/', ['uses' =>  'StudentController@general']);
        Route::any('general/{param1}', ['uses' => 'StudentController@general']);
        Route::any('general/{param1}/{param2}', ['uses' => 'StudentController@general']);
        Route::any('general/{param1}/{param2}/{param3}', ['uses' => 'StudentController@general']);
    });

    // For Teacher
    Route::group(['prefix' => Roles::find(8)->name, 'namespace' => Roles::find(8)->view_path.'\\', 'middleware' => 'CheckUserLoginRoles'], function () {
        Route::any('/', ['uses' => 'TeacherController@index']);
        Route::any('/{param1}', ['uses' => 'TeacherController@index']);
        Route::any('/{param1}/{param2}', ['uses' => 'TeacherController@index']);
        Route::any('/{param1}/{param2}/{param3}', ['uses' => 'TeacherController@index']);
        Route::any('/{param1}/{param2}/{param3}/{param4}', ['uses' => 'TeacherController@index']);
        Route::any('/{param1}/{param2}/{param3}/{param4}/{param5}', ['uses' => 'TeacherController@index']);

        Route::any('general/', ['uses' =>  'TeacherController@general']);
        Route::any('general/{param1}', ['uses' => 'TeacherController@general']);
        Route::any('general/{param1}/{param2}', ['uses' => 'TeacherController@general']);
        Route::any('general/{param1}/{param2}/{param3}', ['uses' => 'TeacherController@general']);
        Route::any('general/{param1}/{param2}/{param3}/{param4}', ['uses' => 'TeacherController@general']);
        Route::any('general/{param1}/{param2}/{param3}/{param4}/{param5}', ['uses' => 'TeacherController@general']);
    });

    // For Image
    Route::group(['prefix' => 'images', 'namespace' => 'Images\\'], function () {
        Route::any('/', ['uses'  => 'ImagesController@index']);
        Route::any('/{param1}', ['uses'  => 'ImagesController@index']);
        Route::any('/{param1}/{param2}', ['uses'  => 'ImagesController@index']);
        Route::any('/{param1}/{param2}/{param3}', ['uses'  => 'ImagesController@index']);
    });
    // For Video
    Route::group(['prefix' => 'videos', 'namespace' => 'Videos\\'], function () {
        Route::any('/', ['uses'  => 'VideosController@index']);
        Route::any('/{param1}', ['uses'  => 'VideosController@index']);
        Route::any('/{param1}/{param2}', ['uses'  => 'VideosController@index']);
        Route::any('/{param1}/{param2}/{param3}', ['uses'  => 'VideosController@index']);
    });
    Route::group(['prefix' => 'feed', 'namespace' => 'ActivityFeed\\'], function () {
        Route::any('/', ['uses'  => 'ActivityFeedController@index']);
        Route::any('/{param1}', ['uses'  => 'ActivityFeedController@index']);
        Route::any('/{param1}/{param2}', ['uses'  => 'ActivityFeedController@index']);
        Route::any('/{param1}/{param2}/{param3}', ['uses'  => 'ActivityFeedController@index']);
    });

    Route::group(['prefix' => 'staff-register', 'namespace' => 'Staff\\'], function () {

        Route::any('/', ['uses'  => 'StaffRegisterController@index']);
        Route::any('/{param1}', ['uses'  => 'StaffRegisterController@index']);
        Route::any('/{param1}/{param2}', ['uses'  => 'StaffRegisterController@index']);
        Route::any('/{param1}/{param2}/{param3}', ['uses'  => 'StaffRegisterController@index']);
    });
    Route::group(['prefix' => 'student-register', 'namespace' => 'Student\\'], function () {

        Route::any('/', ['uses'  => 'StudentRegisterController@index']);
        Route::any('/{param1}', ['uses'  => 'StudentRegisterController@index']);
        Route::any('/{param1}/{param2}', ['uses'  => 'StudentRegisterController@index']);
        Route::any('/{param1}/{param2}/{param3}', ['uses'  => 'StudentRegisterController@index']);
    });


    // For User
    Route::group(['prefix' => Roles::find(9)->name, 'namespace' => Roles::find(9)->view_path.'\\', 'middleware' => 'CheckUserLoginRoles'], function () {
        Route::any('/', ['uses' => 'UsersController@index']);
        Route::any('/{param1}', ['uses' => 'UsersController@index']);
        Route::any('/{param1}/{param2}', ['uses' => 'UsersController@index']);
        Route::any('/{param1}/{param2}/{param3}', ['uses' => 'UsersController@index']);
        Route::any('/{param1}/{param2}/{param3}/{param4}', ['uses' => 'UsersController@index']);
        Route::any('/{param1}/{param2}/{param3}/{param4}/{param5}', ['uses' => 'UsersController@index']);

        Route::any('general/', ['uses' =>  'UsersController@general']);
        Route::any('general/{param1}', ['uses' => 'UsersController@general']);
        Route::any('general/{param1}/{param2}', ['uses' => 'UsersController@general']);
        Route::any('general/{param1}/{param2}/{param3}', ['uses' => 'UsersController@general']);
    });
});
