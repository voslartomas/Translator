<?php

namespace Webcook\Translator;

/**
 * Factory for creating translator services.
 * @author Tomáš Voslař <tomas.voslar at webcook.cz>
 */
class ServiceFactory {

    /* @var Yandex service constant. */
    const YANDEX = 1;

    /* @var Google Translate service constant. */
    const GOOGLE = 2;
    
    /* @var Bing service constant. */
    const BING = 3;
    
    /* @var Array settings for factory */
    private $settings;
    
    public function __construct($settings = array(self::YANDEX => array(), self::GOOGLE => array(), self::BING => array())) {
	$this->settings = $settings;
    }
    
    /**
     * Creates service.
     * @return Translator
     */
    public function build($service, $params = array()){
	
	switch ($service) {
	    case self::YANDEX:

		if(!array_key_exists('key', $params) && !array_key_exists('key', $this->settings[self::YANDEX])){
		    throw new \BadMethodCallException('You must provide `key` (Yandex API key) parameter.');
		}else{
		    if(!array_key_exists('key', $params)){
			$params['key'] = $this->settings[self::YANDEX]['key'];
		    }
		}

		return new Services\YandexTranslator($params['key']);
		
	    case self::GOOGLE:

		
		if(!array_key_exists('key', $params) && !array_key_exists('key', $this->settings[self::GOOGLE])){
		    throw new \BadMethodCallException('You must provide `key` (Google Translate API key) parameter.');
		}else{
		    if(!array_key_exists('key', $params)){
			$params['key'] = $this->settings[self::GOOGLE]['key'];
		    }
		}

		return new Services\GoogleTranslator($params['key']);
		
	    case self::BING:

		if((!array_key_exists('clientId', $params) || !array_key_exists('clientSecret', $params)) &&
		    (!array_key_exists('clientId', $this->settings[self::BING]) || !array_key_exists('clientSecret', $this->settings[self::BING]))){
			throw new \BadMethodCallException('You must provide client ID and client secret for your application.');
		}else{
		    if(!array_key_exists('clientId', $params)){
			$params['clientId'] = $this->settings[self::BING]['clientId'];
			$params['clientSecret'] = $this->settings[self::BING]['clientSecret'];
		    }
		}
		
		return new Services\BingTranslator($params['clientId'], $params['clientSecret']);
		
	    default:
	    break;
	}
    }
    
    public static function getServices(){
	return array(
	    self::YANDEX => 'Yandex',
	    self::GOOGLE => 'Google',
	    self::BING => 'Bing'
	);
    }
    
    public function getSettings() {
	return $this->settings;
    }

    public function setSettings($settings) {
	$this->settings = $settings;
    }
}
