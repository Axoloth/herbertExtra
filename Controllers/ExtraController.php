<?php
/**
 * (c) Axoloth - 2015
 * 
 * Base controller.
 * Providing Doctrine's entityManager
 * Providing Symfony FormFactory
 * 
 */

namespace Axoloth\HerbertExtra\Controllers;

use Axoloth\HerbertExtra\Doctrine\Doctrine;
use Axoloth\HerbertExtra\SymfonyForms\SymfonyForm;
use Herbert\Framework\Http;



class ExtraController{
	
	protected $entityManager;

	protected $formFactory;
	
	protected $nbByPage=5;
		
	public function __construct(){
		$this->entityManager = Doctrine::getInstance()->getEntityManager();
		$this->formFactory = SymfonyForm::getInstance()->getFormFactory();
	}
	
	protected function getPage( Http $http ){
		if ($http->has('page')){
			return $http->get('page');
		}
		else{
			return 1;
		}
	}
}