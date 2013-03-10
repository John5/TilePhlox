<?php

/**
 * Serve metadata from tileset as JSON
 * Implements https://github.com/mapbox/mbtiles-spec/blob/master/1.2/spec.md
*/ 

//without this header cross-domain request won't work
header('Access-Control-Allow-Origin: *');
$db = $_GET['db'];

try {
	$file = 'mbtiles/'.$db.'.mbtiles';
	if(file_exists($file)) {
		//@todo: get file modification date for caching headers
	} else {
		header($_SERVER['SERVER_PROTOCOL'].' 404 Not Found', true, 404);
		echo 'I have no idea what metadata you are talking about.';
	}
	
	$conn = new PDO('sqlite:'.$file);
	$q = $conn->prepare('SELECT name, value FROM metadata');
	$q->execute();
	$q->bindColumn(1, $name);
	$q->bindColumn(2, $value);
	$json = array();
	while($q->fetch()) {
		$json[$name] = $value;
	}
	header('Cache-Control: public');
	header('Content-Type: application/json');
	echo json_encode($json);
	exit();

} catch(PDOException $e) {
	header($_SERVER['SERVER_PROTOCOL'].' 500 Internal Server Error', true, 500);
	echo 'Exception : '.$e->getMessage();
}

?>