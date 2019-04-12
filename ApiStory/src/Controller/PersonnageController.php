<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\Personnage;
use App\Form\PersonnageType;
use App\Entity\Livre;
use Symfony\Component\HttpFoundation\RedirectResponse;

class PersonnageController extends AbstractController
{
    /**
     * @Route("/personnage/new", name="newperso");
     */
    
    function PersonnageNew(Request $req){
        $em=$this->getDoctrine()->getManager();
        
        $livre=$req->getSession()->get('bookid');
        
        $perso=new Personnage();
        
        $formulaireperso = $this->createForm (PersonnageType::class, $perso);
        $formulaireperso->handleRequest($req);
        
        if($formulaireperso->isSubmitted() && $formulaireperso->isValid()){
            
        }
        
        
        
        $vars=["formulaire"=>$formulaireperso->createView(),"livre"=>$livre];
        return $this->render('pagesdesPersonnages/newperso.html.twig',$vars );
        
    }
}


