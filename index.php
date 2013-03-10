<?php

// directory name with subdirectories for categories, images in subdirs.
$IMAGES_DIR = 'images';
$THUMBNAIL_WIDTH = 320; //pixels
$CODE_EXPIRES = 7; // days
$CODE_SIZE = 4; // numbers
// random number that protects YOUR version of portfolio against attack.
// You MUST change this number from the default otherwise others who know
// this source code will be able to access your images.
// make it a really big number.
$SALT = 0;
// Administrator password, you MUST change this for your site to be secure.
$PASSWORD = 'portfolio';

function get_categories()
{
    global $IMAGES_DIR;
    global $CODE_EXPIRES;
    global $CODE_SIZE;
    global $SALT;
    global $PASSWORD;

    $files = array();
    $dir = opendir($IMAGES_DIR);
    while( false !== ($file = readdir($dir))) {
        $path = "${IMAGES_DIR}/${file}";
        if( $file != "." && $file != ".." && is_dir( $path )) {
            if ( stripos( $file, "Private" ) === false ) {
                $files[] = $file;
            } else if( array_key_exists( 'code', $_COOKIE )) {
                $code = $_COOKIE['code'];
                if( $code == $PASSWORD ) {
                    $files[] = $file;
                } else {
                    $date = time();
                    $date = $date - ($date % 86400);
                    $enddate = $date + (86400 * $CODE_EXPIRES);
                    while( $date <= $enddate ) {
                        $cc = md5($date + $SALT);
                        $cc = substr( $cc, 0, $CODE_SIZE );
                        if( $code == $cc ) {
                            $files[] = $file;
                            break;
                        }
                        $date += 86400;
                    }
                }
            }
        }
    }
    closedir($dir);

    sort($files);
    return $files;
}

function get_images( $category )
{
    global $IMAGES_DIR;

    $dir = $IMAGES_DIR . "/" . $category;
    $files = array();
    $dir = opendir($dir);
    while( false !== ($file = readdir($dir))) {
        $path = "${IMAGES_DIR}/${category}/${file}";
        if( $file != "." && $file != ".." && strpos($file,"_thumbnail") === false && is_file( $path )) {
            $files[] = $file;
        }
    }
    closedir($dir);

    sort($files);
    return $files;
}

$SCRIPT = $_SERVER["REQUEST_URI"];
$SCRIPT_DIR = dirname($_SERVER["SCRIPT_NAME"]);
$QUERY = $_SERVER["QUERY_STRING"];

if( $QUERY == "cache.manifest" ) {

    header("Content-type: text/cache-manifest");
    print <<<EOF
CACHE MANIFEST
CACHE:
${SCRIPT_DIR}/resume.pdf
${SCRIPT_DIR}/jquery.min.js
${SCRIPT_DIR}/Animate.js
${SCRIPT_DIR}/Scroller.js
${SCRIPT_DIR}/EasyScroller.js

EOF;

    $categories = get_categories();
    foreach( $categories as $category ) {
        $images = get_images( $category );
        foreach( $images as $image ) {
            print "${SCRIPT_DIR}/${IMAGES_DIR}/${category}/${image}" . PHP_EOL;
            $thumbnail = preg_replace( '/(.jpg)$/i', '_thumbnail${1}', $image ); 
            print "${SCRIPT}?thumbnail=${IMAGES_DIR}/${category}/${image}" . PHP_EOL;
        }
    }

    print <<<EOF

NETWORK:
$SCRIPT?update

EOF;

} else if( $QUERY == "update" ) {

    header("Content-type: application/json");
    //header("Access-Control-Allow-Origin: " + $_SERVER["HTTP_HOST"]);
    header("Cache-Control: no-cache");
    print "{";

    if( array_key_exists( 'code', $_COOKIE )) {
        $code = $_COOKIE['code'];
        if( $code == $PASSWORD ) {
            $date = time();
            $date = $date - ($date % 86400) + (86400 * $CODE_EXPIRES);
            $cc = md5($date + $SALT);
            $cc = substr( $cc, 0, $CODE_SIZE );
            print "\"code\": \"${cc}\",";
        }
    }

    $categories = get_categories();
    foreach( $categories as $category ) {
        print "\"${category}\":[";

        $images = get_images( $category );
        foreach( $images as $image ) {
            print "\"${image}\",";
        }

        print "\"\"],";
    }

    print "\"path\": \"${SCRIPT_DIR}/${IMAGES_DIR}\"";
    print "}";

} else if( substr( $QUERY, 0, 10 ) == "thumbnail=" ) {

    $path = substr( $QUERY, 10 );
    $path = rawurldecode( $path );
    $path = "${IMAGES_DIR}/" . $path;
    $thumbnail = preg_replace( '/(.jpg)$/i', '_thumbnail${1}', $path ); 

    if( is_file( $path )) {
        if( is_file( $thumbnail ) === false ) {
            $image = imagecreatefromjpeg( $path );
            $width = imagesx( $image );
            $height = imagesy( $image );
            $new_width = $THUMBNAIL_WIDTH;
            $new_height = $height * $new_width / $width;
            $new_image = imagecreatetruecolor( $new_width, $new_height );
            imagecopyresampled( $new_image, $image, 0,0,0,0, $new_width, $new_height, $width, $height );
            imagejpeg( $new_image, $thumbnail, 75 );
        }
    }

    header("Content-Type: image/jpeg");
    header("Content-Length: " . (string)filesize($thumbnail));
    readfile($thumbnail);

} else {
    header("Content-type: text/html; charset=iso-8859-1");
    readfile("_index.html");
}
?>
