<?php

namespace Org\FormaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class DefaultController extends Controller
{
    /**
     * @Route("/org/login") name="_message"
     * @Template()
     */
    public function indexAction()
    {
        return array('message' => "test");
    }
    
    /**
     * @Route("/org/test") name="_message_test"
     * @Template()
     */
    public function testAction()
    {
        return array('message' => "test");
    }
}
