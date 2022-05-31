<?php
	//include_once("connect.php"); 

    include_once 'dbClass.php';
			
	$ExCldb = new mysql(); 


	
	class export
	{
			
			////////////////////////////////////////////////////////////////////////
			////////////////////////////////////////////////////////////////////////
			////////////////////////////////////////////////////////////////////////
		
			
			
			////////////////////////////////////////////////////////////////////////
			////////////////////////////////////////////////////////////////////////
			////////////////////////////////////////////////////////////////////////

			
	
	function downloadXL($sql, $filename){
        global $ExCldb;
        $export = $ExCldb->query2($sql);
        $fields = $export['fieldCount'];
       
        for ($i = 0; $i < $fields; $i++) {
                $header .= $export['fieldNames'][$i] . "\t";
        }
       
        //while($row = $ExCldb->fetchRow($export)) {
        foreach ($export['data'] AS $row) {
                $line = '';
                foreach($row as $value) {                                             
                        if ((!isset($value)) OR ($value == "")) {
                                $value = "\t";
                        } else {
                                $value = str_replace('"', '""', $value);
                                $value = '"' . $value . '"' . "\t";
                        }
                       
                        $value = stripslashes($value);
                       
                        $line .= $value;
                }
                $data .= trim($line)."\n";
        }
        $data = str_replace("\r","",$data);
       
        if ($data == "") {
                $data = "\n(0) Records Found!\n";                         
        }
       
        header("Content-type: application/x-msdownload");
        header("Content-Disposition: attachment; filename=$filename.xls");
        header("Pragma: no-cache");
        header("Expires: 0");
        print "$header\n$data";
}
			////////////////////////////////////////////////////////////////////////
			////////////////////////////////////////////////////////////////////////
			////////////////////////////////////////////////////////////////////////
					
	


function downloadEXL($sql, $filename){
        global $ExCldb;
        $export = $ExCldb->query2($sql);
        $fields = $export['fieldCount'];
       
        for ($i = 0; $i < $fields; $i++) {
            //    $header .= $ExCldb->fieldName($export, $i) . ",";
        }
       
        
        foreach ($export['data'] AS $row) {
                $line = '';
                foreach($row as $value) {                                             
                        if ((!isset($value)) OR ($value == "")) {
                                $value = ",";
                        } else {
                                $value = str_replace('"', '""', $value);
                                $value = $value. ",";
                        }
                       
                        $value = stripslashes($value);
                       
                        $line .= $value;
                        
                }
                $line = substr($line, 0, -1); 
                $data .= trim($line)."\r\n";
        }
        //$data = str_replace("\n","",$data);
       
        if ($data == "") {
                $data = "\r\n(0) Records Found!\r\n";                         
        }
       
        header('Content-Type: application/vnd.ms-excel');
                header("Content-Disposition: attachment; filename=$filename.xls");
        header("Pragma: no-cache");
        header("Expires: 0");
        print "$header\n$data";
}		









////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////

			function downloadCSVFormats($sql, $filename){
               global $ExCldb;
               $export = $ExCldb->query($sql);
           
     
        
        foreach ($export['data'] AS $row) {
                $line = '';
                foreach($row as $value) {                                             
                        if ((!isset($value)) OR ($value == "")) {
                                $value = ",";
                        } else {
                                $value = str_replace('"', '""', $value);
                                $value = $value. ",";
                        }
                       
                        $value = stripslashes($value);
                       
                        $line .= $value;
                        
                }
                $line = substr($line, 0, -1); 
                $data .= trim($line)."\r\n";
        }

       
        header("Content-type: application/csv");
        header("Content-Disposition: attachment; filename=$filename.csv");
        header("Pragma: no-cache");
        header("Expires: 0");
        print "$data";
}
			
		
			
			/////////////////////////////////////////////////////////////////////////////////////////
           ///////////////////////////////////////////////////////////////////////////////////////////


           function downloadCSV($sql, $filename){
                global $ExCldb;
                $export = $ExCldb->query2($sql);
                $fields = $export['fieldCount'];
               
                for ($i = 0; $i < $fields; $i++) {
                        $header .= $export['fieldNames'][$i] . ",";
                }
               
                
                foreach ($export['data'] AS $row) {
                        $line = '';
                        foreach($row as $value) {                                             
                                if ((!isset($value)) OR ($value == "")) {
                                        $value = ",";
                                } else {

                                        $value = str_replace('"', '""', $value);
                                        //$value = str_replace(',', ' ', $value);
                                        //$value = "\"" . eregi_replace("\"", "\"\"", $value) . "\"";
                                        $value = "\"" . preg_replace("/\"/i", "\"\"", $value) . "\"";

                                        $value = $value. ",";
                                }
                               
                                
                               $value = stripslashes($value);
                                $line .= $value;
                                
                        }
                        $line = substr($line, 0, -1); 
                        $data .= trim($line)."\r\n";
                }
                //$data = str_replace("\n","",$data);
               
                if ($data == "") {
                        $data = "\r\n(0) Records Found!\r\n";                         
                }
               
                header("Content-type: application/csv");
                header("Content-Disposition: attachment; filename=$filename.csv");
                header("Pragma: no-cache");
                header("Expires: 0");
                print "$header\n$data";
        }



           function downloadCSVwithJson($json, $filename,$headers=null){
               $header='';
                $export = json_decode($json,true);
                //$fields = count($export[0]);

                if ($headers!=1) {
                    foreach ($export[0] as $key=>$value) {
                        $header .= $key . ",";
                }
                }
                

                foreach($export as $row) {
                        $line = '';
                        foreach($row as $value) {
                                if ((!isset($value)) OR ($value == "")) {
                                        $value = ",";
                                } else {

                                        $value = str_replace('"', '""', $value);
                                        //$value = str_replace(',', ' ', $value);
                                        //$value = "\"" . eregi_replace("\"", "\"\"", $value) . "\"";
                                        $value = "\"" . preg_replace("/\"/i", "\"\"", $value) . "\"";

                                        $value = $value. ",";
                                }


                               $value = stripslashes($value);
                                $line .= $value;

                        }
                        $line = substr($line, 0, -1);
                        $data .= trim($line)."\r\n";
                }
                //$data = str_replace("\n","",$data);

                if ($data == "") {
                        $data = "\r\n(0) Records Found!\r\n";
                }

                header("Content-type: application/csv");
                header("Content-Disposition: attachment; filename=$filename.csv");
                header("Pragma: no-cache");
                header("Expires: 0");
                print "$header\n$data";
        }





function downloadCSV_query($sql, $filename, $uni_id_name, $oth_name){
        global $ExCldb;
        $export = $ExCldb->query2($sql);
        $fields = $export['fieldCount'];
       
        for ($i = 0; $i < $fields; $i++) {
                $header .= $export['fieldNames'][$i] . ",";
        }

        if($export['rowCount'] > 0){
        
        
        foreach ($export['data'] AS $row) {
                $line = '';
                $advance_f_val ='';
                /* foreach($row as $value) {                                             
                        if ((!isset($value)) OR ($value == "")) {
                                $value = ",";
                        } else {
                                $value = str_replace('"', '""', $value);
                                $value = $value. ",";
                        }
                       
                        $value = stripslashes($value);
                       
                        $line .= $value;
                        
                } */
              $advance_f =  $row['Advanced Features'];
              $advance_f_array = json_decode($advance_f, true);

              if($advance_f_array['network_at_a_glance']=='1'){
                $advance_f_val='Network-at-a-Glance';
              }
              if($advance_f_array['top_applications']=='1'){
                      if($advance_f_val == ''){
                $advance_f_val='Top Applications';
                      }else{
                        $advance_f_val .='/'.'Top Applications';
                      }
              }
              if($advance_f_array['802.2x_authentication']=='1'){
                
                if($advance_f_val == ''){
                        $advance_f_val='802.1X Authentication';
                              }else{
                                $advance_f_val .='/'.'802.1X Authentication';
                              }
              }

             
              $property_name=$row['Property Name'];
              $property_name = str_replace('"', '""', $property_name);
              //$property_name = "\"" . eregi_replace("\"", "\"\"", $property_name) . "\"";
              $property_name = "\"" . preg_replace("/\"/i", "\"\"", $property_name) . "\"";
              $property_name = stripslashes($property_name);

              $Business_address=$row['Business Address'];
              $Business_address = str_replace('"', '""', $Business_address);
              //$Business_address = "\"" . eregi_replace("\"", "\"\"", $Business_address) . "\"";
              $Business_address = "\"" . preg_replace("/\"/i", "\"\"", $Business_address) . "\"";
              $Business_address = stripslashes($Business_address);

              $Business_account_name=$row['Business Account Name'];
              $Business_account_name = str_replace('"', '""', $Business_account_name);
              //$Business_account_name = "\"" . eregi_replace("\"", "\"\"", $Business_account_name) . "\"";
              $Business_account_name = "\"" . preg_replace("/\"/i", "\"\"", $Business_account_name) . "\"";
              $Business_account_name = stripslashes($Business_account_name);
                
                $line .= $row['Business ID']. ",";
                $line .= $row[$uni_id_name]. ",";
                $line .= $row[$oth_name]. ",";
                $line .= $row['Account Type']. ",";
                $line .= $Business_account_name. ",";
                $line .= $row['Business Account Email']. ",";
                $line .= $advance_f_val. ",";
                $line .= $row['ICOMS VALUES']. ",";
                $line .= $row['Package Type']. ",";
                $line .= $row['Private Gateway Type']. ",";
                $line .= $row['WAG info']. ",";
                $line .= $row['Description']. ",";
                $line .= $row['Guest QoS Profile']. ",";
                $line .= $row['Duration Profile']. ",";
                $line .= $row['Zone ID']. ",";
                $line .= $row['Zone Name']. ",";
                $line .= $row['Guest Gateway Type']. ",";
                $line .= $row['AP Controller']. ",";
                $line .= $row['SW Controller']. ",";
                $line .= $row['Group ID']. ",";
                $line .= $property_name. ",";
                $line .= $row['Business Vertical']. ",";
                $line .= $row['City']. ",";
                $line .= $Business_address. ",";
                $line .= $row['Country']. ",";
                $line .= $row['State/Region']. ",";
                $line .= $row['Zip Code']. ",";
                $line .= $row['Phone 1']. ",";
                $line .= $row['Phone 2']. ",";
                $line .= $row['Phone 3']. ",";
                $line .= $row['Time Zone']. ",";
                $line .= $row['Create Date']. ",";
                $line .= $row['Activation Date']. ",";



                $line = substr($line, 0, -1);
                $data .= trim($line)."\r\n";
        }
        
        //$data = str_replace("\n","",$data);
}
        if ($data == "") {
                $data = "\r\n(0) Records Found!\r\n";                         
        }
       
        header("Content-type: application/csv");
        header("Content-Disposition: attachment; filename=$filename.csv");
        header("Pragma: no-cache");
        header("Expires: 0");
        print "$header\n$data";
}
			////////////////////////////////////////////////////////////////////////
			////////////////////////////////////////////////////////////////////////
			////////////////////////////////////////////////////////////////////////
					

	function downloadTXT($sql, $filename){
        global $ExCldb;
        $export = $ExCldb->query2($sql);
        $fields = $export['fieldCount'];
       
        for ($i = 0; $i < $fields; $i++) {
            //    $header .= $ExCldb->fieldName($export, $i) . ",";
        }
       
        
        foreach ($export['data'] AS $row) {
                $line = '';
                foreach($row as $value) {                                             
                        if ((!isset($value)) OR ($value == "")) {
                                $value = ",";
                        } else {
                                $value = str_replace('"', '""', $value);
                                $value = $value. ",";
                        }
                       
                        $value = stripslashes($value);
                       
                        $line .= $value;
                        
                }
                $line = substr($line, 0, -1); 
                $data .= trim($line)."\r\n";
        }
        //$data = str_replace("\n","",$data);
       
        if ($data == "") {
                $data = "\r\n(0) Records Found!\r\n";                         
        }
       
        header("Content-type: application/x-msdownload");
        header("Content-Disposition: attachment; filename=$filename.txt");
        header("Pragma: no-cache");
        header("Expires: 0");
        print "$header\n$data";
}
			////////////////////////////////////////////////////////////////////////
			////////////////////////////////////////////////////////////////////////
			////////////////////////////////////////////////////////////////////////
					
		function downloadXLB($sql, $filename){
        global $ExCldb;
        $export = $ExCldb->query2($sql);
        $fields = $export['fieldCount'];
       
        for ($i = 0; $i < $fields; $i++) {
            //    $header .= $ExCldb->fieldName($export, $i) . ",";
        }
       
       
        foreach ($export['data'] AS $row) {
                $line = '';
                foreach($row as $value) {                                             
                        if ((!isset($value)) OR ($value == "")) {
                                $value = ",";
                        } else {
                                $value = str_replace('"', '""', $value);
                                $value = $value. ",";
                        }
                       
                        $value = stripslashes($value);
                       
                        $line .= $value;
                        
                }
                $line = substr($line, 0, -1); 
                $data .= trim($line)."\r\n";
        }
        //$data = str_replace("\n","",$data);
       
        if ($data == "") {
                $data = "\r\n(0) Records Found!\r\n";                         
        }
       
        header('Content-type: application/octet-stream');
        header("Content-Disposition: attachment; filename=$filename.xlsb");
        header("Pragma: no-cache");
        header("Expires: 0");
        print "$header\n$data";
}	



}















