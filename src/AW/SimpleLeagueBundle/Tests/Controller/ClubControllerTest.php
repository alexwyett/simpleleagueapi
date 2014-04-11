<?php

namespace AW\SimpleLeagueBundle\Tests\Controller;

class ClubControllerTest extends \AW\SimpleLeagueBundle\Tests\BaseTest
{
    /**
     * Test Club Creation
     * 
     * @dataProvider clubsProvider
     */
    public function testCreateClub($name, $id)
    {
        $response = $this->doRequest(
            'create_club',
            'POST',
            array(
                'name' => $name
            )
        );
        
        $this->assertEquals(201, $response['status']);
        $this->_testGetClub($name, $id);
    }
    
    /**
     * Test Club Creation
     * 
     * @dataProvider clubsProvider
     */
    public function testUpdateCreateClub($name, $id)
    {
        $response = $this->doRequest(
            array(
                'update_club',
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
        $this->_testGetClub($name . ' Updated', $id);
    }
    
    /**
     * Test delete club action
     * 
     * @return void
     */
    public function testDeleteClub()
    {
        $response = $this->doRequest(
            array(
                'delete_club',
                array(
                    'id' => 4
                )
            ),
            'DELETE'
        );
        
        $this->assertEquals(204, $response['status']);
        
        $expectedError = $this->_getClub(4);
        $this->assertEquals(404, $expectedError['status']);
    }
    
    
    /**
     * Test Club Request
     * 
     * @param string $name Club Name
     * @param string $id   Club ID
     * 
     * @return void
     */
    private function _testGetClub($name, $id)
    {
        $response = $this->_getClub($id);
        
        $this->assertEquals(200, $response['status']);
        $this->assertEquals($name, $response['json']->name);
        $this->assertEquals($id, $response['json']->id);
    }
    
    /**
     * Get Club
     * 
     * @param string $id Club ID
     * 
     * @return array
     */
    private function _getClub($id)
    {
        return $this->doRequest(
            array(
                'view_club',
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
     * Return clubs to test create function
     * 
     * @return array
     */
    public function clubsProvider()
    {
        return array(
            array(
                'name' => 'Blofield',
                'id' => 1
            ),
            array(
                'name' => 'CP81',
                'id' => 2
            ),
            array(
                'name' => 'SOS',
                'id' => 3
            ),
            array(
                'name' => 'Test Club',
                'id' => 4
            )
        );
    }
}
