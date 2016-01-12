<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/
/*Route::filter('auth', function()
{
    if(Auth::check() && !Auth::user()->estado())
        {
            Auth::logout();
            return Redirect::to('/');
        }

});*/
Route::get('/', function () {
    return view('welcome');
});
Route::get('auth/login', 'Auth\AuthController@getLogin');
Route::post('auth/login', ['as' =>'auth/login', 'uses' => 'Auth\AuthController@postLogin']);
Route::get('auth/logout', ['as' => 'auth/logout', 'uses' => 'Auth\AuthController@getLogout']);

// Registration routes...
Route::get('auth/register', 'Auth\AuthController@getRegister');
Route::post('auth/register', ['as' => 'auth/register', 'uses' => 'Auth\AuthController@postRegister']);

Route::get('password/email', 'Auth\PasswordController@getEmail');
Route::post('password/email', 'Auth\PasswordController@postEmail');

// Password reset routes...
Route::get('password/reset/{token}', 'Auth\PasswordController@getReset');
Route::post('password/reset', 'Auth\PasswordController@postReset');
Route::group(['prefix'=> 'sistema', 'namespace' => 'Sistema'], function()
{
    Route::get('succes', 'LoginController@loginExitoso');
});
Route::filter('is_admin', function()
{
    if(Auth::user()->tipo_usuario != 3 ) return Redirect::to('/');
});
Route::group(['before' => 'is_admin', 'prefix'=> 'admin', 'namespace' => 'Admin'], function()
{
    Route::get('home', 'GeneralController@index');
    Route::get('crear/admin', 'UsuarioController@admin');
    Route::post('admin/save', 'UsuarioController@save_admin');
    Route::get('crear/docente', 'UsuarioController@docente');
    Route::post('docente/save', 'UsuarioController@save_docente');
    Route::get('crear/secretaria', 'UsuarioController@secretaria');
    Route::post('secretaria/save', 'UsuarioController@save_secre');
    Route::get('crear/estudiante', 'UsuarioController@estudiante');
    Route::post('estudiante/save', 'UsuarioController@save_estudiante');
    Route::get('crear/director', 'UsuarioController@director');
    Route::post('director/save', 'UsuarioController@save_director');
    Route::get('modificar', 'UsuarioController@modificar');
});
Route::filter('is_estudiante', function()
{
    if(Auth::user()->tipo() != 'Estudiante' ) return Redirect::to('/');
});
Route::group(['before' => 'is_estudiante', 'prefix'=> 'estudiante', 'namespace' => 'Estudiante'], function()
{
    Route::get('home', 'EstudianteController@index');
});

Route::filter('is_docente', function()
{
    if(Auth::user()->tipo() != 'Docente' ) return Redirect::to('/');
});
Route::group(['before' => 'is_docente', 'prefix'=> 'docente', 'namespace' => 'Docente'], function()
{
    Route::get('home', 'DocenteController@index');
});

Route::filter('is_director', function()
{
    if(Auth::user()->tipo() != 'Director' ) return Redirect::to('/');
});
Route::group(['before' => 'is_director', 'prefix'=> 'director', 'namespace' => 'Director'], function()
{
    Route::get('home', 'DirectorController@index');
})

;Route::filter('is_secre', function()
{
    if(Auth::user()->tipo() != 'Secretaria' ) return Redirect::to('/');
});
Route::group(['before' => 'is_secre', 'prefix'=> 'secretaria', 'namespace' => 'Secretaria'], function()
{
    Route::get('home', 'SecretariaController@index');
});