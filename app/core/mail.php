<?php	
	class Mail {
		 private $type = "text/html";
		 private $encoding;
		 private $newhead;

		  /* Смена кодировки */
		  private function setEncoding($encoding) {
			$this->encoding = $encoding;
		  }

		 //Отправка письма
			 public function sendMail($mail){
					list($head, $body) = preg_split("/\r?\n\r?\n/s", $mail, 2);
					$to ='';
					if(preg_match('/^To:\s*([^\r\n]*)[\r\n]*/m', $head, $p)){
						$to = @$p[1];
						$head = str_replace($p[0], "", $head);
					}
					$subject = '';
					if(preg_match('/^Subject:\s*([^\r\n]*)[\r\n]*/m', $head, $p)){
						$subject = @$p[1];
						$head = str_replace($p[0], "", $head);
					}
					if(mail($to, $subject, $body, trim($head)))
						return true;
			}
			
		//Кодирование заголовков
			 public function mail_encoding($mail){
					list($head, $body) = preg_split("/\r?\n\r?\n/s", $mail, 2);
					$encoding ='';
					$regular ='/^Content-type:\s*\S+\s;\s*charset\s*=\s*(\S+)/mi';
					if(preg_match($regular, $head, $p)) $this->setEncoding($p[1]);
					foreach((preg_split('/\r?\n/s',$head))as $line){
						$line = $this->lineEncode($line);
						$this->newhead .= "$line\r\n";
						$this->newhead .= "\r\n$body";
					}
					return $this->newhead;
			}
			
		//Кодирование cтроки
			 private function lineEncode($line){
				 if(!$this->encoding) return $line;
				 return preg_replace_callback(
					'/([\x7F-xFF] [^<>\r\n]*)/s',
					'callback_encode',
					$line );	 
			 }
			
		//Кодирование
			private function callback_encode ($p){
				preg_match('/^(.*?)(\s*)$/s', $p[1],$sp);
				return "=?$this->encoding?B?".base64_encode($sp[1])."?=".$sp[2];
			}

}

?>