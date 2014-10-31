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

/**
 * @Route("/secured")
 */
class SecuredController extends Controller
{
    /**
     * @Route("/administration/ajoutProf", name="_addProf")
     * @Template()
     */
    public function addProfAction(Request $request) {
        
        $prof = new User();
        $prof->setNom('');
        $prof->setPrenom('');
        $prof->setUsername('');
        $prof->setPassword('');
        $prof->setEmail('vide');
        //$prof->setClasses('');
        
        $classeRepository = $this->getDoctrine()->getRepository('OrgPartitionneurBundle:Classe');
        $classes = $classeRepository->findAll();
        foreach($classes as $entity){
            $key=$entity->getId();
            $arrayClasse[$key]=$entity->getName();

        }
            
        
        $form = $this->createFormBuilder()
                ->add('nom', 'text')
                ->add('prenom','text')
                ->add('selectClasse', 'choice', array(
                                        'choices'   => $arrayClasse,
                                    'multiple'  => true,
                                    'expanded'  => true,
                                    'label'     => 'Selectionner la classe',
                                ))
                ->add('Ajouter', 'submit')
                ->getForm();
        
        $form->handleRequest($request);
        
        if ($form->isValid()){
            
            $factory = $this->get('security.encoder_factory');
            $encoder = $factory->getEncoder($prof);
            $password = $encoder->encodePassword("sio22", $prof->getSalt());
            $prof->setPassword($password);
            
            $classes = $form->get('selectClasse')->getData();
            foreach($classes as $selected){
                $classe = $classeRepository->find($selected);
                $prof->setClasses($classe);
            }
            
            //ajout ROLE_USER
            $group = $this->getDoctrine()
            ->getRepository('OrgUserBundle:Group')
            ->find(1);
            
            $prof->setGroups($group);
            
            $prenom = $form->get('prenom')->getData();
            $nom = $form->get('nom')->getData();
            $repositoryProf = $this->getDoctrine()
                            ->getRepository('OrgUserBundle:User');
            
            $username = strtolower(substr($prenom,0,1).$nom);  
            $searchProf = $repositoryProf->findByUsername($username);
            if(count($searchProf)>0){                                   //Améliorer l'algo de fixation d'username
                $username = strtolower(substr($prenom,0,2).$nom);    //Permet seulement d'ajouter une lettre en plus
            }
            
            
            $prof->setUsername($username);
            $prof->setNom($nom);
            $prof->setPrenom($prenom);
            
            $em = $this->getDoctrine()->getManager();
            $em->persist($prof);
            $em->flush();
            
            $this->get('session')->getFlashBag()->add('profAdded', "Le professeur a été ajouté !");
            
            return $this->redirect( $this->generateUrl('_administration'));
            
        }
        
        return $this->render('OrgPartitionneurBundle:Secured:addProf.html.twig', array(
                        'form' => $form->createView(),
                        ));
        
    }
    
    /**
     * @Route("/administration/removeUser",name="_removeUser")
     * @Template()
     */
    public function removeUserAction(Request $request)
    {
        $userRepository = $this->getDoctrine()->getRepository('OrgUserBundle:User');
        $users = $userRepository->findAll();
        foreach($users as $entity) {
            $key = $entity->getId();
            $arrayUser[$key] = $entity->getNom()." ".$entity->getPrenom(); 
        }
        
        
        $form = $this->createFormBuilder()         
                ->add('selectUser', 'choice', array(
                                        'choices'   => $arrayUser,
                                    'multiple'  => false,
                                    'expanded'  => false,
                                    'label'     => 'Selectionner l\'utilisateur',
                                ))
                ->add('Supprimer', 'submit')
                ->getForm();
        
        $form->handleRequest($request);
        
        if($form->isValid()) {
            
            $id = $form->get('selectUser')->getData();
            $user = $userRepository->find($id);
           
            $em = $this->getDoctrine()->getManager();
            $em->remove($user);
            $em->flush();
            
            $this->get('session')->getFlashBag()->add('userRemoved', "L'utilisateur a été supprimé!");
            return $this->redirect( $this->generateUrl('_administration'));
        }
        
       
        return $this->render('OrgPartitionneurBundle:Secured:removeUser.html.twig', array(
                        'form' => $form->createView(),
                        ));
    }
    
