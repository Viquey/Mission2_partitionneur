<?php

namespace Org\PartitionneurBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Org\PartitionneurBundle\Entity\JsonPartition;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Org\UserBundle\Entity\User;
use Org\PartitionneurBundle\Entity\Eleve;
use Org\PartitionneurBundle\Entity\Classe;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @Route("/secured")
 */
class SecuredController extends Controller
{
    
    /**
     * @Route("/index",name="_index")
     * @Route("/",name="_index")
     * @Template()
     */
    public function indexAction()
    {
        return array();
    }
    
     /**
     * @Route("/application",name="_partitionneur")
     * @Template()
     */
    public function partitionneurAction()
    {
        
        return array();
        
    }
    
     /**
     * @Route("/administration",name="_administration")
     * @Template()
     */
    public function administrationAction()
    {
        
        return array();
        
    }
    
    /**
     * @Route("/addUser",name="_addUser")
     * @Template()
     */
    public function addUserAction(Request $request)
    {   
        $group = $this->getDoctrine()
            ->getRepository('OrgUserBundle:Group')
            ->find(1);
        
        $user = new User();
        $user->setUsername('');
        $user->setPassword('');
        $user->setEmail('');
        $user->setGroups($group);
        
        $form = $this->createFormBuilder($user)
            ->add('username', 'text')
            ->add('password', 'text')
            ->add('email', 'text')
            ->add('save', 'submit')
            ->getForm();
        
        $form->handleRequest($request);

        if ($form->isValid()) {
            
            //cryptage du pswd
            $factory = $this->get('security.encoder_factory');
            $encoder = $factory->getEncoder($user);
            $password = $encoder->encodePassword($user->getPassword(), $user->getSalt());
            $user->setPassword($password);
           
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            return $this->redirect( $this->generateUrl('_administration', array('userCreated'=>'true')));
        }

        return $this->render('OrgPartitionneurBundle:Secured:addUser.html.twig', array(
            'form' => $form->createView(),
        ));       
    }
    
    /**
     * @Route("/addClasse",name="_addClasse")
     * @Template()
     */
    public function addClasseAction(Request $request)
    {
        $classe = new Classe();
        $classe->setName('');

        $form = $this->createFormBuilder($classe)
            ->add('name', 'text')
            ->add('Ajouter', 'submit')
            ->getForm();
        
        $form->handleRequest($request);

        if ($form->isValid()) {
            
            $em = $this->getDoctrine()->getManager();
            $em->persist($classe);
            $em->flush();

            return $this->redirect( $this->generateUrl('_administration', array('classeCreated'=>'true')));
        }

        return $this->render('OrgPartitionneurBundle:Secured:addUser.html.twig', array(
            'form' => $form->createView(),
        ));   
    }
    
    /**
     * @Route("/login", name="_partitionneur_login")
     * @Template()
     */
    public function loginAction()
    {
        $request = $this->getRequest();
        $session = $request->getSession();
        if ($request->attributes->has(SecurityContext::AUTHENTICATION_ERROR)) {
            $error = $request->attributes->get(SecurityContext::AUTHENTICATION_ERROR);
        } else {
            $error = $request->getSession()->get(SecurityContext::AUTHENTICATION_ERROR);
        }

        return $this->render('OrgPartitionneurBundle:Secured:login.html.twig',array(
            'last_username' => $session->get(SecurityContext::LAST_USERNAME),
            'error'         => $error,
        ));
    }

    /**
     * @Route("/login_check", name="_partitionneur_security_check")
     */
    public function securityCheckAction()
    {
        // The security layer will intercept this request
    }

    /**
     * @Route("/logout", name="_partitionneur_logout")
     */
    public function logoutAction()
    {
        // The security layer will intercept this request
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
    
    /**
     * @Route("/uploadCsv", name="_uploadCsv")
     * @Template()
     */
    public function uploadCsvAction(Request $request) {
        
        $form = $this->createFormBuilder()
        ->add('submitFile', 'file', array('label' => 'File to Submit'))
        ->getForm();

        // Check if we are posting stuff
        if ($request->getMethod('post') == 'POST') {
            // Bind request to the form
            //$form->bindRequest($request);
            
            $form->handleRequest($request);

            // If form is valid
            if ($form->isValid()) {
                
                //echo "Le formulaire est valide <br/>Traitement du fichier Csv : <br/><br/>";
                // Get file
                $file = $form->get('submitFile');



                // Your csv file here when you hit submit button
                $donnee = $file->getData();
                //print_r($donnee);
                $csvFile = $donnee->getPathName();

                $handle = fopen($csvFile,'r'); 

                while (($data = fgetcsv($handle, 1000, "\n")) !== FALSE) {
                    
                    $nbLigne = count($data);
                    for ($c=0; $c < $nbLigne; $c++) {
                        //if ($c > 1) {
                            //separe chaque colonne du .csv
                            $featureData = explode(";",$data[$c]);
                            
                            $nbFeatureData = count($featureData);

                            //affectation de chaque colonne à une variable
                            $prenomF = $featureData[0];
                            $nomF = $featureData[1];
                            $classeF = $featureData[2];
                            
                            
                            
                            //Savoir si c'est un eleve ou un prof
                            $explodeClasseF = explode(",", $classeF);
                            $nbExplodeClasseF = count($explodeClasseF);
                            if($nbExplodeClasseF != 1 ) {
                                //c'est un prof
                                $i = 0;
                                //while($i < $nbExplodeClasseF){
                                    //envo
                                    //$i++;
                                //}
                            }
                            else {
                                //c'est un eleve
                                $prenomEleve = $prenomF;
                                $nomEleve = $nomF;
                                $classeEleve = $classeF;

                                

                                $eleve = new Eleve();
                                $eleve->setNom($nomEleve);
                                $eleve->setPrenom($prenomEleve);

                                $classe = new Classe();
                                
                                $tabClasse = array();
                                if (in_array($classeF, $tabClasse)){
                                    
                                    
                                    
                                }
                                else {
                                    $tabClasse[] = $classeF;
                                    print_r($tabClasse);
                                    
                                    $classe->setName($classeF);
                                    
                                    $em = $this->getDoctrine()->getManager();
                                    $em->persist($classe);
                                    $em->flush();
                                }
                                
                                    
                                
                                
                                
                                //Envoi des donnee a la bdd
                                
                                
                                //$em->persist($eleve);
                                //$em->flush();
                                
                            }
                            //return $this->redirect( $this->generateUrl('_administration', array('classeCreated'=>'true')));
                        //}
                        
                        //echo('</p>');
                    }
                }
                fclose($handle);
            }

        }

        return $this->render('OrgPartitionneurBundle:Secured:uploadCsv.html.twig',
            array('form' => $form->createView(),)
        );
        
    }
}
