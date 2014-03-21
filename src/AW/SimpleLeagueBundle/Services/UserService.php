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
class UserService
{
    /**
     * Entity Manager
     * 
     * @var \Doctrine\ORM\EntityManager
     */
    private $em;

    /**
     * Creates a new user object
     *
     * @param \Doctrine\ORM\EntityManager $em    The entity manager
     * @param array                       $roles User Roles
     * 
     * @return void
     */
    public function __construct($em)
    {
        $this->em = $em;
    }
    
    /**
     * Return the list of LeagueUsers
     * 
     * @return array
     */
    public function getUsers()
    {
        $users = array();
        $usersEm = $this->em->getRepository('AWSimpleLeagueBundle:LeagueUser')->findAll();
        foreach ($usersEm as $user) {
            $users[] = $user->toArray();
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
     * @return void
     */
    public function createUser($name, $email, $password)
    {
        if ($this->_getUserRepo()->findBy(
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
        $user = $this->_getUser($name);
        foreach ($params as $key => $val) {
            $func = 'set' . ucfirst($key);
            if (method_exists($user, $func)) {
                $user->$func($val);
            }
        }
        
        $this->em->persist($user);
        $this->em->flush();
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
        $this->em->remove($user);
        $this->em->flush();
    }
    
    /**
     * Get apiuser object
     * 
     * @param integer $id User Id
     * 
     * @throws APIException
     * 
     * @return \AW\SimpleLeagueBundle\Entity\ApiUser
     */
    private function _getUser($id)
    {
        $user = $this->_getUserRepo()->findOneById($id);        
        if ($user) {
            return $user;
        } else {
            throw new APIException('User not found: ' . $id, -1, 404);
        }
    }
    
    /**
     * Return the user repo
     * 
     * @return \Doctrine\ORM\EntityRepository
     */
    private function _getUserRepo()        
    {
        return $this->em->getRepository(
            'AWSimpleLeagueBundle:LeagueUser'
        );
    }
}
