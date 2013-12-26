<?php

namespace Webcook\Translator\Services;

/**
 * Yandex implementation of translator.
 * @author Tomáš Voslař <tomas.voslar at webcook.cz>
 */
class YandexTranslator extends \Webcook\Translator\Translator implements \Webcook\Translator\ITranslator {
	
	const API_URL = 'https://translate.yandex.net/api/v1.5/tr.json/';
	
	private $apiKey = null;
	
	protected $methods = array();
	
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
		$getLangMethod = new \Webcook\Translator\Method('getLangs', self::METHOD_GET_LANGUAGES, array(
			new \Webcook\Translator\MethodParameter('key', true),
			new \Webcook\Translator\MethodParameter('ui', false)
		));
		
		$translateMethod = new \Webcook\Translator\Method('translate', self::METHOD_TRANSLATE, array(
			new \Webcook\Translator\MethodParameter('key', true),
			new \Webcook\Translator\MethodParameter('lang', true),
			new \Webcook\Translator\MethodParameter('text', true, 'text[]')
		));
		
		array_push($this->methods, $getLangMethod);
		array_push($this->methods, $translateMethod);
	}
	
	/**
	 * 
	 */
	public function getLanguages() {
		$url = self::API_URL . $this->getMethodName(self::METHOD_GET_LANGUAGES);
		
		$response = json_decode($this->doRequest($url, array(
			'key' => $this->apiKey,
                        'ui' => 'en'
		)));
		
		$languages = array();
		foreach($response->langs as $abbr => $name){
			array_push($languages, new \Webcook\Translator\Results\LanguageResult($abbr, $name));
		}
		
		return $languages;
	}

	public function translate($text, $languageFrom, $languageTo) {
		$url = self::API_URL . $this->getMethodName(self::METHOD_TRANSLATE);
		
		$response = json_decode($this->doRequest($url, array(
			'key' => $this->apiKey,
			'text' => $text,
			'lang' => $languageFrom . '-' . $languageTo 
		)));
		
		return new \Webcook\Translator\Results\TranslateResult($response->text[0]);
	}	
	
	public function getApiKey() {
		return $this->apiKey;
	}

	public function setApiKey($apiKey) {
		$this->apiKey = $apiKey;
	}
}