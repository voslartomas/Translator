<?php

namespace Webcook\Translator\Services;

/**
 * TODO implement authorization token
 * Bing implementation of translator.
 * @author Tomáš Voslař <tomas.voslar at webcook.cz>
 */
class BingTranslator extends \Webcook\Translator\Translator implements \Webcook\Translator\ITranslator {
	
	/* basic URL address of Yandex API */
	const API_URL = 'http://api.microsofttranslator.com/v2/Http.svc/';
	
	/* API key for Yandex service */
	private $apiKey = null;
	
	/**
	 * @param String $key API key for Yandex service.
	 * @throws \BadMethodCallException
	 */
	public function __construct($key){

		// checks parameters
		if(empty($key)){
			throw new \BadMethodCallException('Bad parameters given.');
		}
		
		$this->apiKey = $key;
		
		// add methods
		$getLangMethod = new \Webcook\Translator\Method('GetLanguagesForTranslate', self::METHOD_GET_LANGUAGES, array(
			new \Webcook\Translator\MethodParameter('appId', false),
		));
		
		$translateMethod = new \Webcook\Translator\Method('Translate', self::METHOD_TRANSLATE, array(
			new \Webcook\Translator\MethodParameter('appId', false),
                        new \Webcook\Translator\MethodParameter('from', false),
                        new \Webcook\Translator\MethodParameter('to', true),
                        new \Webcook\Translator\MethodParameter('contentType', true),
			new \Webcook\Translator\MethodParameter('text', true, 'text'),
                        new \Webcook\Translator\MethodParameter('category', false),
		));
		
		array_push($this->methods, $getLangMethod);
		array_push($this->methods, $translateMethod);
	}
	
	/**
	 * Get all possible languages.
	 * @return Array<LanguageResult>
	 */
	public function getLanguages() {
		$url = self::API_URL . $this->getMethodName(self::METHOD_GET_LANGUAGES);
		
		$response = json_decode($this->doRequest($url, array(
                        'format' => 'json'
		), $this->getHeader()));
		
		// TODO implement response
		
		return $languages;
	}

	/**
	 * Translate text.
	 * @return TranslateResult
	 */
	public function translate($text, $languageFrom, $languageTo) {
		$url = self::API_URL . $this->getMethodName(self::METHOD_TRANSLATE);
		
		$response = json_decode($this->doRequest($url, array(
			'text' => $text,
			'from' => $languageFrom,
                        'to' => $languageTo,
                        'format' => 'text/html'
		), $this->getHeader()));
		
                // TODO implement response
                
		return new \Webcook\Translator\Results\TranslateResult($response->text[0]);
	}	
	
        private function getHeader(){
            // TODO implement authorization token request
            
            $header = array();
            $header[] = 'Authorization: Basic ' . base64_encode($this->key . ":" . $this->key);
            
            return $header;
        }
        
	/* Getter for api key. */
	public function getApiKey() {
		return $this->apiKey;
	}

	/* Setter for api key. */
	public function setApiKey($apiKey) {
		$this->apiKey = $apiKey;
	}
}
