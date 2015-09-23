<?php
/**
 * (c) Axoloth - 2015
 * 
 * Symfony form bootstrap
 * Singleton class that provide the formFactory.
 * 
 */
namespace Axoloth\HerbertExtra\SymfonyForms;

use Symfony\Component\Validator\Validation;
use Symfony\Bridge\Twig\Form\TwigRendererEngine;
use Symfony\Component\Form\Forms;
use Symfony\Component\Form\Extension\Validator\ValidatorExtension;
use Symfony\Component\Form\Extension\Csrf\CsrfExtension;
use Symfony\Component\Security\Csrf\CsrfTokenManager;
use Symfony\Component\Translation\Translator;
use Symfony\Component\Translation\Loader\XliffFileLoader;
use Symfony\Bridge\Twig\Extension\TranslationExtension;
use Symfony\Bridge\Twig\Extension\FormExtension;
use Symfony\Bridge\Twig\Form\TwigRenderer;


class SymfonyForm{
	
	private $formFactory;
	
	private static $_instance = null;
	
	private function __construct() {
		
		$vendorDir = getVendorDir();
			
		$csrfTokenManager = new CsrfTokenManager();
		
		$validator = Validation::createValidator();
		
		$localCode = substr(get_locale(), 0, 2) ;
		$translator = new Translator( $localCode );
		$translator->addLoader('xlf', new XliffFileLoader());
		$translator->addResource('xlf', $vendorDir . 'symfony\form\Resources\translations\validators.en.xlf', $localCode, 'validators');
		$translator->addResource('xlf', $vendorDir . 'symfony\validator\Resources\translations\validators.en.xlf', $localCode, 'validators');
		
		$twig = herbert('Twig_Environment');
				
		$formEngine = new TwigRendererEngine(array(getDefaultFormTheme()));
		$formEngine->setEnvironment($twig);
				
		$twig->addExtension(new TranslationExtension($translator));
		$twig->addExtension(
				new FormExtension(new TwigRenderer($formEngine, $csrfTokenManager))
		);
		
		$this->formFactory = Forms::createFormFactoryBuilder()
			->addExtension(new CsrfExtension($csrfTokenManager))
			->addExtension(new ValidatorExtension($validator))
			->getFormFactory();
	}
	
	
	public static function getInstance() {
		if(is_null(self::$_instance)) {
			self::$_instance = new SymfonyForm();
		}
		return self::$_instance;
	}
	
	
	public function getFormFactory(){
		return $this->formFactory;
	}
	
}