<?php

namespace AW\SimpleLeagueBundle\Controller;

use AW\HmacBundle\Controller as AWHmacBundle;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class DefaultController extends AWHmacBundle\DefaultController
{
    /**
     * @Route("/hello/{name}")
     * @Template()
     */
    public function indexAction($name)
    {
        return array('name' => $name);
    }
}
