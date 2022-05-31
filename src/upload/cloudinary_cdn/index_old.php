<?php


require 'cloudinary/autoload.php';
require 'settings.php';

class image_library
{


    private $temp_path;
    private $archive_path;
    private $folder;

    public function __construct($type, $template=null)
    {

        switch($type){
            case 'campaign':
                //$folder = 'ads';
                $folder = 'samples/ads';
                break;
            case 'theme':
                $folder = 'samples/template/'.$template.'/gallery/';
                break;
            
        }

        $this->temp_path = "import/temp_images/";
        $this->folder = $folder;
        //$this->archive_path = $this->folder.'/archive';
        
    }

    public function get_image_path($location=null){

        if(empty($location) || $location==null){
            return $this->folder;
        }else{
            return $this->folder.$location;
        }
        
    }

    public function get_temp_file_path(){


        return $this->temp_path;
        
    }

    public function get_archive_file_path($location=null){

        $img_path = $this->get_image_path($location);
        return $img_path.'/archive/';
        
    }

    public function remove_temp_image($image_id){

        $temp_path = $this->get_temp_file_path();

        $temp_img = $temp_path.$image_id;

        if(unlink($temp_img)){
            return 1;
        }else{
            return 0;
        }
        //or die("Couldn't delete file");
        
    }

    public function is_exists($image_id,$location=null)
    {
        $path = $this->get_image_path($location);

        $without_extension = pathinfo($image_id , PATHINFO_FILENAME);

        $image = $path.'/'.$without_extension;

        try{

			$result= \Cloudinary\Uploader::explicit($image, array("type" => "upload"));
            return 1;
            
		}catch(Exception $e) {

            return 0;
            
		}
    }



    public function image_upload($image_id,$location=null)
    {
    
        $old_path = $this->get_temp_file_path();

        $old_image = $old_path.$image_id;

        $new_path = $this->get_image_path($location);

        
        try{
            $reply = \Cloudinary\Uploader::upload($old_image,array("use_filename" => TRUE,
            "resource_type" => "auto",
            "folder" => $new_path,
            "unique_filename" => "false",
            "invalidate" => TRUE
        ));
            $remove_temp = $this->remove_temp_image($image_id);
            return 1;
        }catch(Exception $e) {

            return 0;
            
		}

        
    }

    public function get_image($image_id,$location=null){

        $image_folder_path = $this->get_image_path($location);

        $image_path = $image_folder_path.'/'.$image_id;
        //$image_path = 'samples/bike.jpg';

        $url = Cloudinary::cloudinary_url($image_path);       

        return $url;
   
        
    }

    public function remove_image($image_id,$location=null){

        $exp = explode("_",$image_id);
        //check default image
        $check_default = $exp[0];

        if(strtolower($check_default) != 'default' && strtolower($check_default) != 'generic'){
        

            $without_extension = pathinfo($image_id , PATHINFO_FILENAME);


            $image_path = $this->get_image_path($location);

            $image_to_move = $image_path.'/'.$without_extension;

            $move_to_path = $this->get_archive_file_path($location);

            $image_to_move2 = $move_to_path.'/'.$without_extension;

            //return $image_to_move.' ,'.$image_to_move2;

            try{
                \Cloudinary\Uploader::rename($image_to_move, $image_to_move2,array("invalidate" => TRUE));
                return 1;
            }catch(Exception $e){
                return 0;
            }
               
            

        }

    }

}

?>