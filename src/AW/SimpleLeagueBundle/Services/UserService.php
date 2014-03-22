<?php

namespace AW\SimpleLeagueBundle\Services;

use AW\HmacBundle\Exceptions\APIException;
use AW\SimpleLeagueBundle\Entity\LeagueUser;

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
class UserService extends CrudService
{
    /**
     * Creates a new user object
     *
     * @param \Doctrine\ORM\EntityManager $em The entity manager
     * 
     * @return void
     */
    public function __construct($em)
    {
        parent::__construct($em);
        $this->setBundleName('AWSimpleLeagueBundle');
        $this->setEntityName('LeagueUser');
    }
    
    /**
     * Return the list of LeagueUsers
     * 
     * @return array
     */
    public function getUsers()
    {
        $users = array();
        $usersEm = $this->getRepo()->findAll();
        foreach ($usersEm as $user) {
            $users[] = $user;
        }
        
        return $users;
    }
    
    /**
     * Return a single user
     * 
     * @param integer $id User Id
     * 
     * @throws APIException
     * 
     * @return array
     */
    public function getUser($id)
    {
        return $this->_getUser($id)->toArray();
    }
    
    /**
     * User creation
     * 
     * @param string $name     User Name
     * @param string $email    Email
     * @param string $password Email
     * 
     * @throws APIException
     * 
     * @return \AW\SimpleLeagueBundle\Entity\LeagueUser
     */
    public function createUser($name, $email, $password)
    {
        if ($this->getRepo()->findBy(
            array(
                'name' => $name,
                'email' => $email
            )
        )) {
            throw new APIException('User already exists', -1, 400);
        }
            
        $user = new LeagueUser();
        $user->setName($name);
        $user->setEmail($email);
        $user->setPassword($password);
        
        return $user;
    }
    
    /**
     * Update a given with a given key value parameter set
     * 
     * @param integer $id     User Id
     * @param array   $params Key/Val pair of params. Key will be converted into
     * and accessor name to set on found user object.
     * 
     * @return void
     */
    public function updateUser($id, array $params)
    {
        $user = $this->_getUser($id);
        foreach ($params as $key => $val) {
            $func = 'set' . ucfirst($key);
            if (method_exists($user, $func)) {
                $user->$func($val);
            }
        }
        
        $this->save($user);
    }
    
    /**
     * Remove a given user
     * 
     * @param integer $id User Id
     * 
     * @return void
     */
    public function deleteUser($id)
    {
        $user = $this->_getUser($id);
        $this->delete($user);
    }
    
    /**
     * Get league user object
     * 
     * @param integer $id User Id
     * 
     * @throws APIException
     * 
     * @return \AW\SimpleLeagueBundle\Entity\LeagueUser
     */
    private function _getUser($id)
    {
        return $this->getObject($id);
    }
}