    /**
     * @Route("/administration/removeClasse",name="_removeClasse")
     * @Template()
     */
    public function removeClasseAction(Request $request)
    {
        $classeRepository = $this->getDoctrine()->getRepository('OrgPartitionneurBundle:Classe');
        $classes = $classeRepository->findAll();
        foreach($classes as $entity) {
            $key = $entity->getId();
            $arrayClasses[$key] = $entity->getName(); 
        }
        
        
        $form = $this->createFormBuilder()         
                ->add('selectClasse', 'choice', array(
                                        'choices'   => $arrayClasses,
                                    'multiple'  => false,
                                    'expanded'  => false,
                                    'label'     => 'Selectionner la classe',
                                ))
                ->add('Supprimer', 'submit')
                ->getForm();
        
        $form->handleRequest($request);
        
        if($form->isValid()) {
            
            $id = $form->get('selectClasse')->getData();
            $classe = $classeRepository->find($id);
            $eleves = $classe->getEleves();
            $em = $this->getDoctrine()->getManager();
            foreach($eleves as $entity){
                $em->remove($entity);
                $em->flush();
            }
            $em->remove($classe);
            $em->flush();
            
            $this->get('session')->getFlashBag()->add('classeRemoved', "La classe et les élèves ont été supprimés!");
            return $this->redirect( $this->generateUrl('_administration'));
        }
        
       
        return $this->render('OrgPartitionneurBundle:Secured:removeClasse.html.twig', array(
                        'form' => $form->createView(),
                        ));
    }
    
    /**
     * @Route("/tableau-utilisateur",name="_listUser")
     * @Template()
     */
    /*public function listUserAction()
    {
        
        return array();
    }*/
    
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
     * @Route("/administration/setAdmin",name="_setAdmin")
     * @Template()
     */
    public function setAdminAction(Request $request)
    {
        $userRepository = $this->getDoctrine()->getRepository('OrgUserBundle:User');
        $users = $userRepository->findAll();
        $groupAdmin = $this->getDoctrine()
                       ->getRepository('OrgUserBundle:Group')
                       ->find(2);
        foreach($users as $entity) {
            $groupsEntity=$entity->getGroups();
            $validation=false;
            foreach($groupsEntity as $group){
               if($group==$groupAdmin)
                   $validation=true;
            }
            if(!$validation){
                $key = $entity->getId();
                $arrayUser[$key] = $entity->getNom()." ".$entity->getPrenom(); 
            }
        }
        
        
        $form = $this->createFormBuilder()         
                ->add('selectUser', 'choice', array(
                                        'choices'   => $arrayUser,
                                    'multiple'  => false,
                                    'expanded'  => false,
                                    'label'     => 'Selectionner l\'utilisateur',
                                ))
                ->add('Promouvoir', 'submit')
                ->getForm();
        
        $form->handleRequest($request);
        
        if($form->isValid()) {
            
            $id = $form->get('selectUser')->getData();
            $user = $userRepository->find($id);
           
            $groupUser = $this->getDoctrine()
                       ->getRepository('OrgUserBundle:Group')
                       ->find(1);
            
            $user->removeGroup($groupUser);
            $user->setGroups($groupAdmin);
            
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
            
            $this->get('session')->getFlashBag()->add('adminSetted', "Le professeur a été promu !");
            return $this->redirect( $this->generateUrl('_administration'));
        }
        
       
        return $this->render('OrgPartitionneurBundle:Secured:setAdmin.html.twig', array(
                        'form' => $form->createView(),
                        ));
    }
    
