<?php 
class Password {
	const PBKDF2_HASH_ALGORITHM = "sha256";
	const PBKDF2_HASH_BYTE_SIZE = 36;
	const HASH_SECTIONS = 3;
	const HASH_ALGORITHM_INDEX = 0;
	const HASH_ITERATION_INDEX = 1;
	const HASH_PBKDF2_INDEX = 2;
	/*-------------------------Генератор соли---------------------------------------*/
        public static function createSalt(){
        	$solt = base64_encode(mcrypt_create_iv(36, MCRYPT_DEV_URANDOM));
        	return sha1(password_hash($solt, PASSWORD_BCRYPT));	
        }
	/*-------------------------Хеширование пароля с солью---------------------------*/
        public static function create_hash($password,  $solt)
        {
			$iterations = mt_rand(800, 1100);
            return  base64_encode(self::PBKDF2_HASH_ALGORITHM.":".$iterations.":".hash_pbkdf2(
                    self::PBKDF2_HASH_ALGORITHM,
                    $password,
                    $solt,
                    $iterations,
                    self::PBKDF2_HASH_BYTE_SIZE,
                    true
                ));
        }
	/*-------------------------Валидация пароля-------------------------------------*/
        public static function validate_password($password, $correct_hash, $solt)
        {
            $params = base64_decode($correct_hash);
            $params = explode(":", $params);
            if(count($params) < self::HASH_SECTIONS)
               return false; 
            $pbkdf2 = $params[self::HASH_PBKDF2_INDEX];
            return self::slow_equals(
                $pbkdf2,hash_pbkdf2(
                    $params[self::HASH_ALGORITHM_INDEX],
                    $password,
                    $solt,
                    (int)$params[self::HASH_ITERATION_INDEX],
                    strlen($pbkdf2),
                    true
                )
            );
        }
	/*--------------------------Сравнение методом XOR-------------------------------*/
        private static function slow_equals($a, $b)
        {
            $diff = strlen($a) ^ strlen($b);
            for($i = 0; $i < strlen($a) && $i < strlen($b); $i++)
            {
                $diff |= ord($a[$i]) ^ ord($b[$i]);
            }
            return $diff === 0; 
        }
}
?>