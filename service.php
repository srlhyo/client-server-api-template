<?php

require "classes/loader.php";

$method = $_SERVER['REQUEST_METHOD']; // GET POST PUT DELETE

$query = array("resource" => "default");

$post = $_POST;

parse_str($_SERVER['QUERY_STRING'], $query);

$api = new Api();

$apiResponse = array();

try {
    switch ($query["resource"] . "-" . $method) {
        case 'users-GET':
            $apiResponse = $api->getUsers();
        break;
    
        case 'users-POST':
            $apiResponse = $api->createUser($post);
        break;

        case 'user-delete-GET':
            $apiResponse = $api->deleteUser($query);
        break;
        
        default:
            throw new Exception('Unavailable resource');
        break;
    }
} catch (Exception $e) {
    $apiResponse = array("error" => $e->getMessage());
    header("HTTP/1.1 500 An error occured");
}

echo json_encode($apiResponse);