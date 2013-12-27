<?php

namespace Webcook\Translator;

/**
 * Method parameter class.
 * @author Tomáš Voslař <tomas.voslar at webcook.cz>
 */
class MethodParameter {
	
	private $name;
	
	private $required;
	
	private $type;
	
	function __construct($name, $required, $type = 'string') {
		$this->name = $name;
		$this->required = $required;
		$this->type = $type;
	}

	public function getName() {
		return $this->name;
	}

	public function getRequired() {
		return $this->required;
	}

	public function getType() {
		return $this->type;
	}

	public function setName($name) {
		$this->name = $name;
	}

	public function setRequired($required) {
		$this->required = $required;
	}

	public function setType($type) {
		$this->type = $type;
	}
}