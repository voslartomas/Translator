<?php

namespace Webcook\Translator\Services;

/**
 * Google Translator implementation.
 * @author Tomáš Voslař <tomas.voslar at webcook.cz>
 */
class GoogleTranslator extends \Webcook\Translator\Translator implements \Webcook\Translator\ITranslator {
	
	/* basic URL address of Yandex API */
	const API_URL = 'https://www.googleapis.com/language/translate/v2/';
	
	/* API key for Google Translate */
	private $apiKey = null;
	
	/**
	 * @param String $key API key for Google Translate service.
	 * @throws \BadMethodCallException
	 */
	public function __construct($key){

		// checks parameters
		if(empty($key)){
			throw new \BadMethodCallException('Bad parameters given.');
		}
		
		$this->apiKey = $key;
		
		// add methods
		$getLangMethod = new \Webcook\Translator\Method('languages', self::METHOD_GET_LANGUAGES, array(
			new \Webcook\Translator\MethodParameter('key', true),
			new \Webcook\Translator\MethodParameter('target', false)
		));
		
		$translateMethod = new \Webcook\Translator\Method('translate', self::METHOD_TRANSLATE, array(
			new \Webcook\Translator\MethodParameter('key', true),
			new \Webcook\Translator\MethodParameter('source', true),
                        new \Webcook\Translator\MethodParameter('target', true),
			new \Webcook\Translator\MethodParameter('q', true, 'text[]')
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
			'key' => $this->apiKey,
                        'target' => 'en'
		)));
		
		$languages = array();
		foreach($response->data->languages as $language){
			array_push($languages, new \Webcook\Translator\Results\LanguageResult($language->language, $language->name));
		}
		
		return $languages;
	}

	/**
	 * Translate text.
	 * @return TranslateResult
	 */
	public function translate($text, $languageFrom, $languageTo) {
		$url = self::API_URL . $this->getMethodName(self::METHOD_TRANSLATE);
		
		$response = json_decode($this->doRequest($url, array(
			'key' => $this->apiKey,
			'q' => $text,
			'source' => $languageFrom,
                        'target' => $languageTo
		)));
		
                $translation = $response->data->translations[0];
                
		return new \Webcook\Translator\Results\TranslateResult($translation->translatedText);
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
