<?php

namespace Webcook\Translator\Services;

/**
 * TODO implement authorization token
 * Bing implementation of translator.
 * @author Tomáš Voslař <tomas.voslar at webcook.cz>
 */
class BingTranslator extends \Webcook\Translator\Translator implements \Webcook\Translator\ITranslator {
	
	/* basic URL address of Bing API */
	const API_URL = 'http://api.microsofttranslator.com/v2/Http.svc/';
	
	/* Client id. */
	private $clientId = null;
        
        /* Client secret. */
        private $clientSecret = null;
	
	/**
	 * @param String $clientId
         * @param String $clientSecret
	 * @throws \BadMethodCallException
	 */
	public function __construct($clientId, $clientSecret){

		// checks parameters
		if(empty($clientId) || empty($clientSecret)){
			throw new \BadMethodCallException('Bad parameters given.');
		}
		
		$this->clientId = $clientId;
                $this->clientSecret = $clientSecret;
		
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
                        'appId' => ''
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
                        'appId' => '',
                        'text' => $text,
			'from' => $languageFrom,
                        'to' => $languageTo,
                        'contentTYpe' => 'text/html'
		), $this->getHeader()));
		
                // TODO implement response
                
		
		return new \Webcook\Translator\Results\TranslateResult($response->text[0]);
	}	
	
        private function getHeader(){
            
           $response = json_decode($this->doRequest($url, array(
                        'client_id' => $this->clientId,
                        'client_secret' => $this->clientSecret,
                        'scope' => 'http://api.microsofttranslator.com',
                        'grant_type' => 'client_credentials'
            ), null, true, false));
	   
	    return array('Bearer ' . $response->access_token, "Content-Type: text/xml");
        }
}