    /**
     * @Route("/administration/setUser",name="_setUser")
     * @Template()
     */
    public function setUserAction(Request $request)
    {
        $userRepository = $this->getDoctrine()->getRepository('OrgUserBundle:User');
        $users = $userRepository->findAll();
        $groupUser = $this->getDoctrine()
                       ->getRepository('OrgUserBundle:Group')
                       ->find(1);
        foreach($users as $entity) {
            $groupsEntity=$entity->getGroups();
            $validation=false;
            foreach($groupsEntity as $group){
               if($group==$groupUser)
                   $validation=true;
            }
            if(!$validation){
                $key = $entity->getId();
                $arrayUser[$key] = $entity->getNom()." ".$entity->getPrenom(); 
            }
        }
        
        
        $form = $this->createFormBuilder()         
                ->add('selectUser', 'choice', array(
                                        'choices'   => $arrayUser,
                                    'multiple'  => false,
                                    'expanded'  => false,
                                    'label'     => 'Selectionner l\'utilisateur',
                                ))
                ->add('Retrograder', 'submit')
                ->getForm();
        
        $form->handleRequest($request);
        
        if($form->isValid()) {
            
            $id = $form->get('selectUser')->getData();
            $user = $userRepository->find($id);
           
            $groupAdmin = $this->getDoctrine()
                       ->getRepository('OrgUserBundle:Group')
                       ->find(2);
            
            $user->removeGroup($groupAdmin);
            $user->setGroups($groupUser);
            
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
            
            $this->get('session')->getFlashBag()->add('adminUnsetted', "Le professeur a été rétrogradé !");
            return $this->redirect( $this->generateUrl('_administration'));
        }
        
       
        return $this->render('OrgPartitionneurBundle:Secured:setUser.html.twig', array(
                        'form' => $form->createView(),
                        ));
    }
    
