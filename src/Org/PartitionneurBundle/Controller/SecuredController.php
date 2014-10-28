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
     * @Route("/index",name="_index2")
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
     * @Route("/updateMdp", name="_updateMdp")
     * @Template()
     */
    public function updateMdpAction(Request $request){
        
        $user = $this->get('security.context')->getToken()->getUser();
       
        
        $form = $this->createFormBuilder($user)
            ->add('password', 'text')
            ->add('Changer', 'submit')
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

            if($this->get('security.context')->isGranted('ROLE_ADMIN')) {
                return $this->redirect( $this->generateUrl('_administration', array('mdpChanged'=>'true')));
            }
            elseif ($this->get('security.context')->isGranted('ROLE_USER')){
                return $this->redirect( $this->generateUrl('_index', array('mdpChanged'=>'true')));
            }
            
        }
        return $this->render('OrgPartitionneurBundle:Secured:updateMdp.html.twig', array(
            'form' => $form->createView(),
        ));    
    }
    
    /**
     * @Route("/uploadCsv", name="_uploadCsv")
     * @Template()
     */
    public function uploadCsvAction(Request $request) {
        
        $em = $this->getDoctrine()->getManager();
        
        $form = $this->createFormBuilder()
        ->add('submitFile', 'file', array('label' => 'File to Submit'))
        ->getForm();

        // Check if we are posting stuff
        if ($request->getMethod('post') == 'POST') {
            // Bind request to the form
            //$form->bindRequest($request);
            
            $form->handleRequest($request);

            if ($form->isValid()) {
                
                // Get file
                $file = $form->get('submitFile');

                $donnee = $file->getData();
                $csvFile = $donnee->getPathName();
                $handle = fopen($csvFile,'r');
                
                while (($data = fgetcsv($handle, 1000, "\n")) !== FALSE) {
                    
                    $nbLigne = count($data);
                    for ($c=0; $c < $nbLigne; $c++) {

                        //separe chaque colonne du .csv
                        $featureData = explode(";",$data[$c]);

                        //affectation de chaque colonne à une variable
                        $prenomF = $featureData[0];
                        $nomF = $featureData[1];
                        $classeF = $featureData[2];

                        //Savoir si c'est un eleve ou un prof
                        $explodeClasseF = explode(",", $classeF);
                        $nbExplodeClasseF = count($explodeClasseF);
                        
                        if($nbExplodeClasseF != 1 ) {
                            $repository = $this->getDoctrine()
                                ->getRepository('OrgUserBundle:User');
                            $username = strtolower (substr($prenomF,0,1).$nomF);
                            $searchProf = $repository->findByUsername($username);

                            if(count($searchProf)>0){
                                $prof = $repository->findOneByUsername($username);                 
                            }           
                            else{
                                $prof = new User();
                                $prof->setUsername($username);
                                $prof->setEmail("vide");

                                //cryptage pass
                                $factory = $this->get('security.encoder_factory');
                                $encoder = $factory->getEncoder($prof);
                                $password = $encoder->encodePassword("sio22", $prof->getSalt());
                                $prof->setPassword($password);

                                //ajout ROLE_USER
                                $group = $this->getDoctrine()
                                    ->getRepository('OrgUserBundle:Group')
                                    ->find(1);
                                $prof->setGroups($group);                                   
                            }

                            for($i=0;$i < $nbExplodeClasseF;$i++){
                                $strClasse = $explodeClasseF[$i];
                                $repositoryClasse = $this->getDoctrine()
                                    ->getRepository('OrgPartitionneurBundle:Classe');
                                $searchClass = $repositoryClasse->findByName($strClasse);

                                if(count($searchClass)>0){
                                    $classe = $repositoryClasse->findOneByName($strClasse);
                                }                                  
                                else{
                                    $classe = new Classe();
                                    $classe->setName($strClasse );
                                    $em->persist($classe);
                                    $em->flush();
                                }
                                $prof->setClasses($classe);
                            }
                            $em->persist($prof);
                            $em->flush();  
                        }
                        else {    
                            if($nomF != "Nom" & $prenomF != "Prenom"){
                                $eleve = new Eleve();
                                $eleve->setNom($nomF);
                                $eleve->setPrenom($prenomF);

                                $repository = $this->getDoctrine()
                                    ->getRepository('OrgPartitionneurBundle:Classe');
                                $searchClass = $repository->findByName($classeF);

                                if(count($searchClass)>0){
                                    $classe = $repository->findOneByName($classeF);
                                }
                                else{
                                    $classe = new Classe();
                                    $classe->setName($classeF);
                                    $em->persist($classe);
                                    $em->flush();                               
                                }
                                $eleve->setClasse($classe);
                                $em->persist($eleve);
                                $em->flush();
                            }
                        }
                    }
                }
                return $this->redirect( $this->generateUrl('_administration', array('csvUploaded'=>'true')));
                fclose($handle);
            }
        }
        
        return $this->render('OrgPartitionneurBundle:Secured:uploadCsv.html.twig',
            array('form' => $form->createView(),)
        );
        
    }
}
