<?php

require_once '../Manager/DataManager.php';
require_once '../Data/Data.php';
require '.././libs/Slim/Slim.php';

use Slim\Middleware\HttpBasicAuthentication;

\Slim\Slim::registerAutoloader();

$app = new \Slim\Slim();
$app->add(new HttpBasicAuthentication([
    "path" => "/api",
    "realm" => "Protected",
    "users" => [
        "root" => "t00r",
        "someone" => "passw0rd"
    ]
]));

$app->post('/api/employeeinsert', function () use ($app) {
    verifyRequiredParams(array('title', 'emp_name', 'salary'));
    $response = array();
    $employee=new Data();
    $employee->setTitle($app->request->post('title'));
    $employee->setName($app->request->post('emp_name'));
    $employee->setSalary($app->request->post('salary'));

    $db = new DataManager();
    $res = $db->insertEmployee($employee);

    if ($res > 0) {
        $response["error"] = false;
        $response["message"] = "employee added";
        echoResponse(201, $response);
    } else{
        $response["error"] = true;
        $response["message"] = "Oops! An error occurred while registereing";
        echoResponse(200, $response);
    }
});


$app->post('/api/employeeupdate', function () use ($app) {
    verifyRequiredParams(array('id','title', 'emp_name', 'salary'));
    $response = array();
    $employee=new Data();
    $employee->setId($app->request->post('id'));
    $employee->setTitle($app->request->post('title'));
    $employee->setName($app->request->post('emp_name'));
    $employee->setSalary($app->request->post('salary'));

    $db = new DataManager();
    $res = $db->updateEmployee($employee);

    $response['employees'] = array();

    if ($res) {
        $response["error"] = false;
        $response["message"] = "employee updated";
        array_push($response['employees'],$res);
        echoResponse(201, $response);
    } else{
        $response["error"] = true;
        $response["message"] = "Oops! An error occurred while update";
        echoResponse(200, $response);
    }
});



$app->post('/api/employeedelete', function () use ($app) {
    verifyRequiredParams(array('id'));
    $response = array();

    $db = new DataManager();
    $res = $db->deleteEmployee($app->request->post('id'));


    if ($res>0) {
        $response["error"] = false;
        $response["message"] = "employee deleted";
        echoResponse(201, $response);
    } else{
        $response["error"] = true;
        $response["message"] = "Oops! An error occurred while delete";
        echoResponse(200, $response);
    }
});


$app->get('/api/employee', function() use ($app){
    $db = new DataManager();
    $result = $db->GetAllemployee();

    $response = array();
    $response['error'] = false;
    $response['employees'] = array();


    if($result){
        $response['message'] = "success";
        array_push($response['employees'],$result);
    }else{
        $response['error'] = true;
        $response['message'] = "Could not submit assignment";
    }

    echoResponse(200,$response);
});



$app->get('/api/employee/:id', function($employeeid) use ($app){
    $db = new DataManager();
    $result = $db->GetEmployee($employeeid);

    $response = array();
    $response['error'] = false;
    $response['employees'] = array();


    if($result){
        $response['message'] = "success";
        array_push($response['employees'],$result);
    }else{
        $response['error'] = true;
        $response['message'] = "Could not submit assignment";
    }

    echoResponse(200,$response);
});

function echoResponse($status_code, $response)
{
    $app = \Slim\Slim::getInstance();
    $app->status($status_code);
    $app->contentType('application/json');
    echo json_encode($response);
}


function verifyRequiredParams($required_fields)
{
    $error = false;
    $error_fields = "";
    $request_params = $_REQUEST;

    if ($_SERVER['REQUEST_METHOD'] == 'PUT') {
        $app = \Slim\Slim::getInstance();
        parse_str($app->request()->getBody(), $request_params);
    }

    foreach ($required_fields as $field) {
        if (!isset($request_params[$field]) || strlen(trim($request_params[$field])) <= 0) {
            $error = true;
            $error_fields .= $field . ', ';
        }
    }

    if ($error) {
        $response = array();
        $app = \Slim\Slim::getInstance();
        $response["error"] = true;
        $response["message"] = 'Required field(s) ' . substr($error_fields, 0, -2) . ' is missing or empty';
        echoResponse(400, $response);
        $app->stop();
    }
}


$app->run();