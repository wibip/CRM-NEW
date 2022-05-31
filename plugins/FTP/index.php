<?php 
/**
 * This class does all the work related to SFTP & FTP functionalities
 */
error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING & ~E_DEPRECATED);

class File_Transfer
{

	private $_host;
	private $_port = 22;
	private $_pwd;
	private $_proxy_server_ip;
	private $_proxy_server_port;
	private $_proxyUsername;
	private $_proxyPassword;
	private $_stream;
	private $_user;
	private $_ftp_connection;
	private $_sftp_connection;
	private $_ftp_login;

	public $error;
	
	/**
	 * Initialize connection params
	*/
	public function __construct($host = null, $user = null, $password = null, $proxy_ip = null,$port = 22)
	{
		$this->_host = $host;
		$this->_user = $user;
		$this->_pwd = $password;
		$this->_port = (int)$port;
		$this->_proxy_server_ip = $proxy_ip;
	}

	/**
	 * Connect to SFTP server
	 *
	 * @return bool
	*/
	public function connect($transferring_method) {

		if(empty($transferring_method) || $transferring_method == ''){
			$this->error = "Failed to connect to {$this->_host} since the transfering method is not defined";
			return false;
		}

		switch ($transferring_method) {
			case "SFTP":
				// attempt to connect 
				if(!$this->_sftp_connection = ssh2_connect($this->_host, $this->_port)) {
				// set last error
					$this->error = "Failed to connect to {$this->_host}";
					return false;
				}

				// attempt to login
				if(ssh2_auth_password($this->_sftp_connection, $this->_user, $this->_pwd)) {
				// connection successful
					return true;
				// login failed
				} else {
					$this->error = "Failed to connect to {$this->_host} (login failed)";
					return false;
				}
			break;
			case "FTP":
			   $this->_ftp_connection = ftp_connect($this->_host);
               $this->_ftp_login = ftp_login($this->_ftp_connection, $this->_user, $this->_pwd);


				if(!$this->_ftp_connection || !$this->_ftp_login) {
				   $this->error = "FTP connection attempt failed!";
					return false;
				} else {
					return true;
				}
			break;
		}
		

	}

	/**
	 * Transfer files to SFTP server through proxy
	 *
	 * @return bool
	*/
	public function sftp_transfer_with_proxy($remote_dir,$local_file,$transferring_method){

		$url_prefix='';
		switch ($transferring_method) {
			case "SFTP":
				$url_prefix= 'sftp://';
			break;
			case "FTP":
				$url_prefix= 'ftp://';
			break;
		}

		$ch = curl_init($url_prefix . $this->_host . ':' . $this->_port . $remote_dir  . basename($local_file));

		if($this->_proxy_server_ip !=null || $this->_proxy_server_ip!=''){
			curl_setopt($ch, CURLOPT_PROXY, $this->_proxy_server_ip);
            curl_setopt($ch, CURLOPT_PROXYTYPE, 'HTTPS');
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
		}
		
 
        $fh = fopen($local_file, 'r');

        if ($fh) {

		    curl_setopt($ch, CURLOPT_USERPWD, $this->_user . ':' . $this->_pwd);
		    curl_setopt($ch, CURLOPT_UPLOAD, true);
		    curl_setopt($ch, CURLOPT_PROTOCOLS, CURLPROTO_SFTP);
		    curl_setopt($ch, CURLOPT_INFILE, $fh);
		    curl_setopt($ch, CURLOPT_INFILESIZE, filesize($local_file));
		    curl_setopt($ch, CURLOPT_VERBOSE, true);

		    $verbose = fopen('php://temp', 'w+');
    		curl_setopt($ch, CURLOPT_STDERR, $verbose);

    		$response = curl_exec($ch);
            $error = curl_error($ch);
            curl_close($ch);

            if ($response) {
		        return true;
		    } else {
		        rewind($verbose);
		        $verboseLog = stream_get_contents($verbose);
		        $this->error = "Verbose information:\n" . $verboseLog . "\n";
				return false;
		    }

        }else{
        	$this->error = $local_file." file can not open for reading.";
			return false;
        }

	} 

	/**
	 * Upload file to server
	 *
	 * @param string $local_path
	 * @param string $remote_file_path
	 * @param string $transferring_method
	 * @param int $mode
	 * @return bool
	 */
	public function put($local_file = null, $remote_file = null, $transferring_method,$mode = FTP_ASCII) {

		if(empty($transferring_method) || $transferring_method == ''){
			$this->error = "Failed to put the file since the transfering method is not defined";
			return false;
		}


		switch ($transferring_method) {
			case "SFTP":
						// attempt to upload file
				if($destFile = fopen("ssh2.sftp://".$this->_user.":".$this->_pwd."@".$this->_host."".$remote_file, 'w') ) {
					if($localFile = fopen($local_file, 'r')){

						$writtenBytes = stream_copy_to_stream($localFile, $destFile);
						fclose($destFile);
						fclose($localFile);
						// success
					    return true;
					}else{
						$this->error = "Failed to open file \"{$local_file}\"";
					    return false;
					}

				// upload failed
				} else {
					$this->error = "Failed to upload file \"{$local_file}\"";
					return false;
				}
			break;
			case "FTP":
				$upload = ftp_put($this->_ftp_connection, $remote_file, $local_file , $mode);
				if (!$upload) {
				 	$this->error = "FTP upload failed!";
					return false; 
				}else{
					return true;
				}
			break;
		}

	}






}




?>