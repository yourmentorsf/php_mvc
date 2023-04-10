<?php

namespace App\core;

define('CONTROLLERS_NAMESPACE', 'App\\controllers\\');
use App\controllers;

class Route
{
    public static function start()
    {
        // значения по умолчанию
        $controllerClassname = 'home';
        $actionName = 'index';
        $payload = [];

        // разбиваем адресную строку на серию запросов в формате /контроллер/действие/дополнительные/параметры/запроса
        $routes = explode(DIRECTORY_SEPARATOR, $_SERVER["REQUEST_URI"]);
        // var_dump($routes);

        // проверяем, указан ли контроллер и перезаписываем значение по умолчанию
        if(!empty($routes[1])) {
            $controllerClassname = $routes[1];
        }
        // проверяем, указано ли действие и перезаписываем значение по умолчанию
        $actionName = empty($routes[2]) ? 'index' : $routes[2];
        // var_dump($actionName);

        // проверяем, указаны ли доп. параметры и перезаписываем значение по умолчанию
        if(!empty($routes[3])) {
            $payload = array_slice($routes, 3);
        }

        // создаём контроллер с указанием пространства имён (для автолоудера)
        $controllerName = CONTROLLERS_NAMESPACE . ucfirst(strtolower($controllerClassname));

        // создаём строку с предполагаемым названием файла нужного нам контроллера
        $controllerFile = ucfirst(strtolower($controllerClassname)) . '.php';
        // var_dump($controllerFile);

        // создаём строку с указанием пути к файлу контроллера
        $controller_path = CONTROLLER . $controllerFile;


        // проверяем наличие файла по данному пути и подключаем этот файл, если он есть
        if(file_exists($controller_path)) {
            include_once  $controller_path;
        } else {
            Route::Error(); // иначе, выводим сообщение об ошибке
        }

        // создаём экземпляр контроллера
        $controller = new $controllerName();

        // используем переменную method для удобства. Этот шаг необязателен
        $method = $actionName;

        // проверяем наличие метода в классе контроллера
        if(method_exists($controller, $method)) {
            $controller->$method($payload); // запуск метода = функции
        } else {
            Route::Error(); // иначе, выводим сообщение об ошибке
        }
    }

    // метод перенаправления на страницу ошибки
    public static function Error()
    {
        header('HTTP/1.1 404 Not Found');
        header('Status: 404  Not Found');
        header('Location:/error');
    }
}