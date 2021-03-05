<?php

$router->get('/', function () use ($router) {
    return 'Hello, world!';
});

$router->group(['prefix' => 'api'], function () use ($router) {

    // Auth
    $router->group(['prefix' => 'auth'], function () use ($router) {
        $router->post('login', ['as' => 'auth.login', 'uses' => 'Auth\AuthController@login']);
        $router->post('register', ['as' => 'auth.register', 'uses' => 'Auth\AuthController@register']);
    });

    $router->group(['prefix' => 'user'], function () use ($router) {
        $router->get('/', ['as' => 'user.get', 'uses' => 'Auth\AuthController@get']);
        $router->get('/{id:[0-9]+}', ['as' => 'user.get.by.id', 'uses' => 'Auth\AuthController@get']);
    });

    // Board
    $router->group(['prefix' => 'board'], function () use ($router) {
        $router->get('/', ['as' => 'board.get', 'uses' => 'Board\BoardController@get']);
        $router->get('/{id:[0-9]+}', ['as' => 'board.get.by.id', 'uses' => 'Board\BoardController@get']);
        $router->post('/', ['as' => 'board.store', 'uses' => 'Board\BoardController@store']);
        $router->patch('/{id:[0-9]+}', ['as' => 'board.update', 'uses' => 'Board\BoardController@update']);
        $router->delete('/{id:[0-9]+}', ['as' => 'board.delete', 'uses' => 'Board\BoardController@delete']);
    });

    // Task Group
    $router->group(['prefix' => 'taskGroup'], function () use ($router) {
        $router->get('/', ['as' => 'taskGroup.get', 'uses' => 'TaskGroup\TaskGroupController@getByPosition']);
        $router->get('/{id:[0-9]+}', ['as' => 'taskGroup.get.by.id', 'uses' => 'TaskGroup\TaskGroupController@get']);
        $router->post('/', ['as' => 'taskGroup.store', 'uses' => 'TaskGroup\TaskGroupController@store']);
        $router->patch('/{id:[0-9]+}', ['as' => 'taskGroup.update', 'uses' => 'TaskGroup\TaskGroupController@update']);
        $router->delete('/{id:[0-9]+}', ['as' => 'taskGroup.delete', 'uses' => 'TaskGroup\TaskGroupController@delete']);
    });

    // Task
    $router->group(['prefix' => 'task'], function () use ($router) {
        $router->get('/', ['as' => 'task.get', 'uses' => 'Task\TaskController@getByPosition']);
        $router->get('/{id:[0-9]+}', ['as' => 'task.get.by.id', 'uses' => 'Task\TaskController@get']);
        $router->post('/', ['as' => 'task.store', 'uses' => 'Task\TaskController@store']);
        $router->patch('/{id:[0-9]+}', ['as' => 'task.update', 'uses' => 'Task\TaskController@update']);
        $router->delete('/{id:[0-9]+}', ['as' => 'task.delete', 'uses' => 'Task\TaskController@delete']);
    });
});
