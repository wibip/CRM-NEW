<?php
function get_mime_type($file)
{
    $mtype = false;
    if (function_exists('finfo_open')) {
    	$finfo = finfo_open(FILEINFO_MIME_TYPE);
    	$mtype = finfo_file($finfo, $file);
    	finfo_close($finfo);
    } elseif (function_exists('mime_content_type')) {
        $mtype = mime_content_type($file);
    }
    return $mtype;
}
function get_image_temp_name($extension)
{
    return uniqid('', true) . '.' . $extension;
}

function get_extension($file){
    $file_mime_type = get_mime_type($file);
    return explode('/', $file_mime_type)[1];
}