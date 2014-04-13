<?php

	@session_start();
	
	class TinyMVC_Library_Session {
	
		/**
		 * Keep all of our data inside an Array in the SESSION array.
		 */
		private $sessionKey = 'restaurants';
		
		/**
		 * Get session variable. Magic Method.
		 */
		public function __get($key) {
			if (isset($key)) {
				if (isset($_SESSION[$this->sessionKey][$key])) {
					return $_SESSION[$this->sessionKey][$key];
				}
			}
		}
		
		/**
		 * Set session variable. Magic Method.
		 */
		public function __set($key, $val) {
			if (isset($key, $val)) {
				$_SESSION[$this->sessionKey][$key] = $val;
			}
		}
		
		/** 
		 * Unset our session data. Do NOT unset the entire session, may cause
		 * issues with other applications using the session global.
		 */
		public function destroy() {
			if (isset($_SESSION[$this->sessionKey])) {
				unset($_SESSION[$this->sessionKey]);
			}
		}
	}
	
?>
