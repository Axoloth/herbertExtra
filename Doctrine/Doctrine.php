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


class Doctrine{
	
	private $entityManager;
	
	private static $_instance = null;
	
	private function __construct() {
		
		$paths = array( plugin_directory().'/Entity');
		$isDevMode = false;
		
		$dbParams = array(
				'driver'   => 'pdo_mysql',
				'user'     => DB_USER,
				'password' => DB_PASSWORD,
				'dbname'   => DB_NAME,
		);
		
		$config = Setup::createAnnotationMetadataConfiguration($paths, $isDevMode);
		$this->entityManager = EntityManager::create($dbParams, $config);	
		
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