<?php 
include_once(str_replace('//','/',dirname(__FILE__).'/') .'../../../classes/dbClass.php');

class image_library
{

    private $image_url;
    private $temp_path;
    private $archive_path;

    public function __construct($type, $template=null)
    {
        $this->db_class = new db_functions();
        $path_q=$this->db_class->selectDB("SELECT settings_value FROM exp_settings WHERE settings_code = 'portal_base_folder' AND distributor='ADMIN'");
        foreach($path_q['data'] as $path_r){
            $base_url = $path_r['settings_value'];
        }

        switch($type){
            case 'campaign':
                $path = $base_url.'/ads/';//ads
                break;
            case 'theme':
                $path = $base_url.'/template/'.$template.'/gallery/';
                break;
			case 'dynamic':
				$dynamic_q=$this->db_class->selectDB("SELECT settings_value FROM exp_settings WHERE settings_code = 'global_url' AND distributor='ADMIN'");
				foreach($dynamic_q['data'] as $dynamic_r){
					$dynamic_url = $dynamic_r['settings_value'];
				}
                //$path = $dynamic_url.'/image_upload/';
				$path = 'image_upload/';
                break;
            case 'tenant':
				$dynamic_q=$this->db_class->selectDB("SELECT settings_value FROM exp_settings WHERE settings_code = 'mdu_portal_base_url' AND distributor='ADMIN'");
				foreach($dynamic_q['data'] as $dynamic_r){
					$dynamic_url = $dynamic_r['settings_value'];
				}
                //$path = $dynamic_url.'/img/';  
				//$path = '../tenant/layout/DYNAMIC/img/';  
                $path = '../tenant/img/logo/';  
                break;
				
        }

        $this->image_url = $path;
        //$this->temp_path = "import/temp_images/";
        $this->temp_path = $base_url.'/ads/temp/';
        //$this->archive_path = $this->image_url.'archive/';
    }


    public function get_image_path($location=null){

		if(empty($location) || $location==null){
			return $this->image_url; 
		}else{
			return $this->image_url.$location.'/';
		}
        
        
    }

    public function get_temp_file_path(){


        return $this->temp_path;
        
    }

    public function get_archive_file_path($location=null){
 
		$img_path = $this->get_image_path($location);
		return $img_path.'archive/';
			      
    }

    public function is_exists($image_id, $location=null)
    {
        $path = $this->get_image_path($location);
        $image = $path.$image_id;

        if(file_exists($image)){
            return 1;
        }else{
            return 0;
        }
    }

    public function image_upload($image_id, $location=null){ 
        
        $old_path = $this->get_temp_file_path();

        $new_path = $this->get_image_path($location);

        $old_image = $old_path.$image_id;

        $new_image = $new_path.$image_id;
		
		//return $new_image;

        if(rename($old_image, $new_image)){
            return 1;

        }


    }
	
	public function image_upload2($image_id, $location=null){ 
        
        $old_path = $this->get_temp_file_path();

        $new_path = $this->get_image_path($location);

        $old_image = $old_path.$image_id;

        $new_image = $new_path.$image_id;
		
		//return $old_image;

        if(copy($old_image, $new_image)){
            return 1;

        }


    }

    public function get_image($image_id, $location=null){

        $image_folder_path = $this->get_image_path($location);

        $image_path = $image_folder_path.$image_id;
 
        return $image_path;
    
        
    }


    public function remove_temp_image($image_id){

        $temp_img = $image_id;
        unlink($temp_img);
        //or die("Couldn't delete file");
        
    }


    public function remove_image($image_id, $location=null){
        $exp = explode("_",$image_id);
        //check default image
        $check_default = $exp[0];

        if(strtolower($check_default) != 'default' && strtolower($check_default) != 'generic'){
        

            $image_path = $this->get_image_path($location);

            $image = $image_id;

            $image_to_move = $image_path.$image;

            //$move_to_path = $this->get_archive_file_path($location);

            //$image_to_move2 = $move_to_path.$image;
            $image_to_move2 = $image_path.'archive_'.$image;

            if(rename($image_to_move, $image_to_move2)){
                return "old image deleted";
            }else{
                return "old image deletion faild";
            }

        }
    }

    




}

            
 
	

?>
