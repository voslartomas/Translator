<?php

namespace Webcook\Translator\Results;

/**
 * Language result.
 * @author Tomáš Voslař <tomas.voslar at webcook.cz>
 */
class LanguageResult {
	
	private $abbreviation;
	
	private $name;
	
	/**
	 * Constructor
	 * @param String $abbreviation
	 * @param String $name
	 */
	function __construct($abbreviation, $name) {
		$this->abbreviation = $abbreviation;
		$this->name = $name;
	}
	
	/* Getter for abbreviation. */
	public function getAbbreviation() {
		return $this->abbreviation;
	}
	
	/* Getter for name. */
	public function getName() {
		return $this->name;
	}

	/* Setter for abbreviation. */
	public function setAbbreviation($abbreviation) {
		$this->abbreviation = $abbreviation;
	}

	/* Setter for name. */
	public function setName($name) {
		$this->name = $name;
	}
}
