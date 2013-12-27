<?php

namespace Webcook\Translator;

/**
 * API method class.
 * @author Tomáš Voslař <tomas.voslar at webcook.cz>
 */
class Method {
	
	private $type;
	
	private $name;
	
	private $parameters;
	
	function __construct($name, $type, $parameters = null) {
		$this->name = $name;
		$this->type = $type;
		$this->parameters = $parameters;
	}

	public function addParameter($name, $required = false, $type = 'string'){
		$method = new MethodParameter();
		$method->setName($name);
		$method->setRequired($required);
		$method->setType($type);
		
		$this->parameters[] = $method;
	}
	
	public function getName() {
		return $this->name;
	}

	public function getParameters() {
		return $this->parameters;
	}

	public function setName($name) {
		$this->name = $name;
	}

	public function setParameters($parameters) {
		$this->parameters = $parameters;
	}
	
	public function getType() {
		return $this->type;
	}

	public function setType($type) {
		$this->type = $type;
	}
}