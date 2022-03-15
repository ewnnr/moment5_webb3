
<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

require 'includes/config.php';
require 'includes/database.php';
require 'classes/Course.class.php';

//Läser in vilken metod som skickats och lagrar i en variabel
$method = $_SERVER['REQUEST_METHOD'];

//Om en parameter av id finns i urlen lagras det i en variabel
if(isset($_GET['id'])) {
    $id = $_GET['id'];
}
$database = new Database();
$db= $database->connect();
//Ny instans av klassen
$course = new Course($db);


switch($method) {
    case 'GET':
        //Skickar en "HTTP response status code"
        http_response_code(200); //Ok - The request has succeeded
        $response= $course->getCourses();

        if(count($response) == 0){
             //Lagrar ett meddelande som sedan skickas tillbaka till anroparen
            $response = array("message" => "There is nothing to get yet");

        }

        break;
    case 'POST':
        //Läser in JSON-data skickad med anropet och omvandlar till ett objekt.
        $data = json_decode(file_get_contents("php://input"));

        if($course->addCourse($data->code, $data->name, $data->progression, $data->coursesyllabus)){

            $response = array("message" => "Created");
            http_response_code(201); //Created

        }else{
            $response = array("message" => "Något gick fel, prova igen");
            http_response_code(500);//Server-fel
        }
        
        
        break;
    case 'PUT':
        //Om inget id är med skickat, skicka felmeddelande
        if(!isset($id)) {
            http_response_code(510);//400); //Bad Request - The server could not understand the request due to invalid syntax.
            $response = array("message" => "Du måste skicka med id");
        //Om id är skickad   
        } else {
            $data = json_decode(file_get_contents("php://input"));

          if($course->updateCourse($id, $data->code,$data->name, $data->progression, $data->coursesyllabus )) {
                 http_response_code(200);
            $response = array("message" => "Kurs uppdaterad");
          } else{
              http_response_code(503);
              $response = array ("message" => "Du måste skicka med id");
          }
      
        }
        break;
    case 'DELETE':
        if(!isset($id)) {
            http_response_code(510); //not extended
            $response = array("message" => "Inget id har skickats.");
            //om id har skickats
        } else {
            //kör funktion för att radera en rad
            if($course->deleteCourse($id)) {
                http_response_code(200); //ok
                $response = array("message" => "Kursen med id: $id är raderad.");
            } else {
                http_response_code(503); //server error
                $response = array("message" => "Kursen raderades inte, försök igen. ");
            }
        }
        break;
        
}

//Skickar svar tillbaka till avsändaren
echo json_encode($response);
