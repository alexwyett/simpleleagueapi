<?php

namespace AW\SimpleLeagueBundle\Controller;

use AW\HmacBundle\Controller as AWHmacBundle;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use AW\HmacBundle\Annotations as AWAnnotation;
use AW\HmacBundle\Annotations\HMAC;
use AW\HmacBundle\Annotations\Validation;

class SeasonController extends AWHmacBundle\DefaultController
{
    /**
     * List Seasons function
     * 
     * @Route("/season")
     * @Method("GET")
     * @HMAC(public=false, roles="ADMIN")
     * 
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function listSeasonsAction()
    {
        return $this->jsonResponse(
            $this->_getSeasonService()->getSeasonsAsArray()
        );
    }
    
    /**
     * List Season function
     * 
     * @Route("/season/{id}", name="view_season")
     * @Method("GET")
     * @HMAC(public=false, roles="ADMIN")
     * 
     * @param integer $id Season Id
     * 
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function listSeasonAction($id)
    {
        return $this->jsonResponse(
            $this->_getSeasonService()->getSeason($id)->toArray()
        );
    }
    
    /**
     * Create Season function
     * 
     * @Route("/season", name="create_season")
     * @Method("POST")
     * @HMAC(public=false, roles="ADMIN")
     * @Validation\ValidateNumber(field="league")
     * @Validation\ValidateString(field="name", maxLength=64)
     * @Validation\ValidateDate(field="startDate")
     * 
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function createSeasonAction()
    {
        $league = $this->_getLeagueService()->getLeague(
            $this->getFromRequest('league')
        );
        $date = new \DateTime($this->getFromRequest('startDate'));
        
        $season = $this->_getSeasonService()->createSeason(
            $league, 
            $this->getFromRequest('name'), 
            $date
        );
        
        $this->getEm()->persist($season);
        $this->getEm()->flush();
        
        return $this->createdResponse(
            $this->generateUrl(
                'view_season', 
                array(
                    'id' => $season->getId()
                )
            )
        );
    }
    
    /**
     * Update Season
     * 
     * @Route("/season/{id}", name="update_season")
     * @Method("PUT")
     * @HMAC(public=false, roles="ADMIN")
     * @Validation\ValidateNumber(field="league")
     * @Validation\ValidateString(field="name", maxLength=64)
     * @Validation\ValidateDate(field="startDate")
     * 
     * @param integer $id Season Id
     * 
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function updateSeasonAction($id)
    {
        $this->_getSeasonService()->updateSeason(
            $id,
            array(
                'league' => $this->_getLeagueService()->getLeague(
                    $this->getFromRequest('league')
                ),
                'name' => $this->getFromRequest('name'),
                'date' => new \DateTime($this->getFromRequest('startDate'))
            )
        );
        
        return $this->okResponse();
    }
    
    /**
     * Delete Season
     * 
     * @Route("/season/{id}", name="delete_season")
     * @Method("DELETE")
     * @HMAC(public=false, roles="ADMIN")
     * 
     * @param integer $id Season Id
     * 
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function deleteSeasonAction($id)
    {
        $season = $this->_getSeasonService()->getSeason($id);
        if (count($season->getMatch()) > 0) {
            throw new \AW\HmacBundle\Exceptions\APIException(
                'Cannot delete season with matches set', 
                -1, 
                400
            );
        }
        
        $this->getEm()->remove($season);
        $this->getEm()->flush();
        
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