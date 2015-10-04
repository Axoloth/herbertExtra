<?php
namespace Axoloth\HerbertExtra\Tools;

/**
 * 
 * @author Axoloth
 *
 *
 * Supprime les redondances registerLoader()
 * permet de résoudre un bug du AnnotationRegistry de Doctrine qui n'arrive pas
 * a charger les annotations du Validator par exemple.
 * 
 */
class ExtraLoader{

	protected $namespaces;
	
	
	public function __construct(array $namespaces) {
		$this->namespaces = $namespaces;
	}
	
	
	public function __invoke($name) {
		foreach ($this->namespaces as $namespace) {
			if (strpos($name, $namespace) === 0) {
				return true;
			}
		}
		return false;
	}
}