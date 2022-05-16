<?php

include_once 'Database.php';

$types = Database::exec("SELECT * FROM `types`");

$durations =  Database::exec("SELECT * FROM `durations`");
    
$statuses =  Database::exec("SELECT * FROM `statuses`");

$data_relevance = false;

$data = null;

?>