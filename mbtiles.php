<?php

/*
 * Find a tile in a tileset and serve it as PNG.
 * JPEG is NOT supported at the moment.
 * based on https://github.com/bmcbride/PHP-MBTiles-Server/blob/master/mbtiles.php
*/
$db = $_GET['db'];
$z = intval($_GET['z']);
$x = intval($_GET['x']);
$y = intval($_GET['y']);

try {
	$file = 'mbtiles/'.$db.'.mbtiles';
	if(file_exists($file)) {
		//nothing, maybe later check file modification date for caching?
	} else {
		throw new Exception($db.' cannot be found');
	}
	// Open the database
	$db = new PDO('sqlite:'.$file);
	$q = $db->prepare('SELECT tile_data FROM tiles WHERE zoom_level='.$z.' AND tile_column='.$x.' AND tile_row='.$y);
	//echo 'SELECT tile_data FROM tiles WHERE zoom_level='.$z.' AND tile_column='.$y.' AND tile_row='.$x;
	$q->execute();
	$q->bindColumn(1, $tile_data, PDO::PARAM_LOB);
	while($q->fetch()) {
		//always cache the images
		if (isset($_SERVER['HTTP_IF_MODIFIED_SINCE'])) {
			header($_SERVER['SERVER_PROTOCOL'].' 304 Not Modified', true, 304);
		}
		header('Cache-Control: public');
		header('Content-Type: image/png');
		echo $tile_data;
		exit();
	}

	header($_SERVER['SERVER_PROTOCOL'].' 404 Not Found', true, 404);
	echo 'I have no idea what tile you are talking about.';

} catch(PDOException $e) {
	header($_SERVER['SERVER_PROTOCOL'].' 500 Internal Server Error', true, 500);
	echo 'Exception : '.$e->getMessage();
}

?>