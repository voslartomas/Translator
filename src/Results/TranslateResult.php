<?php

namespace Webcook\Translator\Results;

/**
 * Translate result class.
 * @author Tomáš Voslař <tomas.voslar at webcook.cz>
 */
class TranslateResult {
	
	private $translation;
	
	/**
	 * Constructor
	 * @param String $translation
	 */
	public function __construct($translation){
		$this->translation = $translation;
	}
	
	/* Getter for translation. */
	public function getTranslation() {
		return $this->translation;
	}

	/* Setter for translation. */
	public function setTranslation($translation) {
		$this->translation = $translation;
	}	
}
