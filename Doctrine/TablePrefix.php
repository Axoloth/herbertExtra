<?php
/**
 * (c) Axoloth - 2015
 * 
 * Propagate a table prefix for the database.
 * 
 */
namespace Axoloth\HerbertExtra\Doctrine;


use Doctrine\ORM\Event\LoadClassMetadataEventArgs;

class TablePrefix{
	
    protected $_prefix = '';

    public function __construct($prefix){
        $this->_prefix = (string) $prefix;
    }

    public function loadClassMetadata(LoadClassMetadataEventArgs $eventArgs){
        
    	$classMetadata = $eventArgs->getClassMetadata();
        $classMetadata->setTableName($this->_prefix . $classMetadata->getTableName());

        foreach ($classMetadata->getAssociationMappings() as $fieldName => $mapping) {
            if ($mapping['type'] == \Doctrine\ORM\Mapping\ClassMetadataInfo::MANY_TO_MANY) {
                $tableName = $classMetadata->associationMappings[$fieldName]['joinTable']['name'];
                $classMetadata->associationMappings[$fieldName]['joinTable']['name'] = $this->_prefix . $tableName;
            }
        }
    }
}
