<?php
class Translator {

    private $language   = 'en';
	private $lang 		= array();
    private $path;
	
	public function __construct($language, $path = 'lang/'){
        $this->language = $language;
		$this->path = $path;
	}
	
    private function findString($str) {
        if (array_key_exists($str, $this->lang[$this->language])) {
			echo $this->lang[$this->language][$str];
			return;
        }
        echo $str;
    }
    
	private function splitStrings($str) {
        return explode('=',trim($str));
    }
	
	public function __($str) {	
        if (!array_key_exists($this->language, $this->lang)) {
            if (file_exists($this->path.$this->language.'.txt')) {
                $strings = array_map(array($this,'splitStrings'),file($this->path.$this->language.'.txt')); 
                foreach ($strings as $k => $v) {
					 $this->lang[$this->language][$v[0]] = $v[1];
                }
                return $this->findString($str);
            }
            else {
                echo $str;
            }
        }
        else {
            return $this->findString($str);
        }
    }

        private function findResult($str, $tag) {
        if (array_key_exists($str, $this->lang[$this->language])) {
            echo "<$tag>".$this->lang[$this->language][$str]."</$tag>";
            return;
        }
        echo "<$tag>$str</$tag>";
    }

    public function TransForScript($str, $tag = 'result') {  
        if (!array_key_exists($this->language, $this->lang)) {
            if (file_exists($this->path.$this->language.'.txt')) {
                $strings = array_map(array($this,'splitStrings'),file($this->path.$this->language.'.txt')); 
                foreach ($strings as $k => $v) {
                     $this->lang[$this->language][$v[0]] = $v[1];
                }
                return $this->findResult($str, $tag);
            }
            else {
                echo "<$tag>$str</$tag>";
            }
        }
        else {
            return $this->findResult($str, $tag);
        }
    }
}
?>