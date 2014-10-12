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
     * @Route("/application",name="_partitioneur")
     * @Template()
     */
    public function partitionneurAction()
    {
        
        
        
        return array();
        
        
    }
    
    /**
     * @Route("/index",name="_index")
     * @Template()
     */
    public function indexAction()
    {
        
        function active($url)
        {
            if ($_SERVER["PHP_SELF"] == $url)
            {
                echo ' class="active"';
            }
        }
        return array('message' => "it work !");
    }
    

    
    /**
     * @Route("/jsonpartitionne",name="_jsonPartitionne")
     * @Template()
     */
    
    public function jsonpartitionneAction(Request $request) {
        
        $cardGrp = $request->request->get('cardGrp');
        $csv = $request->request->get('personnes');
        
              
        if (empty($cardGrp) || empty($csv) ):
            echo("something is wrong : cardinal is empty or csv is empty");
            return new Response('{}');
        endif;

     
        $personnes = explode("\n", $csv);

        if (!is_numeric($cardGrp) || !$personnes || $cardGrp <= 0):
            echo("something is wrong : cardianl is not numeric or personnes is not defined or cardinal is <= 0");
            return new Response('{}');           
        endif;
        
        

        $partionneur = new JsonPartition($cardGrp, $personnes);
        return new Response($partionneur->getJson());
    }
    
    
}
