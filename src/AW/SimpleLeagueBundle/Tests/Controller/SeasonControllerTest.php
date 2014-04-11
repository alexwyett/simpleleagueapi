<?php

namespace AW\SimpleLeagueBundle\Tests\Controller;

class SeasonControllerTest extends \AW\SimpleLeagueBundle\Tests\BaseTest
{
    /**
     * League Id
     * 
     * @var integer
     */
    protected static $leagueId;
    
    /**
     * Create League Id
     * 
     * @return void
     */
    public static function setUpBeforeClass()
    {
        $league = self::createNewLeague('SeasonControllerTestLeague');
        
        self::$leagueId = $league->id;
    }
    
    /**
     * Test Season Creation
     * 
     * @dataProvider seasonProvider
     */
    public function testCreateSeason($name, $date, $id)
    {   
        $response = $this->doRequest(
            'create_season',
            'POST',
            array(
                'name' => $name,
                'league' => self::$leagueId,
                'startDate' => $date
            )
        );
        
        $this->assertEquals(201, $response['status']);
        $this->_testGetSeason($name, $date, $id);
    }
    
    /**
     * Test Season Update
     * 
     * @dataProvider seasonProvider
     */
    public function testUpdateSeason($name, $date, $id)
    {
        $response = $this->doRequest(
            array(
                'update_season',
                array(
                    'id' => $id
                )
            ),
            'PUT',
            array(
                'name' => $name . ' Updated',
                'league' => self::$leagueId,
                'startDate' => $date
            )
        );
        
        $this->assertEquals(204, $response['status']);
        $this->_testGetSeason($name . ' Updated', $date, $id);
    }
    
    /**
     * Test delete Season action
     * 
     * @return void
     */
    public function testDeleteSeason()
    {
        $response = $this->doRequest(
            array(
                'delete_season',
                array(
                    'id' => 3
                )
            ),
            'DELETE'
        );
        
        $this->assertEquals(204, $response['status']);
        
        $expectedError = $this->_getSeason(3);
        $this->assertEquals(404, $expectedError['status']);
    }
    
    
    /**
     * Test Season Request
     * 
     * @param string  $name      Season Name
     * @param string  $date      Season Date
     * @param string  $id        Season ID
     * 
     * @return void
     */
    private function _testGetSeason($name, $date, $id)
    {
        $response = $this->_getSeason($id);
        
        $this->assertEquals(200, $response['status']);
        $this->assertEquals($id, $response['json']->id);
        $this->assertEquals($name, $response['json']->name);
    }
    
    /**
     * Get Season
     * 
     * @param string $id League ID
     * 
     * @return array
     */
    private function _getSeason($id)
    {
        return $this->doRequest(
            array(
                'view_season',
                array(
                    'id' => $id
                )
            ),
            'GET',
            array(),
            false
        );
    }
    
    /**
     * Return Season to test create function
     * 
     * @return array
     */
    public function seasonProvider()
    {
        return array(
            array(
                'name' => '2013/2014 Season',
                'date' => '2013-09-01',
                'id' => 1
            ),
            array(
                'name' => '2012/2013 Season',
                'date' => '2012-09-01',
                'id' => 2
            ),
            array(
                'name' => '2014/2015 Season',
                'date' => '2014-09-01',
                'id' => 3
            )
        );
    }
}
