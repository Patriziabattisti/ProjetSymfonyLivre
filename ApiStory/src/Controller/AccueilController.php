<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\LivreFormType;
use App\Entity\Livre;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class AccueilController extends AbstractController
{
    /**
     * @Route("/accueil", name="accueil")
     */
    public function index()
    {
        return $this->render('accueil/index.html.twig', [
            'controller_name' => 'AccueilController',
        ]);
    }
    
    /**
     * @Route("/accueil/nouvhistoire",name="nouvhistoire");
     */
    
    public function nouvHistoire(){
        
        return $this->render('accueil/nouvhistoire.html.twig',[
            'controller_name' => 'AccueilController']);
    }
    
    
    /**
     * @Route("/accueil/enregistrement/histoire")
     */
    
    public function enregistrementHistoire(Request $requete){
        $em=$this->getDoctrine()->getManager();
        $rep=$em->getRepository(Livre::class);
  
        $unlivre=new Livre();

        $formulairelivre = $this->createForm (LivreFormType::class, $unlivre);
        $formulairelivre->handleRequest($requete);

        
        if($formulairelivre->isSubmitted() && $formulairelivre->isValid()){
            $user=$this->getUser();
            $unlivre->setUser($user);
            
            /*dump($unlivre);
            die();*/
  
            $em->persist($unlivre);
            $em->flush();
            
            return $this->render('/accueil/nouvhistoire.html.twig');
        }
       
        $vars = ['formulaire' => $formulairelivre->createView()];
        return $this->render ('/accueil/formLivre.html.twig',$vars);
        

    }
}
