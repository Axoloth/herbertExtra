<?php
/**
 * (c) Axoloth - 2015
 * 
 * Doctrine ORM bootstrap
 * Singleton that give access to the entity manager.
 * 
 */

namespace Axoloth\HerbertExtra\Doctrine;


use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;
use DoctrineHerbert\Helper;
use Doctrine\ORM\Tools\Console\ConsoleRunner;
use Doctrine\Common\Annotations\AnnotationRegistry;
use Doctrine\Common\Annotations\AnnotationReader;


class Doctrine{
	
	private $entityManager;
	
	private static $_instance = null;
	
	private function __construct() {
		
		$vendorDir = getVendorDir();
		
		$paths = array( plugin_directory().'/Entity');
		
		$dbParams = array(
				'driver'   => 'pdo_mysql',
				'user'     => DB_USER,
				'password' => DB_PASSWORD,
				'dbname'   => DB_NAME,
		);
		
		
		/*
		$isDevMode = false;
		
		$dbParams = array(
				'driver'   => 'pdo_mysql',
				'user'     => DB_USER,
				'password' => DB_PASSWORD,
				'dbname'   => DB_NAME,
		);
		
		$config = Setup::createAnnotationMetadataConfiguration($paths, $isDevMode);
		
		$this->entityManager = EntityManager::create($dbParams, $config);
		*/
		$ormconfig = new \Doctrine\ORM\Configuration();
		$cache = new \Doctrine\Common\Cache\ArrayCache();
		$ormconfig->setQueryCacheImpl($cache);
		$ormconfig->setProxyDir($paths. '/Proxies');
		$ormconfig->setProxyNamespace('EntityProxy');
		$ormconfig->setAutoGenerateProxyClasses(true);
		
		// ORM mapping by Annotation Doctrine\Common\Annotations

		
		//AnnotationRegistry::registerFile($vendorDir. 'doctrine/orm/lib/Doctrine/ORM/Mapping/Driver/DoctrineAnnotations.php');
		
		
		
		
		$driver = new \Doctrine\ORM\Mapping\Driver\AnnotationDriver(
				new \Doctrine\Common\Annotations\AnnotationReader(),
				array($paths)
				);
				
		
		$ormconfig->setMetadataDriverImpl($driver);
		$ormconfig->setMetadataCacheImpl($cache);
		
		AnnotationRegistry::registerFile($vendorDir. 'doctrine/orm/lib/Doctrine/ORM/Mapping/Driver/DoctrineAnnotations.php');
		AnnotationRegistry::registerAutoloadNamespace("Symfony\Component\Validator\Constraint", $vendorDir."symfony/validator");
		
		//AnnotationRegistry::registerAutoloadNamespace("MyProject\Annotations", "/path/to/myproject/src");
		
		
		$this->entityManager = \Doctrine\ORM\EntityManager::create($dbParams,$ormconfig);
		
		$tablePrefix = new TablePrefix( $GLOBALS['table_prefix'] );
		
		// set le prefix des tables, identique a la config de WP
		$this->entityManager->getEventManager()->addEventListener(\Doctrine\ORM\Events::loadClassMetadata, $tablePrefix);
		
	}
	
	
	
	
	public static function getInstance() {
		if(is_null(self::$_instance)) {
			self::$_instance = new Doctrine();
		}
		return self::$_instance;
	}
	
	
	
	public function getEntityManager(){
		return $this->entityManager;
	}
	
}