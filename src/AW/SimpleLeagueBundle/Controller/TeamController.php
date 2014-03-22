<?php

namespace AW\SimpleLeagueBundle\Controller;

use AW\HmacBundle\Controller as AWHmacBundle;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use AW\HmacBundle\Annotations as AWAnnotation;
use AW\HmacBundle\Annotations\HMAC;
use AW\HmacBundle\Annotations\Validation;

class TeamController extends AWHmacBundle\DefaultController
{
    /**
     * List Teams function
     * 
     * @Route("/team")
     * @Method("GET")
     * @HMAC(public=false, roles="ADMIN")
     * 
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function listTeamsAction()
    {
        return $this->jsonResponse(
            $this->_getTeamService()->getTeamsAsArray()
        );
    }
    
    /**
     * List Team function
     * 
     * @Route("/team/{id}", name="view_team")
     * @Method("GET")
     * @HMAC(public=false, roles="ADMIN")
     * 
     * @param integer $id Team Id
     * 
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function listTeamAction($id)
    {
        return $this->jsonResponse(
            $this->_getTeamService()->getTeam($id)->toArray()
        );
    }
    
    /**
     * Create Team
     * 
     * @Route("/team")
     * @Method("POST")
     * @HMAC(public=false, roles="ADMIN")
     * @Validation\ValidateString(field="name", maxLength=64)
     * @Validation\ValidateNumber(field="clubId")
     * 
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function createTeamAction()
    {
        $team = $this->_getTeamService()->createTeam(
            $this->_getClubService()->getClub(
                $this->getFromRequest('clubId')
            ),
            $this->getFromRequest('name')
        );
        
        $this->getEm()->persist($team);
        $this->getEm()->flush();
        
        return $this->createdResponse(
            $this->generateUrl(
                'view_team', 
                array(
                    'id' => $team->getId()
                )
            )
        );
    }
    
    /**
     * Update Team
     * 
     * @Route("/team/{id}")
     * @Method("PUT")
     * @HMAC(public=false, roles="ADMIN")
     * @Validation\ValidateString(field="name", maxLength=64)
     * 
     * @param integer $id Team Id
     * 
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function updateTeamAction($id)
    {
        $this->_getTeamService()->updateTeam(
            $id,
            array(
                'name' => $this->getFromRequest('name')
            )
        );
        
        return $this->okResponse();
    }
    
    /**
     * Return the club service
     * 
     * @return \AW\SimpleLeagueBundle\Services\ClubService
     */
    private function _getClubService()
    {
        return $this->get('AW_club_service');
    }
    
    /**
     * Return the team service
     * 
     * @return \AW\SimpleLeagueBundle\Services\TeamService
     */
    private function _getTeamService()
    {
        return $this->get('AW_team_service');
    }
}