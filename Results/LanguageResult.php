<?php

namespace Webcook\Translator\Results;

/**
 * Language result.
 * @author Tomáš Voslař <tomas.voslar at webcook.cz>
 */
class LanguageResult {
	
	private $abbreviation;
	
	private $name;
	
	function __construct($abbreviation, $name) {
		$this->abbreviation = $abbreviation;
		$this->name = $name;
	}

	public function getAbbreviation() {
		return $this->abbreviation;
	}

	public function getName() {
		return $this->name;
	}

	public function setAbbreviation($abbreviation) {
		$this->abbreviation = $abbreviation;
	}

	public function setName($name) {
		$this->name = $name;
	}
}