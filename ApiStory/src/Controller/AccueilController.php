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
    public function index(Request $requete)
    {
        $em=$this->getDoctrine()->getManager();
        $rep=$em->getRepository(Livre::class);
  
        $unlivre=new Livre();

        $formulairelivre = $this->createForm (LivreFormType::class, $unlivre);
        $formulairelivre->handleRequest($requete);
        $user=$this->getUser();
        
        if($formulairelivre->isSubmitted() && $formulairelivre->isValid()){
            
            $unlivre->setUser($user);
  
            $em->persist($unlivre);
            $em->flush();
            $vars=['livre'=>$unlivre];
            return $this->render('/accueil/nouvhistoire.html.twig',$vars);
        }
        $livres=$rep->findBy(array('user'=>$user->getId()));
    
        
        $vars = ['formulaire' => $formulairelivre->createView(), 'meslivres'=>$livres];
         return $this->render('accueil/index.html.twig', $vars);
        
    }
    
    /**
     * @Route("/accueil/nouvhistoire/{idlivre}",name="nouvhistoire");
     */
    
    public function nouvHistoire(Request $req){
        $em=$this->getDoctrine()->getManager();
        $rep=$em->getRepository(Livre::class);

        $monidlivre=$req->get('idlivre');
        $monlivre=$rep->find($monidlivre);
        
        $vars=['controller_name' => 'AccueilController', 'livre'=>$monlivre];
        return $this->render('accueil/nouvhistoire.html.twig',$vars);
    }
    
    

}
