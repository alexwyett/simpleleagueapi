<?php

namespace AW\SimpleLeagueBundle\Controller;

use AW\HmacBundle\Controller as AWHmacBundle;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use AW\HmacBundle\Annotations as AWAnnotation;
use AW\HmacBundle\Annotations\HMAC;
use AW\HmacBundle\Annotations\Validation;

class LeagueController extends AWHmacBundle\DefaultController
{
    /**
     * List Leagues function
     * 
     * @Route("/league", name="view_leagues")
     * @Method("GET")
     * @HMAC(public=false, roles="ADMIN")
     * 
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function listLeaguesAction()
    {
        return $this->jsonResponse(
            $this->_getLeagueService()->getLeaguesAsArray()
        );
    }
    
    /**
     * List League function
     * 
     * @Route("/league/{id}", name="view_league")
     * @Method("GET")
     * @HMAC(public=false, roles="ADMIN")
     * 
     * @param integer $id League Id
     * 
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function listLeagueAction($id)
    {
        return $this->jsonResponse(
            $this->_getLeagueService()->getLeague($id)->toArray()
        );
    }
    
    /**
     * Create League function
     * 
     * @Route("/league", name="create_league")
     * @Method("POST")
     * @HMAC(public=false, roles="ADMIN")
     * @Validation\ValidateString(field="name", maxLength=64)
     * 
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function createLeagueAction()
    {
        $league = $this->_getLeagueService()->createLeague(
            $this->getFromRequest('name')
        );
        
        $this->getEm()->persist($league);
        $this->getEm()->flush();
        
        return $this->createdResponse(
            $this->generateUrl(
                'view_league', 
                array(
                    'id' => $league->getId()
                )
            )
        );
    }
    
    
    /**
     * Delete League function
     * 
     * @Route("/league/{id}", name="delete_league")
     * @Method("DELETE")
     * @HMAC(public=false, roles="ADMIN")
     * 
     * @param integer $id League Id
     * 
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function deleteLeagueAction($id)
    {
        $league = $this->_getLeagueService()->getLeague($id);
        $this->getEm()->remove($league);
        $this->getEm()->flush();
        return $this->okResponse();
    }
    
    /**
     * Update League
     * 
     * @Route("/league/{id}", name="update_league")
     * @Method("PUT")
     * @HMAC(public=false, roles="ADMIN")
     * @Validation\ValidateString(field="name", maxLength=64)
     * 
     * @param integer $id League Id
     * 
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function updateLeagueAction($id)
    {
        $this->_getLeagueService()->updateLeague(
            $id,
            array(
                'name' => $this->getFromRequest('name')
            )
        );
        
        return $this->okResponse();
    }
    
    /**
     * Return the league service
     * 
     * @return \AW\SimpleLeagueBundle\Services\LeagueService
     */
    private function _getLeagueService()
    {
        return $this->get('AW_league_service');
    }
}