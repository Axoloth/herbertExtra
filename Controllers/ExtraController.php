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
use Axoloth\DoctrineHerbert\SymfonyForms\SymfonyForm;



class ExtraController{
	
	protected $entityManager;

	protected $formFactory;
	
		
	public function __construct(Container $container, $concrete){
		$this->entityManager = Doctrine::getInstance()->getEntityManager();
		$this->formFactory = SymfonyForm::getInstance()->getFormFactory();
	}
}