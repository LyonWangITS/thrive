<?php
	
	include_once( 'phpmailer/class.phpmailer.php' );
	
	class HumaanBasicFormHandler {
		
		/*
			List fields & their Known rules: notempty, email, null
			
			ie. $fields = array(
				'contactName' => array(
					'rule' => 'notempty',
					'message' => 'Name is required'
				),
				'contactEmail' => 'email',
				'contactUrl' => null,
				'contactFile' => array(
					'rule' => 'attachment',
					'message' => 'Invalid attachment',
					'types' => array(
						'application/pdf',
						'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
						'application/msword'
					),
					'max_size' => 1000000
					'required' => true
				)
			)
		*/
		//Form properties
		public $fields = array();
		public $post_data = array();
		public $timezone = '+0000';
		public $timestamp_format = 'l F j, Y g:i a';
		
		//Message properties
		public $send_as_html = false;
		public $message = null;
		
		//Path within email-templates directory
		public $template_path = '';
		
		private $_data = array();
		private $_attachments = array();
		public $send_attachments = true;
		
		
		public function __construct(array $a = array())
		{
			foreach ($a as $key => $value)
			{
				$this->$key = $value;
			}
		}
		
		
		//Do everything
		public function sendIfValidates($from_name, $from_address, $to_address, $subject) {
			
			$flow_error = '';
			
			$field_errors = $this->validate();
			
			if ( empty($field_errors) ) {
				
				$message = $this->buildMessage();
				
				if ($message != '') {
					
					$flow_error = $this->send($from_name, $from_address, $to_address, $subject);
					
				} else {
					
					$flow_error = 'Message is empty';
					
				}
				
			} else {
				
				$flow_error = 'Validation errors encountered';
				
			}
			
			return $flow_error;
		}
		
		
		// After validate is run once, this->_data will be filled with 'sanitized' data from post_data
		public function validate(){
			
			$errors = array();
			
			if ( ( count($this->fields) > 0 ) && ( count($this->post_data) > 0 ) ) {
				
				//Attachment fields won't be copied across, they are designated to the _attachments property
				$this->_data = $this->_copyArrayAtKeys( $this->post_data, array_keys($this->fields) );
				
				foreach( $this->fields as $field_name => $rule ){
					
					$error_message = $this->_validateField( $rule, $this->ifne( $this->_data,  $field_name, ''), $field_name );
					
					if ($error_message != '') {
						
						$errors[$field_name] = $error_message;
						
					}
					
				}
				
			}
			
			return $errors;
		}
		
		
		function _getGMT()
		{
			// Get timestamp in server timezone
			$server_time = time();

			// Get GMT timestamp
			$gm_time = $server_time - date('Z', $server_time);

			return $gm_time;
		}
		
		
		function _formatTimestamp( $gmt_timestamp, $offset = '+0000' ) {
			
			$hours_difference = substr($offset,1,2);
			$minutes_difference = substr($offset,3,2);
			
			//Hours
			$seconds_offset = 60 * 60 * $hours_difference;
			
			//Minutes
			$seconds_offset += 60 * $minutes_difference;
			
			if (substr($offset,0,1) == '-') 
			{
				$seconds_offset = (-1 * $seconds_offset);
			}
			
			return date( $this->timestamp_format, $gmt_timestamp + $seconds_offset );
		}
		
		
		
		function _prefillKnownConstants( $message ){
			
			//IP Address
			$remote_ip = $_SERVER['REMOTE_ADDR'];
			$multiple_ips = explode(',', $remote_ip );
			
			if ( count($multiple_ips) > 1 ) {
				$ip_address = trim( $multiple_ips[0] );
			} else {
				$ip_address = $remote_ip;
			}
			
			$message = str_replace('<!-- wp:ip-address -->', $ip_address, $message );
			
			//Hostname
			$hostname = gethostbyaddr( $ip_address );
			if ( $hostname === false ) {
				$hostname = '';
			}
			$message = str_replace('<!-- wp:hostname -->', $hostname, $message );
			
			//Timestamp
			$timestamp = $this->_formatTimestamp( $this->_getGMT(), $this->timezone );
			
			$message = str_replace('<!-- wp:timestamp -->', $timestamp, $message);
			
			return $message;
		}
		
		
		public function buildMessage( $template = null ){
			
			$template_path = ( $template ? $template : $this->template_path );
			
			$message = '';
			
			if ($template_path != '') {
				
				$full_template_path = dirname(__FILE__) . '/email-templates/' . $template_path . '.html';
				
				$message = file_get_contents( $full_template_path );
				
				if ($message) {
				
					//Prefill known constants
					$message = $this->_prefillKnownConstants( $message );
					
					foreach( $this->_data as $key => $value ){

						if (is_array($value)) {
							$value = implode(', ', $value );
						}

						$message = str_replace('<!-- ' . $key . ' -->', nl2br( $this->h( $value ) ), $message);
					}
					
				}
				
			}
			
			$this->message = $message;

			return $message;
			
		}
		
		public function send($from_name, $from_address, $to_address, $subject ) {
			
			/*
			$headers = "From: " . $from_name . " <" . $from_address . ">\r\n";

			if ($this->send_as_html) {
				$headers .= "MIME-Version: 1.0\r\n";
				$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
			}
		
			$sent = mail( $to_address, $subject, $this->message, $headers );
			
			if (!$sent) {
				
				return 'Sending failed';
				
			}*/
			
			//PHP Mailer Version
			$mail = new PHPMailer;
			
			if ( $this->send_as_html ) {
				$mail->isHTML( true );
			}
			
			$mail->From = $from_address;
			$mail->FromName = $from_name;
			$mail->AddAddress( $to_address );
			$mail->Subject = $subject;
			$mail->Body = $this->message;
			
			//Attachments?
			if ( $this->send_attachments ){ 
				
				foreach ( $this->_attachments as $attachment ){
				
					$mail->AddAttachment( $attachment[ 'path' ], $attachment[ 'name' ] );
				
				}
				
			}
			
			$sent = $mail->Send();
			
			if ( !$sent ){
				
				return 'Sending failed';
				
			}

		}
		
		
		// Privates
		
		function _copyArrayAtKeys($source, $keys) {

			$copy = array();

			if (count($keys) > 0) {

				foreach($keys as $key) {
					
					//What kind of field is it, check from rules array
					$field = $this->ifne( $this->fields, $key, null );
					
					if ( is_array( $field ) && ( $this->ifne( $field, 'rule', null ) == 'attachment' ) ) {
						
						//Attachment
						//Do nothing, validate will copy path to $_attachments array
						
					} else {
						
						$val = $this->ifne( $source, $key);

						//Stripslashes especially if WP who has its own addslasher regardless of magic_quotes setting
						$copy[$key] = $this->_stripslashes_deep( $val );
						
					}
					
				}

			}

			return $copy;

		}
		
		
		function _stripslashes_deep( $value ){
			
			$value = is_array( $value ) ? array_map( array( $this, '_stripslashes_deep' ) , $value ) : stripslashes( $value );

		    return $value;
		
		}
		
		// field_name is used in case we need to find the var somewhere else ie. $_FILES
		function _validateField($rule, $value, $field_name = null ){
			
			$error = '';
			$the_rule = $rule;
			$is_attachment = false;
			$extras = null;
			$the_message = 'invalid';
			
			if (is_array($rule)) {
				
				$the_rule = $this->ifne( $rule, 'rule', null);
				
				if ( $the_rule == 'attachment' ){
					
					//Default rule extras 1MB file
					$extras = array(
						'required' => $this->ifne( $rule, 'required', false ),
						'types' => $this->ifne( $rule, 'types', array() ),
						'max_size' => $this->ifne( $rule, 'max_size', 1000000 )
					);
					
				}
				
				$the_message = $this->ifne( $rule, 'message', 'invalid');
				
			}
			
			if ($the_rule !== null) {
				
				if ($the_rule == 'email') {
					
					if (!filter_var( $value, FILTER_VALIDATE_EMAIL )) {
						
						$error = $the_message;
						
					}
				} elseif ( $the_rule == 'notempty' ) {
					
					if ($value == '') {
						
						$error = $the_message; 
						
					}
					
				} elseif ( $the_rule == 'attachment' ){
					
					if ( !empty( $_FILES[ $field_name ] ) ){
						
						if ( $_FILES[ $field_name ]['error'] == UPLOAD_ERR_OK ){
							
							$type_accepted = true;
							
							if ( !empty( $extras[ 'types' ] ) && !in_array( $_FILES[ $field_name ]['type'], $extras[ 'types' ] ) ) {
								
								//Not acceptable type
								$type_accepted = false;
								
							}
							
							
							if ( $type_accepted ){
								
								if ( $_FILES[ $field_name ]['size'] <= $extras[ 'max_size' ] ) {
									
									$this->_attachments[] = array(
										'path' => $_FILES[ $field_name ][ 'tmp_name' ],
										'name' => $_FILES[ $field_name ][ 'name' ]
									);
									
								} else {
									
									$error = 'File is too big';
									
								}
								
							} else {
								
								$error = 'Not acceptable file type';
								
							}
							
						} else {
							
							$error = 'Error during upload';
							
						}
						
					} else {
						
						if ( $extras['required'] == true ){
							
							$error = $the_message;
							//$error = $field_name . ' : No file';
						}
						
					}
					
				}
				
			}
			
			return $error;
			
		}
		
		
		
		
		
		//Utility functions 
		
		function h($str) {
			return htmlspecialchars($str);
		}

		function ifne($var, $index, $default = '') {

			if ( is_array($var) ){

				return (!empty($var[$index]) ? $var[$index] : $default );

			} else {

				return '';

			}

		}
		
	}

?>