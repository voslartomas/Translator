<?php

namespace Webcook\Translator;

/**
 * Class Translator.
 * @author Tomáš Voslař <tomas.voslar at webcook.cz>
 */
abstract class Translator {
	
	/* @var int Constant for get languages method. */
	const METHOD_GET_LANGUAGES = 1;
	
	/* @var int Constant for translate method. */
	const METHOD_TRANSLATE = 2;
	
	/* @var Array<Method> list of possible methods. */
	protected $methods = array();
	
	/**
	 * Make API request and returns response.
	 * @param String $url url of request
	 * @param Array $params parameters of request
	 * @return String $response
	 */
	protected function doRequest($url, $params = null, $header = null, $post = false, $ssl = false){
		
		if($params != null && is_array($params) && !$post){
			$url .= '?' . http_build_query($params);
		}
                
		try {
			$ch = curl_init($url);
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                        curl_setopt($ch, CURLOPT_POST, $post);
                        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, $ssl);
                        
                        if($post){
                            curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
                        }
                        
                        if($header != null){
                            curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
                        }
                        
			return curl_exec($ch);
		} catch (Exception $exc) {
			throw new \ErrorException('Bad API call.');
		}
	}
	
	/**
	 * Returns all methods.
	 * @return Array<Method>
	 */
	public function getMethods() {
		return $this->methods;
	}
	
	/**
	 * Returns one method by key.
	 * @param String $key
	 * @return Method
	 */
	protected function getMethod($key){
		$methods = $this->getMethods();
		
		foreach($methods as $method){
			if($method->getType() === $key){
				return $method;
			}
		}
		
		throw new Exception("Method `$key` does not exists.");
	}
	
	/**
	 * Returns method name by key.
	 * @param String $key
	 * @return String $name name of the method
	 */
	protected function getMethodName($key){
		$method = $this->getMethod($key);
		
		return $method->getName();
	}
}
