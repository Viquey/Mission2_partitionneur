<?php

namespace Org\PartitionneurBundle\Entity;

class JsonPartition {
  /* @var $card le cardinal max des groupes à concevoir */
  private $card;

  /* @var $personnes liste de noms de personnes */
  private $personnes;
  
  /* @var $nbPersonnes nombre de personnes */
  private $nbPersonne;
  
  /* @var $isEquilibre si equilibre ($card % $nbPersonne == 0) */
  private $isEquilibre;

  public function __construct($card, $listePers) {
    $this->card = $card;
    $this->personnes = $listePers;
    shuffle($this->personnes);
  }
    
  /**
     * Set nbPersonne
     *
     * @param int $personnes
     * @return JsonPartition
     */
    public function setNbPersonne($personnes)
    {
        $this->nbPersonne = count($personnes);

        return $this;
    }

    /**
     * Get nbPersonne
     *
     * @return int
     */
    public function getNbPersonne()
    {
        $this->nbPersonne = count($this->personnes);
        return $this->nbPersonne;
    }
    
    /**
     * Get isEquilibre
     *
     * @return boolean
     */
    public function isEquilibre()
    {
        $this->isEquilibre = false;
        if ($this->nbPersonne % $this->card == 0) {
            $this->isEquilibre = true;
        }
        
        return $this->isEquilibre;
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
        $tab[$g][] = ["nom" => \trim($this->personnes[$index++])];
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
  
  public function getSecondJson() {
            $nombreEleve = count($this->personnes);
                
            //definition des variables
            $nbrDeGroup = ceil($nombreEleve / $this->card) ;
            $reste = $nombreEleve%($nbrDeGroup - 1 );
            $indiceMax = $nbrDeGroup-1;
                
            //remplissage du tableau
            for($i=0;$i<$indiceMax;$i++){
                $tab[$i]=($nombreEleve-$reste)/($nbrDeGroup-1);
             }
            $tab[$indiceMax]=$reste;
             
            //reequilibrage
            for($j=$indiceMax-1;$tab[0]-$tab[$indiceMax]>1;$j--){
                if($j<0){
                     $j=$indiceMax-1;
                }
                $tab[$j]--;
                $tab[$indiceMax]++;
            }
                
            /*PHASE 3 : REPARTITION ALEATOIRE DES ELEVES DANS LES GROUPES
              initalisation tableau eleve present*/
            for($g=0;$g<count($this->personnes);$g++){
                $present[$g]=false;
            }
            $groupes = [];
            $index=0;
            //Boucle des differents groupes
            for($k=0;$k<count($tab);$k++){
                //Boucles des différentes personnes dans chacun des groupes
                for($m=0;$m<$tab[$k];$m++){
                    
                        $groupes[$k][$m] = ["nom" => \trim($this->personnes[$index++])];
                    
                }
            }
            
            $res = ["date" => date("Y-m-d H:i"), "classe" => "BTS SIO SLAM", "groupes" => $groupes];
            return \json_encode($res);
  }
}


