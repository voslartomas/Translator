<?php

namespace Webcook\Translator;

/**
 * Factory for creating translator services.
 * @author Tomáš Voslař <tomas.voslar at webcook.cz>
 */
class ServiceFactory {
	
	/* @var Yandex service constant. */
	const YANDEX = 1;
	
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
				
			default:
				break;
		}
	}
}
