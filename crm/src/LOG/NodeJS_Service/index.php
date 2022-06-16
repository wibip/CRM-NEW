<?php
include_once dirname(__FILE__).'/../log_interface.php';

class NodeJS_Service implements log_interface{


    private $connection;

   public function __construct($connect)
   {
       $this->connection = $connect;
   }


    public function jsonPost($url, $jsonData, $action)
	{
		$ch = curl_init($url);

		$jsonDataEncoded = json_encode($jsonData);


		switch ($action) {

			case "POST":

					curl_setopt($ch, CURLOPT_POST, 1);
					curl_setopt($ch, CURLOPT_HEADER, 0);
					curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
					curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
					curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
					curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
					curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonDataEncoded);
			
				break;

			case "GET":

				curl_setopt($ch, CURLOPT_HEADER, 0);
				curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
				curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
				curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
				curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");

				break;

			case "PUT":

				curl_setopt($ch, CURLOPT_POST, 1);
				curl_setopt($ch, CURLOPT_HEADER, 0);
				curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
				curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
				curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
				curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PATCH");
				curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonDataEncoded);

				break;

			case "DELETE":

				curl_setopt($ch, CURLOPT_HEADER, 0);
				curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
				curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
				curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
				curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");



				break;



			default:

				break;

		}

		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

		return $result = curl_exec($ch);

	}

    // insert vsz log
    function createLog_VSZ(vsz_logs $getData){

        $function = $getData->getFunction();
        $function_name = $getData->getFunctionName();
        $description = $getData->getDescription();
        $method = $getData->getApiMethod();
        $realm = $getData->getRealm();
        $api_details = $getData->getApiDescription();
        $api_data = $getData->getApiData();
        $api_status = $getData->getApiStatus();

        $call_url = 'http://localhost:3800/log/vsz';
		
		
		$jsonData = array(
			"function"=> $function,
			"function_name"=> $function_name,
			"description"=> $description,
			"api_method"=> $method,
			"api_status"=> $api_status,
			"realm"=> $realm,
			"api_description"=> $api_details,
			"api_data"=> $api_data,
			"create_user"=>"API"
		);
		
		
		$request_array = json_encode($jsonData);
		$results=$this->jsonPost($call_url, $request_array, 'POST');

        return $results;

    }

 // get vsz log
    function getLogs_VSZ(vsz_logs $getData){

        $limit = $getData->limit;
        $realm = $getData->getRealm();
        $from = $getData->from;
        $to = $getData->to;
        $function = $getData->getFunction();

        $url_generate='limit='.urlencode($limit);

         if ($realm !="all"){
                $url_generate .='&realm='.urlencode($realm);
         }

         if ($function != null){
                $url_generate .='&function='.urlencode($function);
         }
         
        if ($to != NULL && $from != NULL) {   
                $url_generate .='&from='.urlencode($from).'&to='.urlencode($to);
        }

        $call_url = 'http://localhost:3800/log/vsz?'.$url_generate;
		
		$json_data=array();
		
		$request_array = json_encode($json_data);
		$results=$this->jsonPost($call_url, $json_data, 'GET');

        return $results;

    }

// insert vsz log



    public function readLog_VSZ($id)
    {
        // TODO: Implement readLog() method.
    }

    public function createLog_AAA(aaa_logs $getData)
    {
        // TODO: Implement createLog_AAA() method.
    }

    public function getLogs_AAA(aaa_logs $getData)
    {
        // TODO: Implement getLogs_AAA() method.
    }

    public function readLog_AAA($id)
    {
        // TODO: Implement readLog_AAA() method.
    }

    public function createLog_SESSION(session_logs $getData)
    {
        // TODO: Implement createLog_SESSION() method.
    }

    public function getLogs_SESSION(session_logs $getData)
    {
        // TODO: Implement getLogs_SESSION() method.
    }

    public function readLog_SESSION($id)
    {
        // TODO: Implement readLog_SESSION() method.
    }

    public function createLog_AUTH(auth_logs $getData)
    {
        // TODO: Implement createLog_AUTH() method.
    }

    public function getLogs_AUTH(auth_logs $getData)
    {
        // TODO: Implement getLogs_AUTH() method.
    }

    public function readLog_AUTH($id)
    {
        // TODO: Implement readLog_AUTH() method.
    }

    public function createLog_USER(user_logs $getData)
    {
        // TODO: Implement createLog_USER() method.
    }

    public function getLogs_USER(user_logs $getData)
    {
        // TODO: Implement getLogs_USER() method.
    }

    public function readLog_USER($id)
    {
        // TODO: Implement readLog_USER() method.
    }

    public function createLog_REDIRECTION(redirection_logs $getData)
    {
        // TODO: Implement createLog_REDIRECTION() method.
    }

    public function getLogs_REDIRECTION(redirection_logs $getData)
    {
        // TODO: Implement getLogs_REDIRECTION() method.
    }

    public function readLog_REDIRECTION($id)
    {
        // TODO: Implement readLog_REDIRECTION() method.
    }

    public function createLog_DSF(dsf_logs $getData)
    {
        // TODO: Implement createLog_DSF() method.
    }

    public function getLogs_DSF(dsf_logs $getData)
    {
        // TODO: Implement getLogs_DSF() method.
    }

    public function readLog_DSF($id)
    {
        // TODO: Implement readLog_DSF() method.
    }

    public function createLog_FIRWALL(dsf_logs $getData)
    {
        // TODO: Implement createLog_FIRWALL() method.
    }

    public function getLogs_FIRWALL(dsf_logs $getData)
    {
        // TODO: Implement getLogs_FIRWALL() method.
    }

    public function readLog_FIRWALL($id)
    {
        // TODO: Implement readLog_FIRWALL() method.
    }

}



