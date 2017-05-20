<?php
require_once 'TS.class.php';

$ts = new TS;

// open file cities.txt and stored information of file into array
$ts->storeMatrix('cities.txt');

// init the cost matrix moves between cities.
$ts->initMatrix();

// calculator to find shortest route base on Nearest neighbor algorithm and begin with Beijing (=1) city .
$ts->compute(count($ts->locations), 1 , $ts->cost_matrix);

// print the result shortest distance and shortest route
echo "\nShortest Distance: " . $ts->cost . "\n\n";
echo "Shortest Route:\n";
$ts->printRoute();
echo "\n\n";
?>