<?php
session_start();
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// get database connection
include_once '../config/database.php';

// instantiate product object
include_once '../models/Profil.php';

$database = new Database();
$db = $database->getConnection();


// instantiate user object
$modify = new Profil($db);

// set user property values

$data = json_decode(file_get_contents("php://input"));
 
// set user property values
$modify->email = $data->email;
$modify->password = $data->password;
$modify->firstname = $data->firstname;
$modify->lastname = $data->lastname;


if(!empty($_SESSION['id_user'])){

   $id_user= $_SESSION['id_user'];

//check if session open

    $modifyProfil = $modify->modifyProfil($id_user);

    if($modifyProfil){

    // set response code
    http_response_code(200);

    echo json_encode(
            array(
                "message" => "Profil Modifié.",
            )
        );
    }else{

    // set response code
    http_response_code(503);

    }
}else{http_response_code(406);}
