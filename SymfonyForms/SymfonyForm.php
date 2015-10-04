<?php
/**
 * (c) Axoloth - 2015
 * 
 * Symfony form bootstrap
 * Singleton class that provide the formFactory.
 * 
 * Give usage of Validator and Translator
 * 
 */
namespace Axoloth\HerbertExtra\SymfonyForms;

use Doctrine\Common\Annotations\AnnotationRegistry;
use Symfony\Bridge\Twig\Extension\FormExtension;
use Symfony\Bridge\Twig\Extension\TranslationExtension;
use Symfony\Bridge\Twig\Form\TwigRenderer;
use Symfony\Bridge\Twig\Form\TwigRendererEngine;
use Symfony\Component\Form\Extension\Csrf\CsrfExtension;
use Symfony\Component\Form\Extension\Validator\ValidatorExtension;
use Symfony\Component\Form\Forms;
use Symfony\Component\Security\Csrf\CsrfTokenManager;
use Symfony\Component\Translation\Loader\XliffFileLoader;
use Symfony\Component\Translation\Translator;
use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\Validator;
use Axoloth\HerbertExtra\Tools\ExtraLoader;

/**
 * 
 * @author Axoloth
 *
 */
class SymfonyForm{
	
	private $validator;
	
	private $formFactory;
	
	private static $_instance = null;
	
	private function __construct() {
		
		$vendorDir = getVendorDir();
			
		$csrfTokenManager = new CsrfTokenManager();

		// AnnotationRegistry::registerAutoloadNamespace('\Symfony\\Component\\Validator\\Constraints\\', $vendorDir."symfony\validator");
		AnnotationRegistry::registerLoader(new ExtraLoader(array(
				'Symfony\Component\Validator\Constraints',
				$vendorDir."symfony\validator",
		)));
		
		$localCode = substr(get_locale(), 0, 2) ;

		$translator = new Translator($localCode);
		$translator->setFallbackLocale('en');
		
		$translator->addLoader('xlf', new XliffFileLoader());
		$translator->addResource('xlf', $vendorDir . 'symfony\form\Resources\translations\validators.'.$localCode.'.xlf', $localCode, 'validators');
		$translator->addResource('xlf', $vendorDir . 'symfony\validator\Resources\translations\validators.'.$localCode.'.xlf', $localCode , 'validators');
				
		$validator =Validation::createValidatorBuilder()
			->addMethodMapping('loadValidatorMetadata')
			->enableAnnotationMapping()
			->setTranslator($translator)
			->setTranslationDomain('validators')
			->getValidator();
		
		$this->validator = $validator;
			
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