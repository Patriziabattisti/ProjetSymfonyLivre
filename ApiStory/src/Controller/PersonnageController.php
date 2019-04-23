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
     * @Route("master/personnage/new", name="newperso");
     */
    
    function PersonnageNew(Request $req){
        $em=$this->getDoctrine()->getManager();
        
        $livre=$req->getSession()->get('bookid');
        
        $repoLivre=$em->getRepository(Livre::class);
        $monlivre= $repoLivre->find($livre->getId());
        
        $perso=new Personnage();
        
        $formulaireperso = $this->createForm (PersonnageType::class, $perso);
        $formulaireperso->handleRequest($req);
        
        if($formulaireperso->isSubmitted() && $formulaireperso->isValid()){
            
            $perso->addLivre($monlivre);
      
            $em->persist($perso);
            $em->flush();  
            
            return $this->redirectToRoute('persos'); 
        }
             
        $vars=["formulaire"=>$formulaireperso->createView(),"livre"=>$livre];
        return $this->render('pagesdesPersonnages/newperso.html.twig',$vars );
        
    }
    /**
     * @Route("/master/personnage/principaux", name="persosprincipaux");
     */
    
    function PersonnagePrincipaux(Request $req){
        $em=$this->getDoctrine()->getManager();
        $persolivre=[];
        $livre=$req->getSession()->get('bookid');
        $idlivre=$livre->getId();
        $repoperso=$em->getRepository(Personnage::class);
        //$repolivre=$em->getRepository(Livre::class);

        $listeperso=$repoperso->findAll();
        $mesperso=$repoperso->findBy(array('principal'=>true));
        
        for($i=0;$i<count($mesperso);$i++){
            $livreperso=$mesperso[$i]->getLivre();
            for($j=0;$j<count($livreperso);$j++){
                if($livreperso[$j]->getId()==$idlivre){
                    $persolivre[]=$mesperso[$i];
                }
            }
        }

        $vars=["livre"=>$livre, "livreperso"=>$persolivre, 'listeperso'=>$listeperso];
        return $this->render('pagesdesPersonnages/principaux.html.twig', $vars);
    }
    
    /**
     * @Route("/master/personnage/secondaire", name="persosecondaires");
     */
    
    function PersonnageSecondaire(Request $req){
             $em=$this->getDoctrine()->getManager();
        $persolivre=[];
        $livre=$req->getSession()->get('bookid');
        $idlivre=$livre->getId();
        $repoperso=$em->getRepository(Personnage::class);
   
        $mesperso=$repoperso->findBy(array('principal'=>false));
        
        for($i=0;$i<count($mesperso);$i++){
            $livreperso=$mesperso[$i]->getLivre();
            for($j=0;$j<count($livreperso);$j++){
                if($livreperso[$j]->getId()==$idlivre){
                    $persolivre[]=$mesperso[$i];
                }
            }
        }
        $vars=["livre"=>$livre, "livreperso"=>$persolivre];
        return $this->render('pagesdesPersonnages/secondaire.html.twig', $vars);
    }
}


