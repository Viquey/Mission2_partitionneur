<?php

namespace Org\PartitioneurBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Org\PartitioneurBundle\Entity\JsonPartition;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    
    /**
     * @Route("/index",name="_index")
     * @Route("/",name="_index")
     * @Template()
     */
    public function indexAction()
    {
        return array('message' => "Accueil");
    }
    
        
}
