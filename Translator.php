<?php

namespace Webcook\Translator;

/**
 * Class Translator.
 * @author Tomáš Voslař <tomas.voslar at webcook.cz>
 */
abstract class Translator {
	
	protected $methods = array();
	
	const METHOD_GET_LANGUAGES = 1;
	
	const METHOD_TRANSLATE = 2;
	
	protected function doRequest($url, $params = null){
		
		if($params != null && is_array($params)){
			$url .= '?' . http_build_query($params);
		}
		
		try {
			$ch = curl_init($url);
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			return curl_exec($ch);
		} catch (Exception $exc) {
			throw new \ErrorException('Bad API call.');
		}
	}
	
	public function getMethods() {
		return $this->methods;
	}
	
	protected function getMethod($key){
		$methods = $this->getMethods();
		
		foreach($methods as $method){
			if($method->getType() === $key){
				return $method;
			}
		}
		
		throw new Exception("Method `$key` does not exists.");
	}
	
	protected function getMethodName($key){
		$method = $this->getMethod($key);
		
		return $method->getName();
	}
}