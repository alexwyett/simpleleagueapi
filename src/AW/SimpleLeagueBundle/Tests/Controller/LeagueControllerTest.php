<?php

namespace AW\SimpleLeagueBundle\Tests\Controller;

class LeagueControllerTest extends \AW\SimpleLeagueBundle\Tests\BaseTest
{
    /**
     * Test League Creation
     * 
     * @dataProvider leagueProvider
     */
    public function testCreateLeague($name, $id)
    {
        $response = $this->doRequest(
            'create_league',
            'POST',
            array(
                'name' => $name
            )
        );
        
        $this->assertEquals(201, $response['status']);
        $this->_testGetLeague($name, $id);
    }
    
    /**
     * Test League Creation
     * 
     * @dataProvider leagueProvider
     */
    public function testUpdateCreateLeague($name, $id)
    {
        $response = $this->doRequest(
            array(
                'update_league',
                array(
                    'id' => $id
                )
            ),
            'PUT',
            array(
                'name' => $name . ' Updated'
            )
        );
        
        $this->assertEquals(204, $response['status']);
        $this->_testGetLeague($name . ' Updated', $id);
    }
    
    /**
     * Test delete League action
     * 
     * @return void
     */
    public function testDeleteLeague()
    {
        $response = $this->doRequest(
            array(
                'delete_league',
                array(
                    'id' => 3
                )
            ),
            'DELETE'
        );
        
        $this->assertEquals(204, $response['status']);
        
        $expectedError = $this->_getLeague(3);
        $this->assertEquals(404, $expectedError['status']);
    }
    
    
    /**
     * Test League Request
     * 
     * @param string $name League Name
     * @param string $id   League ID
     * 
     * @return void
     */
    private function _testGetLeague($name, $id)
    {
        $response = $this->_getLeague($id);
        
        $this->assertEquals(200, $response['status']);
        $this->assertEquals($name, $response['json']->name);
        $this->assertEquals($id, $response['json']->id);
    }
    
    /**
     * Get League
     * 
     * @param string $id League ID
     * 
     * @return array
     */
    private function _getLeague($id)
    {
        return $this->doRequest(
            array(
                'view_league',
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
     * Return League to test create function
     * 
     * @return array
     */
    public function leagueProvider()
    {
        return array(
            array(
                'name' => 'Mixed Division 1',
                'id' => 1
            ),
            array(
                'name' => 'Mens Division 1',
                'id' => 2
            ),
            array(
                'name' => 'Test Division',
                'id' => 3
            )
        );
    }
}
