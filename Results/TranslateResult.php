<?php

namespace Webcook\Translator\Results;

/**
 * Translate result class.
 * @author Tomáš Voslař <tomas.voslar at webcook.cz>
 */
class TranslateResult {
	
	private $translation;
	
	public function __construct($translation){
		$this->translation = $translation;
	}
	
	public function getTranslation() {
		return $this->translation;
	}

	public function setTranslation($translation) {
		$this->translation = $translation;
	}	
}