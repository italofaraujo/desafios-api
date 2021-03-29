<?php
use Pecee\SimpleRouter\SimpleRouter;

SimpleRouter::get('/users', 'UserController@index');
SimpleRouter::post('/users', 'UserController@store');
SimpleRouter::post('/users/login', 'UserController@login');

SimpleRouter::group(['middleware' => \Desafios\App\Http\Middlewares\AuthMiddleware::class], function () {
    SimpleRouter::get('/challenges', 'ChallengeController@index');
    SimpleRouter::get('/challenges/{id}', 'ChallengeController@show');
});

SimpleRouter::get('/unauthorized', function () {
    http_response_code(401);
    return 'Acesso não autorizado';
})->name('unauthorized');