class mysql{
       
        var $queryCounter       = 0;
        var $totalTime   = 0;
        
        
       public function __construct()
			{
				//Connect::getConnect();
                $this->db = new db_functions();
				
			}
			
			
			
			
        function mysql(){
               
        $this->totalTime += $this->getMicroTime() - $startTime;
        }
       
        //Executes and returns a query
        function query($sql) {
                $startTime = $this->getMicroTime();

                ++$this->queryCounter;
               
                $result = $this->db->selectDB($sql);

                if ($result['rowCount'] == 0) {
                                $this->mailError($sql, $result);
                                //return $this->error("<br />There was a SQL error and it has been reported. Sorry for the inconvience.<br />");
                }
               
                $this->totalTime += $this->getMicroTime() - $startTime;
               
            return $result;
        } 

        function query2($sql) {
                $startTime = $this->getMicroTime();

                ++$this->queryCounter;
               
                $result = $this->db->selectDBwithFields($sql);

                if ($result['rowCount'] == 0) {
                                $this->mailError($sql, $result);
                                //return $this->error("<br />There was a SQL error and it has been reported. Sorry for the inconvience.<br />");
                }
               
                $this->totalTime += $this->getMicroTime() - $startTime;
               
            return $result;
        }      

        //Fetch array Query MySQL Database
        function fetch($result) {
                $rows = mysql_fetch_array($result);
                return $rows;
        }
       
