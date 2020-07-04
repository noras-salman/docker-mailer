<?php

require_once(__DIR__."/Request.php");


header("Access-Control-Allow-Orgin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
header('Content-Type: application/json');

class Api{

    public $version_dir;
    public $resources;

    public function __construct(){
        $versions = glob(__DIR__."/../v".$_GET["version"], GLOB_ONLYDIR);
 
        if(count($versions)==0){
            //error(400,"Bad Request");
            error(404,"Version not found");
        }
        $this->version_dir=$versions[0];
        $this->resources=array();
    }

    public function addResource($resource_name,$resource_obj){
        $this->resources[$resource_name]= $resource_obj;
    }

    public function build(){
        if(!isset($this->resources[$_GET["resource"]])){
            error(404,"Resource not found");
        }

 //       $_GET["version"];
//$_GET["resource"];
//$_GET["path_parameter"];

        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $this->resources[$_GET["resource"]]->get();
        }else if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->resources[$_GET["resource"]]->post();
        }else  if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
            $this->resources[$_GET["resource"]]->put();
        }else  if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
            $this->resources[$_GET["resource"]]->delete();
        }  

    }

}
?>