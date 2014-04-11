<?php

namespace AW\SimpleLeagueBundle\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Tests for the property controller.
 *
 * @category  Tests
 * @package   AW
 * @author    Alex Wyett <alex@carltonsoftware.co.uk>
 * @copyright 2014 Alex Wyett
 * @license   All rights reserved
 * @link      http://www.wyett.co.uk
 */
class BaseTest extends WebTestCase
{    
    /**
     * Perform a curl request a return variables
     * 
     * @param string|array $path    Url path from root
     * @param string       $verb    HTTP Verb
     * @param array        $params  Any additional parameters
     * @param boolean      $jsonVar Return json as array (true) or object (false)
     * 
     * @return array
     */
    public function doRequest(
        $path,
        $verb = 'GET',
        $params = array(),
        $jsonVar = true
    ) {
        $client = static::createClient();
        
        $url = '';
        if (is_array($path)) {
            $url = $client->getContainer()->get('router')->generate(
                $path[0], 
                $path[1], 
                false
            );
        } else {
            if (substr($path, 0, 1) == '/') {
                $url = $path;
            } else {
                $url = $client->getContainer()->get('router')->generate(
                    $path, 
                    array(), 
                    false
                );
            }
        }
        
        
        $crawler = $client->request(
            $verb, 
            $url, 
            $params
        );
        $response = $client->getResponse();
        
        return array(
            'client' => $client,
            'crawler' => $crawler,
            'response' => $response,
            'headers' => $response->headers,
            'status' => $response->getStatusCode(),
            'content' => $response->getContent(),
            'json' => json_decode($response->getContent(), $jsonVar)
        );
    }
    
    /**
     * Test the json response
     * 
     * @param integer                                             $status Status code
     * @param \Symfony\Component\HttpFoundation\ResponseHeaderBag $headers Header Bag
     * 
     * @return void
     */
    public function isJsonOk($status, $headers)
    {
        // Check the headers
        $this->assertEquals(200, $status);
        $this->assertTrue(
            $headers->contains('Content-Type', 'application/json')
        );
    }
    
    /**
     * Create and return a new League object
     * 
     * @param string $name League Name
     * 
     * @return stdClass
     */
    public static function createNewLeague($name)
    {
        $response = self::doRequest(
            'create_league',
            'POST',
            array(
                'name' => $name
            )
        );
        
        $league = self::doRequest(
            $response['headers']->get('Content-Location'),
            'GET',
            array(),
            false
        );
        
        return $league['json'];
    }
    
    /**
     * Create and return a new season object
     * 
     * @param string  $name Season Name
     * @param string  $date Season Date
     * @param integer $name League Id
     * 
     * @return stdClass
     */
    public static function createNewSeason($name, $date, $league_id)
    {
        $response = self::doRequest(
            'create_season',
            'POST',
            array(
                'name' => $name,
                'league' => $league_id,
                'startDate' => $date
            )
        );
        
        $season = self::doRequest(
            $response['headers']->get('Content-Location'),
            'GET',
            array(),
            false
        );
        
        return $season['json'];
    }
}
