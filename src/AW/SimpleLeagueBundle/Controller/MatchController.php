<?php

namespace AW\SimpleLeagueBundle\Controller;

use AW\HmacBundle\Controller as AWHmacBundle;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use AW\HmacBundle\Annotations as AWAnnotation;
use AW\HmacBundle\Annotations\HMAC;
use AW\HmacBundle\Annotations\Validation;

class MatchController extends AWHmacBundle\DefaultController
{
    /**
     * Create Match function
     * 
     * @Route("/match")
     * @Method("POST")
     * @HMAC(public=false, roles="ADMIN")
     * @Validation\ValidateNumber(field="homeTeam")
     * @Validation\ValidateNumber(field="awayTeam")
     * @Validation\ValidateNumber(field="season")
     * @Validation\ValidateDate(field="date")
     * 
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function createMatchAction()
    {
        $home = $this->_getTeamService()->getTeam(
            $this->getFromRequest('homeTeam')
        );
        $away = $this->_getTeamService()->getTeam(
            $this->getFromRequest('awayTeam')
        );
        $season = $this->_getSeasonService()->getSeason(
            $this->getFromRequest('season')
        );
        $date = new \DateTime($this->getFromRequest('date'));
        
        $match = $this->_getMatchService()->createMatch(
            $home, 
            $away, 
            $season, 
            $date
        );
        
        $this->getEm()->persist($match);
        $this->getEm()->flush();
        
        return $this->createdResponse(
            $this->generateUrl(
                'view_match', 
                array(
                    'id' => $match->getId()
                )
            )
        );
    }
    
    /**
     * Update Match function
     * 
     * @Route("/match/{id}")
     * @Method("PUT")
     * @HMAC(public=false, roles="ADMIN")
     * @Validation\ValidateNumber(field="homeTeam")
     * @Validation\ValidateNumber(field="awayTeam")
     * @Validation\ValidateNumber(field="season")
     * @Validation\ValidateDate(field="date")
     * 
     * @param integer $id Match ID
     * 
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function updateMatchAction($id)
    {
        $match = $this->_getMatchService()->getMatch($id);
        $home = $this->_getTeamService()->getTeam(
            $this->getFromRequest('homeTeam')
        );
        $away = $this->_getTeamService()->getTeam(
            $this->getFromRequest('awayTeam')
        );
        $season = $this->_getSeasonService()->getSeason(
            $this->getFromRequest('season')
        );
        $date = new \DateTime($this->getFromRequest('date'));
        $match = $this->_getMatchService()->updateMatch(
            $match, 
            $home, 
            $away, 
            $season, 
            $date
        );
        
        $this->getEm()->persist($match);
        $this->getEm()->flush();
        
        return $this->okResponse();
    }
    
    /**
     * Return the match service
     * 
     * @return \AW\SimpleLeagueBundle\Services\MatchService
     */
    private function _getMatchService()
    {
        return $this->get('AW_match_service');
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
    
    /**
     * Return the team service
     * 
     * @return \AW\SimpleLeagueBundle\Services\SeasonService
     */
    private function _getSeasonService()
    {
        return $this->get('AW_season_service');
    }
}