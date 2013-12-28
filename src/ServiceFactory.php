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
    
    /**
     * Creates service.
     * @return Translator
     */
    public function build($service, $params = array()){

	switch ($service) {
	    case self::YANDEX:

		if(!array_key_exists('key', $params)){
		    throw new \BadMethodCallException('You must provide `key` (Yandex API key) parameter.');
		}

		return new Services\YandexTranslator($params['key']);
		
	    case self::GOOGLE:

		if(!array_key_exists('key', $params)){
		    throw new \BadMethodCallException('You must provide `key` (Google Translate API key) parameter.');
		}

		return new Services\GoogleTranslator($params['key']);
		
	    case self::BING:

		if(!array_key_exists('clientId', $params) ||!array_key_exists('clientSecret', $params)){
		    throw new \BadMethodCallException('You must provide client ID and client secret for your application.');
		}

		return new Services\BingTranslator($params['clientId'], $params['clientSecret']);
		
	    default:
	    break;
	}
    }
}
