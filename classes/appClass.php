<?php




class app_functions
{

    ////////////////////////////////////////////////////////////////////
    function encrypt_decrypt($action, $string) {
        $output = false;
        $key = "encriptPassword";
        $encrypt_method = "AES-256-CBC";
        $secret_key = $key;
        $secret_iv = $key;

        // hash
        $key = hash('sha256', $secret_key);

        // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
        $iv = substr(hash('sha256', $secret_iv), 0, 16);

        if( $action == 'encrypt' ) {
            $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
            $output = base64_encode($output);
        }
        else if( $action == 'decrypt' ){
            $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
        }

        return $output;
    }

    ////////////////////////////////////////////////////////////////////
    /*
    * php delete function that deals with directories recursively
    */
    public static function deleteDirContent($dirPath) {
        if (! is_dir($dirPath)) {
            throw new InvalidArgumentException("$dirPath must be a directory");
        }
        if (substr($dirPath, strlen($dirPath) - 1, 1) != '/') {
            $dirPath .= '/';
        }
        $files = glob($dirPath . '*', GLOB_MARK);
        foreach ($files as $file) {
            if (is_dir($file)) {
                self::deleteDirContent($file);
            } else {
                unlink($file);
            }
        }
        rmdir($dirPath);
    }

}

?>