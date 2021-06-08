<?php

session_start();

/*
 *  root path  or project path
 */

if (!function_exists('root_path')) {
    function root_path($path = '')
    {
        $path = trim($path, '/');
        return dirname(dirname(__FILE__)) . '/' . $path;
    }
}

if (!function_exists('base_url')) {
    function base_url($uri = '')
    {
        $path = trim($uri, '/');
        $http_s = $_SERVER['REQUEST_SCHEME'];
        $serverName = $_SERVER['SERVER_NAME'];
        return $http_s . "://" . $serverName . '/' . $path;
    }
}


if (!function_exists('backend_url')) {
    function backend_url($uri = '')
    {
        $path = trim($uri, '/');
        return base_url("backend/" . $path);
    }
}


if (!function_exists('messages')) {
    function messages()
    {
        $outPut = '';
        if (isset($_SESSION['success'])) {
            $outPut .= "<div class='alert alert-success'>";
            $outPut .= $_SESSION['success'];
            unset($_SESSION['success']);
            $outPut .= "</div>";
        }

        if (isset($_SESSION['error'])) {
            $outPut .= "<div class='alert alert-danger'>";
            $outPut .= $_SESSION['error'];
            unset($_SESSION['error']);
            $outPut .= "</div>";


        }

        return $outPut;
    }
}

if (!function_exists('redirect_to')) {
    function redirect_to($path = '')
    {
        $path = trim($path, '/');
        $baseUrl = base_url($path);
        header('Location:' . $baseUrl);
        exit();
    }
}
if (!function_exists('redirect_back')) {
    function redirect_back()
    {
        $referer = $_SERVER['HTTP_REFERER'];
        if (isset($referer)) {
            header('Location:' . $_SERVER['HTTP_REFERER']);
            exit();
        }
    }
}