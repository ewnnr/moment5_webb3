<?php
include("includes/config.php");

$db = new mysqli(DBHOST, DBUSER, DBPASS, DBDATABASE);
if($db->connect_errno>0){
    die ('Fel vid anslutning ['. $db->connect_error . ']');
}

$sql = "DROP TABLE IF EXISTS courses;
CREATE TABLE courses(
    id INT (11) PRIMARY KEY AUTO_INCREMENT,
    code VARCHAR(64) NOT NULL,
    name VARCHAR(64) NOT NULL,
    progression VARCHAR(1) NOT NULL, 
    coursesyllabus VARCHAR(64) NOT NULL
);";



//Skriv ut sql-frågan
echo "<pre>$sql</pre>";

//Skicka sql till DB
if($db->multi_query($sql)){
    echo "<p>Tabeller installerade.</p>";

} else{
    echo "<p class='error'>Fel vid installation av tabeller</p>";
}

?>
