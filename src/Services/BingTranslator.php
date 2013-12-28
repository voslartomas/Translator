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
	
	const API_AUTH_URL = 'https://datamarket.accesscontrol.windows.net/v2/OAuth2-13';
	
	const METHOD_GET_LANGUAGES_NAME = 3;
	
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
		
		$getLangNameMethod = new \Webcook\Translator\Method('GetLanguageNames', self::METHOD_GET_LANGUAGES_NAME, array(
			new \Webcook\Translator\MethodParameter('locale', true),
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
		array_push($this->methods, $getLangNameMethod);
	}
	
	/**
	 * Get all possible languages.
	 * @return Array<LanguageResult>
	 */
	public function getLanguages() {
		$url = self::API_URL . $this->getMethodName(self::METHOD_GET_LANGUAGES);
		
		$header = $this->getHeader();
		
		$response = $this->doRequest($url, null, $header);
		
		$xmlObj = simplexml_load_string($response);
		
		$languageCodes = array();
		foreach($xmlObj->string as $code){
		    $languageCodes[] = (string) $code;
		}
		
		$url = self::API_URL . $this->getMethodName(self::METHOD_GET_LANGUAGES_NAME);
		
		$requestXml = '<ArrayOfstring xmlns="http://schemas.microsoft.com/2003/10/Serialization/Arrays" xmlns:i="http://www.w3.org/2001/XMLSchema-instance">';
		if(sizeof($languageCodes) > 0){
		    foreach($languageCodes as $codes)
		    $requestXml .= "<string>$codes</string>";
		} else {
		    throw new Exception('$languageCodes array is empty.');
		}
		$requestXml .= '</ArrayOfstring>';
		
		$response = $this->doRequest($url . '?locale=en', $requestXml, $header, true);
		
		$xmlObj = simplexml_load_string($response);
		
		$languages = array();
		$i = 0;
		foreach($xmlObj->string as $language){
		    $languages[] = new \Webcook\Translator\Results\LanguageResult($languageCodes[$i], (string) $language);
		    $i++;
		}
		
		return $languages;
	}

	/**
	 * Translate text.
	 * @return TranslateResult
	 */
	public function translate($text, $languageFrom, $languageTo) {
		$url = self::API_URL . $this->getMethodName(self::METHOD_TRANSLATE);
		
		$response = $this->doRequest($url, array(
                        'appId' => '',
                        'text' => $text,
			'from' => $languageFrom,
                        'to' => $languageTo,
                        'contentType' => 'text/html'
		), $this->getHeader());
		
		$response = simplexml_load_string($response);
		
		return new \Webcook\Translator\Results\TranslateResult((string) $response);
	}	
	
        private function getHeader(){
            
           $response = json_decode($this->doRequest(self::API_AUTH_URL, http_build_query(array(
                        'client_id' => $this->clientId,
                        'client_secret' => $this->clientSecret,
                        'scope' => 'http://api.microsofttranslator.com',
                        'grant_type' => 'client_credentials'
            )), null, true, false));
	   
	   return array("Authorization: Bearer ". $response->access_token, "Content-Type: text/xml");
        }
}
