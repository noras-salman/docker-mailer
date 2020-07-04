<?php

if(!isset($_GET["version"]) && !isset($_GET["resource"])){
   error(400,"Bad Request");   
}


$query_string_post=strpos($_SERVER["REQUEST_URI"],"?");
if($query_string_post!==false){
     
        $query_string=substr($_SERVER["REQUEST_URI"],$query_string_post+1);
        $get=array();
        if(strlen($query_string)>0){
            $get=explode("&",$query_string);
            foreach($get as $var){
                $var=explode("=",$var);
                $_GET[$var[0]]=$var[1];
              
            }
        }
   
}

 
$_PUT=array();
$_DELETE=array();
if(!isset($_SERVER["CONTENT_TYPE"]) || $_SERVER["CONTENT_TYPE"]!='application/json'){
    //application/x-www-form-urlencoded
   // error(406,"Missing header => Content-Type: application/json");
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $_POST=convertInputToArray();
}else  if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    $_PUT=convertInputToArray();
}else  if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    $_DELETE=convertInputToArray();
} 
 
 

 
// 200 OK
//201 CREATED
function finish($code,$data=null){
    http_response_code($code);
    if($data!=null){
    echo json_encode($data);
    }else{
        $i=new stdClass();
        switch ($code) {
        case 204:
             $i->info="No Content";
             break;
        case 201:
             $i->info="Created";
             break;
        }
        echo json_encode($i);
    }
    exit();
}

function error($code,$message=null){
    http_response_code($code);
    $e=new stdClass();
    switch ($code) {
        case 400:
             $e->error="Bad Request"; //The client SHOULD NOT repeat the request without modifications.
            break;
        case 401:
             $e->error="Unauthorized"; //Authorization credentials required or missing
            break;
        case 403:
            $e->error="Forbidden"; //user does not have the necessary permissions for the resource
            break;
        case 404:
            $e->error="Not Found"; //can’t map the client’s URI to a resource but may be available in the future.
        case 405:
            $e->error="Method Not Allowed"; //use an HTTP method that the resource does not allow.
            break;
        case 406:
            $e->error="Not Acceptable"; //not json
            break;
        case 409:
            $e->error="Conflict"; // could not insert
            break;
        case 429:
            $e->error="Too Many Requests"; //  
            break;
        
    }
    
    if($message!=null)
        $e->message=$message;
    echo json_encode($e);
    exit();
}

function not_empty_if_available($var){
    if(isset($var)){
        if(is_array($var)){
            if(count($var)==0)
            error(400,"Required parameter is empty");
            return;
        }
        if(trim($var)=="")
             error(400,"Required parameter is empty");
    }   
    
}

function required($var){
    if(!isset($var))
        error(400,"Missing parameters");
    
    if(is_array($var)){
        if(count($var)==0)
        error(400,"Required parameter is empty");
        return;
    }
        

    if(trim($var)=="")
        error(400,"Missing parameters");
}

function convertInputToArray(){
	$data = json_decode(file_get_contents('php://input'), true);
	return (array)$data;
}



?>