<?php
include('includes/config.php');

$c = new Course();
$c->updateCourse(2, "DT3456", "Ny test","A", "http://miun.se" );

echo "<pre>";
var_dump($c->getCourses());
echo "</pre>";
