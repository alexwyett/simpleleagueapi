<?php

namespace AW\SimpleLeagueBundle\Services;

use AW\HmacBundle\Exceptions\APIException;
use AW\SimpleLeagueBundle\Entity as ENT;

/**
 * Handles User crud
 *
 * @category  Services
 * @package   AW
 * @author    Alex Wyett <alex@wyett.co.uk>
 * @copyright 2014 Alex Wyett
 * @license   All rights reserved
 * @link      http://www.wyett.co.uk
 */
abstract class CrudService
{
    /**
     * Entity Manager
     * 
     * @var \Doctrine\ORM\EntityManager
     */
    private $em;
    
    /**
     * Bundle Name
     * 
     * @var string
     */
    protected $bundleName;
    
    /**
     * Entity Name
     * 
     * @var string
     */
    protected $entityName;

    /**
     * Creates a new crud service
     *
     * @param \Doctrine\ORM\EntityManager $em The entity manager
     * 
     * @return void
     */
    public function __construct($em)
    {
        $this->em = $em;
    }
    
    /**
     * Return the entity manager
     * 
     * @return \Doctrine\ORM\EntityManager
     */
    public function getEm()
    {
        return $this->em;
    }
    
    /**
     * Return the entity name
     * 
     * @return string
     */
    public function getEntityName()
    {
        return $this->entityName;
    }

    /**
     * Set the bundle name
     * 
     * @param string $name Bundle name
     * 
     * @return AW\SimpleLeagueBundle\Services\CrudService
     */
    public function setBundleName($name)
    {
        $this->bundleName = $name;
        
        return $this;
    }

    /**
     * Set the entity name
     * 
     * @param string $name Entity name
     * 
     * @return AW\SimpleLeagueBundle\Services\CrudService
     */
    public function setEntityName($name)
    {
        $this->entityName = $name;
        
        return $this;
    }

    /**
     * Return the repo
     * 
     * @return \Doctrine\ORM\EntityRepository
     */
    public function getRepo()        
    {
        return $this->em->getRepository(
            sprintf('%s:%s', $this->bundleName, $this->entityName)
        );
    }
    
    /**
     * Create a new entity object
     * 
     * @param type $params
     * 
     * @return \AW\SimpleLeagueBundle\Entity
     */
    public function create($params)
    {
        $entity = '\AW\SimpleLeagueBundle\Entity\\' . $this->entityName;
        $obj = new $entity();
        foreach ($params as $key => $val) {
            $func = 'set' . ucfirst($key);
            if (method_exists($obj, $func)) {
                $obj->$func($val);
            }
        }
        return $obj;
    }
    
    /**
     * Return an updated object
     * 
     * @param integer $id     Object ID
     * @param array   $params Parameters
     * 
     * @return stdClass
     */
    public function update($id, $params)
    {
        $object = $this->getObject($id);
        foreach ($params as $key => $val) {
            $func = 'set' . ucfirst($key);
            if (method_exists($object, $func)) {
                $object->$func($val);
            }
        }
        return $object;
    }
    
    /**
     * Save an enity
     * 
     * @param stdClass $object Object required to be persisted
     * 
     * @return void
     */
    public function save($object)
    {
        $this->getEm()->persist($object);
        $this->getEm()->flush();
    }
    
    /**
     * Remove an enity
     * 
     * @param stdClass $object Object required to be removed
     * 
     * @return void
     */
    public function delete($object)
    {
        $this->getEm()->remove($object);
        $this->getEm()->flush();
    }
    
    /**
     * Get object by id method
     * 
     * @param integer $id Object Id
     * 
     * @throws APIException
     * 
     * @return \AW\SimpleLeagueBundle\Entity
     */
    protected function getObject($id)
    {
        $object = $this->getRepo()->findOneById($id);        
        if ($object) {
            return $object;
        } else {
            throw new APIException(
                $this->getEntityName() . ' not found with id: ' . $id, 
                -1, 
                404
            );
        }
    }
    
    /**
     * Call magic method
     * 
     * @param string $name      Method name
     * @param array  $arguments Args
     * 
     * @return mixed
     */
    public function __call($name, $arguments)
    {
        if (substr($name, -7) == 'AsArray') {
            $accessor = str_replace('AsArray', '', $name);
            $elements = call_user_method_array($accessor, $this, $arguments);
            $array = array();
            foreach ($elements as $element) {
                array_push($array, $element->toArray());
            }
            
            return $array;
        }
        
        if (substr($name, -4) == 'ById') {
            return $this->_getObject($arguments);
        }
        
        throw new \Exception('Invalid method name ' . $name);
    }
}
