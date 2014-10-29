<?php

namespace Org\PartitionneurBundle\Entity;

class JsonPartition {
  /* @var $card le cardinal max des groupes à concevoir */
  private $card;

  /* @var $personnes liste de noms de personnes */
  private $personnes;

  public function __construct($card, $listePers) {
    $this->card = $card;
    $this->personnes = $listePers;
    shuffle($this->personnes);
  }

  public function getJson() {
    $nbGrp = count($this->personnes) / (int) $this->card;
    $delta = 0;
    if (count($this->personnes) % $this->card != 0) :
      // pas un diviseur, donc ne pas traiter les deux derniers groupements potentiels
      $delta = 2;
    endif;

    $tab = [];
    $index = 0;
    // construction des premiers groupes
    $g = 0;
    for (; $g < $nbGrp - $delta; $g++) :
      for ($i = 0; $i < $this->card; $i++):
        if(trim($this->personnes[$index])!=""){
            $tab[$g][] = ["nom" => \trim($this->personnes[$index++])];
        }
        else{
           $index++; 
        }
      endfor;
    endfor;

    // faut-il traiter les 2 derniers groupes ?
    if ($delta) :
      $restant = count($this->personnes) - $index;
      // on construit les 2 groupes manquants en les équilibrant, le cardinal change
      $newcard = $restant / 2;
      for ($i = 0; $i < $newcard; $i++):
        $tab[$g][] = ["nom" => \trim($this->personnes[$index++])];
      endfor;
      // le dernier groupe
      $g++;
      while ($index < count($this->personnes)):
        $tab[$g][] = ["nom" => \trim($this->personnes[$index++])];
      endwhile;
    endif;
    // construction d'un tableau associatif pour la création du json
    // clé du tableu = attribut d'un objet json
    $res = ["date" => date("Y-m-d H:i"), "classe" => "BTS SIO SLAM", "groupes" => $tab];
    return \json_encode($res);
  }
}


