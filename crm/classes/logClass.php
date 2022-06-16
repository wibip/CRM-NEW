<?php
/* No cache*/
header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1.
header("Pragma: no-cache"); // HTTP 1.0.
header("Expires: 0"); // Proxies.include_once 'classes/dbClass.php';

require_once __DIR__.'/dbClass.php';

date_default_timezone_set(date_default_timezone_get());
class logs{		
	private $file_path,$file_size_max,$db;
	function  __construct($script,$user){
		$this->db = new db_functions();
		$this->script=$script;
		$this->user=$user;
	}	
	function save($log_id,$text,$details){
		$respond_message=array("status"=>"Success","message"=>"Successed");
		$extension=".txt";
		try{
            $this->file_path=$this->db->setVal('LOGS_FILE_DIR','ADMIN');
		}
		catch(Exception $e){
			print("error :-".$e->getMessage);
		}

		$this->file_name="BI-logs";
		try{
			$this->file_size_max=$this->db->setVal('LOGS_FILE_SIZE','ADMIN');
		}
		catch(Exception $e){
			print("error :-".$e->getMessage);
		}
		//log write
		$myfile = fopen($this->file_path."/".$this->file_name.$extension, "a");
		if (!$myfile) {
			$respond_message["status"]="Error";
			$respond_message["message"]="File open failled.";
			return  $respond_message;
		}
		$log_message="[".date("D M d H:i:s Y")."]  ".$log_id."|".$this->user."|".$this->script."|".$text."|".$details;	

		if ( !(fwrite($myfile, $log_message."\n"))) {
			$respond_message["status"]="Error";
			$respond_message["message"]="File write failled.";
			return  $respond_message;
		}
		if ( !fclose($myfile)) {
			$respond_message["status"]="Error";
			$respond_message["message"]="File close failled.";
			return  $respond_message;
		}		
		try {
			$file_size=filesize($this->file_path."/".$this->file_name.$extension);						
		}
		catch (ErrorException $e){
			$respond_message["status"]="Error";
			$respond_message["message"]=$e->getMessage;
			return  $respond_message;		
		}
		if($file_size>=($this->file_size_max*1024*1024)){
			$n_file_name=$this->file_name.date("Y-m-d-H-i-s");
			if(!rename($this->file_path."/".$this->file_name.$extension,$this->file_path."/".$n_file_name.$extension)){
				$respond_message["status"]="Error";
				$respond_message["message"]=$e->getMessage;
				return  $respond_message;		
			}			
		}		
		return $respond_message;		
	}

    function saveError($log_id,$text,$details){
        $respond_message=array("status"=>"Success","message"=>"Successed");
        $extension=".txt";
        try{
            $this->file_path=$this->db->setVal('LOGS_FILE_DIR','ADMIN');
        }
        catch(Exception $e){
            print("error :-".$e->getMessage);
        }

        $this->file_name="BI-error-logs";
        try{
            $this->file_size_max=$this->db->setVal('LOGS_FILE_SIZE','ADMIN');
        }
        catch(Exception $e){
            print("error :-".$e->getMessage);
        }
        //log write
        $myfile = fopen($this->file_path."/".$this->file_name.$extension, "a");
        if (!$myfile) {
            $respond_message["status"]="Error";
            $respond_message["message"]="File open failled.";
            return  $respond_message;
        }
        $log_message="[".date("D M d H:i:s Y")."]  ".$log_id."|".$this->user."|".$this->script."|".$text."|".$details;

        if ( !(fwrite($myfile, $log_message."\n"))) {
            $respond_message["status"]="Error";
            $respond_message["message"]="File write failled.";
            return  $respond_message;
        }
        if ( !fclose($myfile)) {
            $respond_message["status"]="Error";
            $respond_message["message"]="File close failled.";
            return  $respond_message;
        }
        try {
            $file_size=filesize($this->file_path."/".$this->file_name.$extension);
        }
        catch (ErrorException $e){
            $respond_message["status"]="Error";
            $respond_message["message"]=$e->getMessage;
            return  $respond_message;
        }
        if($file_size>=($this->file_size_max*1024*1024)){
            $n_file_name=$this->file_name.date("Y-m-d-H-i-s");
            if(!rename($this->file_path."/".$this->file_name.$extension,$this->file_path."/".$n_file_name.$extension)){
                $respond_message["status"]="Error";
                $respond_message["message"]=$e->getMessage;
                return  $respond_message;
            }
        }
        return $respond_message;
    }
}
