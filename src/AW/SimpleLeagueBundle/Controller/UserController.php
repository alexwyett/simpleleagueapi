<?php

namespace AW\SimpleLeagueBundle\Controller;

use AW\HmacBundle\Controller as AWHmacBundle;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use AW\HmacBundle\Annotations as AWAnnotation;
use AW\HmacBundle\Annotations\HMAC;
use AW\HmacBundle\Annotations\Validation;

class UserController extends AWHmacBundle\DefaultController
{
    /**
     * List Users function
     * 
     * @Route("/leagueuser")
     * @Method("GET")
     * @HMAC(public=false, roles="ADMIN")
     * 
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function listLeagueUsersAction()
    {
        return $this->jsonResponse(
            $this->_getUserService()->getUsers()
        );
    }
    
    /**
     * List User function
     * 
     * @Route("/leagueuser/{id}", name="view_leagueuser")
     * @Method("GET")
     * @HMAC(public=false, roles="ADMIN")
     * 
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function listLeagueUserAction($id)
    {
        return $this->jsonResponse(
            $this->_getUserService()->getUser($id)
        );
    }
    
    /**
     * List User function
     * 
     * @Route("/leagueuser")
     * @Method("POST")
     * @HMAC(public=false, roles="ADMIN")
     * @Validation\ValidateString(field="name", maxLength=64)
     * @Validation\ValidateEmail(field="email", maxLength=128)
     * @Validation\ValidateString(field="password", maxLength=40)
     * 
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function createLeagueUserAction()
    {
        $user = $this->_getUserService()->createUser(
            $this->getFromRequest('name'), 
            $this->getFromRequest('email'),
            $this->getFromRequest('password')
        );
        
        $em = $this->getDoctrine()->getManager();
        $em->persist($user);
        $em->flush();
        
        return $this->createdResponse(
            $this->generateUrl(
                'view_leagueuser', 
                array(
                    'id' => $user->getId()
                )
            )
        );
    }
    
    /**
     * Return the user service
     * 
     * @return \AW\SimpleLeagueBundle\Services\UserService
     */
    private function _getUserService()
    {
        return $this->get('AW_leagueuser_service');
    }
}
