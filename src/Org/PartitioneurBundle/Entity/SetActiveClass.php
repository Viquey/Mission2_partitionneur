<?php


namespace Org\PartitioneurBundle\Entity;

class SetActiveClass {
    
    private $nomPage ;
    
    public function __construct($nomPage) {
        $this->nomPage = $nomPage;
    }
    
    public function setActiveClass($url) {
        
        if ($_SERVER["PHP_SELF"] == $url){
            echo ' class="active"';
        }
        
    }
}