        //Fetch array Query MySQL Database
        function fetch2($result) {
                $rows = mysql_fetch_array($result, MYSQL_ASSOC);
                return $rows;
        }
       
        function fetchO($result) {
                $row = mysql_fetch_object($result);
                return $row;
        }
       
        function fetchRow($result) {
                $rows = mysql_fetch_row($result);
                return $rows;
        }

        //Count the number of rows in query
        function numRows($result) {
                $count = mysql_num_rows($result);
                return $count;
        }
       
        //Run query and count the number of rows in query
        function numRowsQ($sql) {
                $result = $this->query($sql);
                $count = mysql_num_rows($result);
                return $count;
        }
       
        // Returns only one column
        function fetchOneCol($sql, $arr=0) {
                $result = $this->query($sql);
                $return = $this->fetch($result);
                $return = $return[$arr];
                return $return;
        }
       
        // Find number of fields names in a query
        function numFields($result) {
                $fields = mysql_num_fields($result);
                return $fields;
        }
       
        // find single field name
        function fieldName($result, $fNum) {
                $name = mysql_field_name($result, $fNum);
                return $name;
        }
       
        //Get affected rows
        function getAffectedRows()
        {
                return mysql_affected_rows();
        }       
       
        //Get last insert id
        function getInsertId(){
                return mysql_insert_id();
        }
       
####################################################
#              Time/Count Functions
####################################################
       
        function getDBTime($dec=6){
                $time = number_format(round($this->totalTime, $dec), $dec);
                return $time;
        }
       
        function getSqlCount(){
                return $this->queryCounter;
        }
       
        function getMicroTime() {
        list($usec, $sec) = explode(" ",microtime());
        return ((float)$usec + (float)$sec);
    }
       
        function showSQLStats($dec=6){
                $stats = $this->getSqlCount();
                $stats != 1 ? $stats .= " queries took " : $stats .= " query took ";
                $stats .= $this->getDBTime($dec) . " seconds to execute";
                return $stats;
        }
       
####################################################
#              Error Handling
####################################################
        // Sends an email to the admin on an error
        function mailError($sql, $error) {
                global $config;
                if ($config['dev']){
                        print $sql . "<br /><br />" . $error . "<br /><br />";
                }else {
                        mail($config['admin_email'], "SQL Error on ".$config['site_name'], $sql . "\n\n Error Msg: " . $error . "\n\n Error Number: " . $errorNo . "\n\n Page: " . $_SERVER['REQUEST_URI'], "From: " . $config['admin_email']);
                }
        }
       
        // error function
        function error($msg) {
                print $msg;
                die();
        }


}


?>
