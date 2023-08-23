<?php

session_start();

// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET, POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
  
// get database connection
include_once '../config/database.php';
  
// instantiate product object
include_once '../models/Login.php';
  
$database = new Database();
$db = $database->getConnection();


// instantiate user object
$login = new Login($db);

 
// check email existence here
// get posted data
$data = json_decode(file_get_contents("php://input"));
 
// set email property values
$login->email = $data->email;
$email_exists = $login->emailExists();

// check if email exists and if password is correct
if($email_exists){
 
    if(password_verify($data->password, $login->password)){
           // set response code
          
            $strt=strtotime("now")-7200;
            $destroyConnected= $login->cleanConnected($strt);
            $endConnected= $login->disconnected($login->id_user);
            $_SESSION['id_user']= $login->id_user;
            $_SESSION['firstname']= $login->firstname;
            $_SESSION['lastname']= $login->lastname;
            $_SESSION['role'] = $login->role;
            $connected= $login->connected($login->id_user);
            
              http_response_code(200);  
                
    }else{
        http_response_code(404);  
    }
}else{
     // set response code user not authentified
     http_response_code(404); 
}
