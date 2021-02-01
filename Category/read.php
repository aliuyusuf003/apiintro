<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
 
// database connection will be here


// include database and object files
include_once '../config/database.php';
include_once '../objects/category.php';
 
// instantiate database and category object
$database = new Database();
$db = $database->getConnection();
 
// initialize object
$category = new Category($db);
 
// read categorys will be here


// query categorys
$stmt = $category->read();
$num = $stmt->rowCount();
 
// check if more than 0 record found
if($num>0){
 
    // categorys array
    $categorys_arr=array();
    $categorys_arr["records"]=array();
 
    // retrieve our table contents
    // fetch() is faster than fetchAll()
    // http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        // extract row
        // this will make $row['name'] to
        // just $name only
        extract($row);
 
        $category_item=array(
            "id" => $id,
            "name" => $name,
            "description" => html_entity_decode($description)
            
        );
 
        array_push($categorys_arr["records"], $category_item);
    }
 
    // set response code - 200 OK
    http_response_code(200);
 
    // show categorys data in json format
    echo json_encode($categorys_arr);
    // print_r($categorys_arr);



}else{  // no categorys found 
 
    // set response code - 404 Not found
    http_response_code(404);
 
    // tell the user no categorys found
    echo json_encode(
        array("message" => "No categorys found.")
    );
}


 
