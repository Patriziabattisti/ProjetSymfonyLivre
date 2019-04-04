<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class MasterController extends AbstractController
{
    /**
     * @Route("/master", name="master")
     */
    public function masterpage()
    {
        return $this->render('sectionUser/ex_affichage_master.html.twig', [
            'controller_name' => 'MasterController',
        ]);
    }
    
    /**
    * @Route ("/master/ajax", name="masterajax");
    */
    public function masterAjax (){
    return $this->render ("sectionUser/ex_affichage_master.html.twig");
    }
    
    /**
     * @Route ("/master/traitement/ajax", name="mastertraitementajax");
     */
    // action qui traite la commande AJAX, elle n'a pas une vue associée
    public function masterTraitementAjax (Request $requeteAjax){
        $valeurNom = $requeteAjax->get ('nom');
        $arrayReponse = ['message' => 'Bienvenu, ' . $valeurNom]; 
        return new JsonResponse ($arrayReponse);

    }
    
    /**
     * @Route("/master/mapage")
     */
    public function masterMaPage(){
        return $this->render('sectionUser/pageutilisateur.html.twig', [
            'controller_name' => 'MasterController',
        ]);
    }

    /**
     * @Route("/master/perso");
     */
    
    public function masterPerso(){
               return $this->render('sectionUser/pageperso.html.twig', [
            'controller_name' => 'MasterController',
        ]);
    }
    


}
