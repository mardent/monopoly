<?php
class Encrypt {
	const ENCRYPTION_KEY = 'B1F3C758Dde1aearf2990';
	public $getString;
	public $resString;

		//Конструктор
		public function __construct($encrypt){
			$this->getString = $encrypt;
		}
		
		// Шифрование
		private function mc_encrypt($encrypt){
			$encrypt = serialize($encrypt);
			$key = sha1(self::ENCRYPTION_KEY, true);
			$iv = mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB), MCRYPT_RAND);
			$passcrypt = mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $key , $encrypt, MCRYPT_MODE_ECB, $iv);
			$encoded = base64_encode($passcrypt);
			$encoded = self::char_replace($encoded, true);
			$this->resString = $encoded;
		}
		// Дешифрование
		private function mc_decrypt($decrypt){
			$decoded = self::char_replace($decrypt, false);
			$decoded = base64_decode($decoded);
			$iv = mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB), MCRYPT_RAND);
			$decrypted = mcrypt_decrypt(MCRYPT_RIJNDAEL_256 , sha1(self::ENCRYPTION_KEY, true), $decoded, MCRYPT_MODE_ECB, $iv);
			$decrypted = @unserialize($decrypted);
			$this->resString = $decrypted;
		}
		//Замена символов
		private function char_replace($str, $flag = true){
				if($flag){
				$res = strtr($str, array( '/'=>'_',
										  '='=>'-'
				
							));
				}else{
				$res = strtr($str, array( '_'=>'/',
										  '-'=>'='
						));
				}
				return $res;
		}
				
		//Вызов шифрования
		public function getEncrypt(){
			$this->mc_encrypt($this->getString);
			return $this->resString;
		}
		
		//Вызов дешифрования
		public function getDecrypt(){
			$this->mc_decrypt($this->getString);
			return $this->resString;
		}

} //End class Encrypt;


?>