     /**
     * @Route("/application",name="_partitionneur")
     * @Template()
     */
    public function partitionneurAction(Request $request)
    {
        $securityContext = $this->container->get('security.context');
        
        if ($securityContext->isGranted('IS_AUTHENTICATED_FULLY')) {
 
            $user = $this->get('security.context')->getToken()->getUser();
            $allClasse = $user->getClasses();
            if(count($allClasse)>0){
                foreach($allClasse as $entity){
                    $key=$entity->getId();
                    $arrayClasse[$key]=$entity->getName();
                }

                $form = $this->createFormBuilder()
                    ->add('selectClasse', 'choice', array(
                                        'choices'   => $arrayClasse,
                                    'multiple'  => false,
                                    'expanded'  => false,
                                    'label'     => 'Selectionner la classe',
                                ))
                    ->add('Charger', 'submit')
                    ->getForm();


                if ($request->getMethod('post') == 'POST') {
                    // Bind request to the form

                    $form->handleRequest($request);

                    if ($form->isValid()) { 

                        $idClasse = $form->get('selectClasse')->getData();

                        $classeRepository = $this->getDoctrine()->getRepository('OrgPartitionneurBundle:Classe');
                        $classe = $classeRepository->find($idClasse);
                        $arrayEleve = $classe->getEleves();

                        return $this->render('OrgPartitionneurBundle:Secured:partitionneur.html.twig', array(
                        'form' => $form->createView(),
                        'eleves'=> $arrayEleve,
                        ));

                    }
                }

                if($this->get('security.context')->isGranted('ROLE_USER') ) {

                    return $this->render('OrgPartitionneurBundle:Secured:partitionneur.html.twig', array(
                        'form' => $form->createView(),
                        ));
                }
            }
        }
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
     * @Route("/gestion",name="_gestion")
     * @Template()
     */
    public function gestionAction()
    {
        
        return array();
        
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
        $choice = $request->request->get('choice');
        
              
        if (empty($cardGrp) || empty($csv) ):
            echo("something is wrong : cardinal is empty or csv is empty");
            return new Response('{}');
        endif;

     
        $personnes = explode("\n", $csv);
        foreach($personnes as $key=>$value){
            if($value==''){
                array_splice($personnes, $key);
            }
        }

        if (!is_numeric($cardGrp) || !$personnes || $cardGrp <= 1):
            echo("something is wrong : cardinal is not numeric or personnes is not defined or cardinal is <= 1");
            return new Response('{}');           
        endif;
        
        

        $partionneur = new JsonPartition($cardGrp, $personnes);
        if($choice=="maxi"){
            $partionnement=$partionneur->getJson();
        }
        else{
            $partionnement=$partionneur->getSecondJson();
        }
        return new Response($partionnement);
    }
    
    /**
     * @Route("/updateEmail", name="_updateEmail")
     * @Template()
     */
    public function updateEmailAction(Request $request){
        
        $user = $this->get('security.context')->getToken()->getUser();
        
        $form = $this->createFormBuilder($user)
            ->add('email', 'text', array('label'  => 'Votre e-mail',))
            ->add('Confirmer', 'submit')
            ->getForm();
        
        $form->handleRequest($request);

        if ($form->isValid()) {
            
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
            
            $this->get('session')->getFlashBag()->add('emailChanged', "L'email a été changé avec succès !");

            return $this->redirect( $this->generateUrl('_gestion'));
        }

        return $this->render('OrgPartitionneurBundle:Secured:updateEmail.html.twig', array(
            'form' => $form->createView(),
        ));
        
    }
    
    /**
     * @Route("/updateNom", name="_updateNom")
     * @Template()
     */
    public function updateNomAction(Request $request){
        
        $user = $this->get('security.context')->getToken()->getUser();
        
        $form = $this->createFormBuilder($user)
            ->add('nom', 'text', array('label'  => 'Votre nom',))
            ->add('prenom', 'text', array('label'  => 'Votre prénom',))
            ->add('Confirmer', 'submit')
            ->getForm();
        
        $form->handleRequest($request);

        if ($form->isValid()) {
            
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
            
            $this->get('session')->getFlashBag()->add('nomChanged', "Le nom a été changé avec succès !");

            return $this->redirect( $this->generateUrl('_gestion'));
        }

        return $this->render('OrgPartitionneurBundle:Secured:updateNom.html.twig', array(
            'form' => $form->createView(),
        ));
        
    }
    
    /**
     * @Route("/updateMdp", name="_updateMdp")
     * @Template()
     */
    public function updateMdpAction(Request $request){
        
        $user = $this->get('security.context')->getToken()->getUser();
       
        
        $form = $this->createFormBuilder($user)
            ->add('oldPassword', 'password', array('label'  => 'Ancien mot de passe',))
            ->add('newPassword', 'password', array('label'  => 'Nouveau mot de passe',))
            ->add('confirmNewPassword', 'password', array('label'  => 'Confirmer le nouveau mot de passe',))
            ->add('Changer', 'submit')
            ->getForm();
        
        $form->handleRequest($request);

        if ($form->isValid()) {
            //cryptage du oldpswd
            $factory = $this->get('security.encoder_factory');
            $encoder = $factory->getEncoder($user);
            $oldpassword = $encoder->encodePassword($user->getOldPassword(), $user->getSalt());
            $user->setOldPassword($oldpassword);
            if($user->getOldPassword()==$user->getPassword()){
                if($user->getNewPassword()==$user->getConfirmNewPassword()){
                
                    //cryptage du pswd
                    $password = $encoder->encodePassword($user->getNewPassword(), $user->getSalt());
                    $user->setPassword($password);
                    $user->setOldPassword(null);
                    $user->setNewPassword(null);
                    $user->setConfirmNewPassword(null);

                    $em = $this->getDoctrine()->getManager();
                    $em->persist($user);
                    $em->flush();
                    
                    $this->get('session')->getFlashBag()->add('mdpChanged', "Le mot de passe a été changé avec succès !");

                    return $this->redirect( $this->generateUrl('_gestion'));
                    
                }
                else{    
                    $this->get('session')->getFlashBag()->add('newNotOk', "Le champ de confirmation est différent !");
                    
                    return $this->redirect( $this->generateUrl('_updateMdp'));             
                }
            }
            else{
                $this->get('session')->getFlashBag()->add('oldNotOk', "Vous avez entré un mot de passe différent du votre, veuillez le ressaisir.");
                
                return $this->redirect( $this->generateUrl('_updateMdp'));
            }
            
        }
        return $this->render('OrgPartitionneurBundle:Secured:updateMdp.html.twig', array(
            'form' => $form->createView(),
        ));    
    }
    
    /**
     * @Route("/administration/resetMdpBySelectingProf", name="_resetMdpBySelectingProf")
     * @Template()
     */
    public function resetMdpBySelectingProfAction(Request $request) {
        
        $repository = $this->getDoctrine()
                           ->getRepository('OrgUserBundle:User');
        $allProf = $repository->findAll();
        
        foreach($allProf as $entity){
            $key=$entity->getId();
            $arrayProf[$key]=$entity->getUsername();
        }
        
        $form = $this->createFormBuilder()
        ->add('selectProf', 'choice', array(
                            'choices'   => $arrayProf,
                        'multiple'  => false,
                        'expanded'  => false,
                        'label'     => 'Selectionner l\'utilisateur',
                    ))
        ->add('Reinitialiser', 'submit')
        ->getForm();
        
        if ($request->getMethod('post') == 'POST') {
            // Bind request to the form
            
            $form->handleRequest($request);

            if ($form->isValid()) {
                $pswd = $form->get('Reinitialiser')->getData();
                $idSelect = $form->get('selectProf')->getData();
                $username= $arrayProf[$idSelect];
                $user = $repository->findOneByUsername($username);
                $factory = $this->get('security.encoder_factory');
                $encoder = $factory->getEncoder($user);
                $password = $encoder->encodePassword('sio22', $user->getSalt());
                $user->setPassword($password);
                $em = $this->getDoctrine()->getManager();
                $em->persist($user);
                $em->flush();
                
                $this->get('session')->getFlashBag()->add('resetDone', "Le mot de passe a été réinitialisé !");
                
                return $this->redirect( $this->generateUrl('_administration'));
            }
        }
        
        return $this->render('OrgPartitionneurBundle:Secured:resetMdpBySelectingProf.html.twig',
            array('form' => $form->createView(),)
        );
    }
    
    /**
     * @Route("/administration/uploadCsv", name="_uploadCsv")
     * @Template()
     */
    public function uploadCsvAction(Request $request) {
        
        $em = $this->getDoctrine()->getManager();
        
        $form = $this->createFormBuilder()
        ->add('submitFile', 'file', array('label' => 'Fichier à importer'))
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
                            $username = strtolower(substr($prenomF,0,1).$nomF);
                            $searchProf = $repository->findByUsername($username);
                            if(count($searchProf)>0){
                                $prof = $repository->findOneByUsername($username);
                            }
                            else{
                                $prof = new User();
                                $prof->setUsername($username);
                                $prof->setPrenom($prenomF);
                                $prof->setNom($nomF);
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
                                $strClasse = trim($explodeClasseF[$i]);
                                $repositoryClasse = $this->getDoctrine()
                                    ->getRepository('OrgPartitionneurBundle:Classe');
                                $searchClass = $repositoryClasse->findByName($strClasse);
                                if(count($searchClass)>0){
                                    $classe = $repositoryClasse->findOneByName($strClasse);
                                    if(!in_array($classe, $prof->getClasses())){
                                       $prof->setClasses($classe); 
                                    }
                                }
                                else{
                                    $classe = new Classe();
                                    $classe->setName($strClasse );
                                    $em->persist($classe);
                                    $em->flush();
                                    $prof->setClasses($classe);
                                }                            
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
                                    $classe->setName(trim($classeF));
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
                $this->get('session')->getFlashBag()->add('csvUploaded', "Le fichier Csv a été envoyé avec succès !");
                
                return $this->redirect( $this->generateUrl('_administration'));
                fclose($handle);
            }
        }
        
        return $this->render('OrgPartitionneurBundle:Secured:uploadCsv.html.twig',
            array('form' => $form->createView(),)
        );
        
    }
}
