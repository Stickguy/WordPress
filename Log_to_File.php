/*  Log to File on Server */
/*  Use this to log PHP values to a file on the Server
*   Treat this like a console.log in Javascript  */

function logToFile($filename, $msg){

/* Assign File Path */
$dir = '/home/user/public_html/' . $filename; /* hard coded path */
/* $dir = plugin_dir_path( __FILE__ ) . $filename; //WP Plugin Directory */

// open file
$fd = fopen($dir, "a");
// write string
fwrite($fd, $msg . "\n");
// close file
fclose($fd);
}

/* Usage: */
logToFile("ff_key.log", "keys: " . print_r($YOUR_VARIABLE_HERE, TRUE) );
