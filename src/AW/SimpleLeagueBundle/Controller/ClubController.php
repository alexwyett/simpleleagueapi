<?php

namespace AW\SimpleLeagueBundle\Controller;

use AW\HmacBundle\Controller as AWHmacBundle;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use AW\HmacBundle\Annotations as AWAnnotation;
use AW\HmacBundle\Annotations\HMAC;
use AW\HmacBundle\Annotations\Validation;

class ClubController extends AWHmacBundle\DefaultController
{
    /**
     * List Clubs function
     * 
     * @Route("/club")
     * @Method("GET")
     * @HMAC(public=false, roles="ADMIN")
     * 
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function listClubsAction()
    {
        return $this->jsonResponse(
            $this->_getClubService()->getClubsAsArray()
        );
    }
    
    /**
     * List Club function
     * 
     * @Route("/club/{id}", name="view_club")
     * @Method("GET")
     * @HMAC(public=false, roles="ADMIN")
     * 
     * @param integer $id Club Id
     * 
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function listClubAction($id)
    {
        return $this->jsonResponse(
            $this->_getClubService()->getClub($id)->toArray()
        );
    }
    
    /**
     * Create Club function
     * 
     * @Route("/club")
     * @Method("POST")
     * @HMAC(public=false, roles="ADMIN")
     * @Validation\ValidateString(field="name", maxLength=64)
     * 
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function createClubAction()
    {
        $club = $this->_getClubService()->createClub(
            $this->getFromRequest('name')
        );
        
        $this->getEm()->persist($club);
        $this->getEm()->flush();
        
        return $this->createdResponse(
            $this->generateUrl(
                'view_club', 
                array(
                    'id' => $club->getId()
                )
            )
        );
    }
    
    /**
     * Update Team
     * 
     * @Route("/club/{id}")
     * @Method("PUT")
     * @HMAC(public=false, roles="ADMIN")
     * @Validation\ValidateString(field="name", maxLength=64)
     * 
     * @param integer $id Club Id
     * 
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function updateClubAction($id)
    {
        $this->_getClubService()->updateClub(
            $id,
            array(
                'name' => $this->getFromRequest('name')
            )
        );
        
        return $this->okResponse();
    }
    
    /**
     * Add a team to a club
     * 
     * @Route("/club/{clubId}/team/{teamId}")
     * @Method("PUT")
     * @HMAC(public=false, roles="ADMIN")
     * 
     * @param integer $clubId Club Id
     * @param integer $teamId Team Id
     * 
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function addTeamAction($clubId, $teamId)
    {
        $club = $this->_getClubService()->getClub($clubId);
        $team = $this->_getTeamService()->getTeam($teamId);
        
        $club->addTeam($team);
        $team->setClub($club);
        
        $this->getEm()->persist($club);
        $this->getEm()->persist($team);
        $this->getEm()->flush();
        
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