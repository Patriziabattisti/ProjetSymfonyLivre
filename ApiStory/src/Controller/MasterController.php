<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
//use Symfony\Component\HttpFoundation\Response;
use App\Entity\Auteur;
use App\Form\AuteurFormType;
use App\Entity\Livre;
use App\Entity\Chapitre;
use App\Form\LieuxFormType;
use App\Entity\Lieux;
use App\Form\MondeFormType;
use App\Entity\Monde;
//use Symfony\Component\HttpFoundation\RedirectResponse;

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
    public function masterMaPage(Request $req){
        $em=$this->getDoctrine()->getManager();
        
        $livre=$req->getSession()->get('bookid');
        $user=$this->getUser();
        $repoauteur=$em->getRepository(Auteur::class);
        
        $auteur=new Auteur();

        $monauteur=$user->getAuteur();
 
        $formulaireauteur = $this->createForm (AuteurFormType::class, $auteur);
        $formulaireauteur->handleRequest($req);
        
        if($formulaireauteur->isSubmitted() && $formulaireauteur->isValid()){
            
            if($user->getAuteur()){
                $monauteur=$user->getAuteur();
                //dump($auteur);
                $auteur=$repoauteur->miseAjour($auteur,$monauteur);

            }
            else{
                if($auteur->getPhoto()){
                    $fichier=$auteur->getPhoto();
                    $photo= md5(uniqid()).".".$fichier->guessExtension();

                    $fichier->move("photos",$photo);
                    $auteur->setPhoto($photo);
                }  
            $auteur->setUser($user);
            }
            $em->persist($auteur);
            $em->flush();    
            
        } 
        if($repoauteur->findOneBy(array('user'=>$user->getId()))!=null){
            $auteur=$repoauteur->findOneBy(array('user'=>$user->getId()));
        }
        $vars=['formulaireauteur'=>$formulaireauteur->createView(), 'livre'=>$livre, 'auteur'=>$auteur];
        
        return $this->render('sectionUser/pageutilisateur.html.twig',$vars);
    }

    /**
     * @Route("/master/perso", name="persos");
     */
    
    public function masterPerso(Request $req ){
        $livre=$req->getSession()->get('bookid');
        
        return $this->render('sectionUser/pageperso.html.twig', [
            'controller_name' => 'MasterController','livre'=>$livre
        ]);
    }
    
    /**
     * @Route("/master/options", name="mesoptions");
     */
    
    public function masterOptions(Request $req){
        $livre=$req->getSession()->get('bookid');
        
         return $this->render('sectionUser/pageoptions.html.twig', [
            'controller_name' => 'MasterController','livre'=>$livre
        ]);
    }
    /**
     * @Route("/master/chapitres", name="meschapitres");
     */
    
    public function masterChapitres(Request $req){
        $livre=$req->getSession()->get('bookid');
        $em=$this->getDoctrine()->getManager();
        $repoLivre=$em->getRepository(Livre::class);
        $livre= $repoLivre->find($livre->getId());
        
        $repochapitre=$em->getRepository(Chapitre::class);
        
        if($req->get('contenu')){
            if($req->get('idchapitre')!=''){

                $idchap=(int)$req->get('idchapitre');
                $monchapitre=$repochapitre->find($idchap);
                $monchapitre->setTitre($req->get('titre'));
                $monchapitre->setContenu($req->get('contenu'));
                            
                $em->persist($monchapitre);
                $em->flush();
            }
            else{

                $monchapitre=new Chapitre();   
                $monchapitre->setTitre($req->get('titre'));
                $monchapitre->setContenu($req->get('contenu'));
                $livre->addChapitre($monchapitre);
            
                $em->persist($livre);
                $em->flush();
            }

        }
  
        $chapitres=$repochapitre->findBy(array('livre'=>$livre->getId()));
        
        $vars=['livre'=>$livre, 'chapitres'=>$chapitres];
        
        return $this->render('sectionUser/pagechapitres.html.twig',$vars);
    }
    
    
    
    /**
     * @Route("/master/update/couv", name="updatecouv");
     */
    
    public function UpdateCouv(Request $req){
        $em=$this->getDoctrine()->getManager();
       
        $replivre=$em->getRepository(Livre::class);
        
        $monlivre=$replivre->find($req->getSession()->get('bookid'));
        $macouverture=$req->files->get('couverture');   
//        dump($req);
//        die;
        $couv=md5(uniqid()).".".$macouverture->guessExtension();
        
        $monlivre->setCouverture($couv);
        $macouverture->move("couvertures",$couv);
        $idlivre=$monlivre->getId();
       
        $em->persist($monlivre);
        $em->flush();
        
         return $this->redirectToRoute('nouvhistoire',['idlivre'=>$idlivre]);
    }
    
    /**
     * @Route("/master/update/titre", name="updatetitre");
     */
    
    public function UpdateTitre(Request $req){
        $em=$this->getDoctrine()->getManager();
       
        $replivre=$em->getRepository(Livre::class);
        $monlivre=$replivre->find($req->getSession()->get('bookid'));
        $montitre=$req->get('titre');
        $monresume=$req->get('resume');
        
        $monlivre->setTitre($montitre);
        $monlivre->setResume($monresume);
        $idlivre=$monlivre->getId();
        
        $em->persist($monlivre);
        $em->flush();
        
        return $this->redirectToRoute('nouvhistoire',['idlivre'=>$idlivre]);
        
    }
    /**
     * @Route("/master/choice/docu", name="choicedocu")
     */
    public function choiceDocu(Request $req){
      $livre=$req->getSession()->get('bookid');
      $vars=["livre"=>$livre];
      return $this->render('sectionUser/docubtn.html.twig',$vars);
    }
    
    
    /**
     * @Route("/master/docu", name="documentations")
     */
    
    public function masterDocu(Request $req){
        $em=$this->getDoctrine()->getManager();
        $livre=$req->getSession()->get('bookid');
        
        $monde=new Monde();
        $lieux=new Lieux();
        
        $replivre=$em->getRepository(Livre::class);     
        $monlivre=$replivre->find($req->getSession()->get('bookid'));
        
        $formulairemonde = $this->createForm(MondeFormType::class, $monde);
        $formulairemonde->handleRequest($req);
        
        $formulairelieux=$this->createForm(LieuxFormType::class, $lieux);
        $formulairelieux->handleRequest($req);
        
        if($formulairemonde->isSubmitted() && $formulairemonde->isValid()){
            
            $monde->addLivre($monlivre);
            $em->persist($monde);
            $em->flush();
          
        }
        if($formulairelieux->isSubmitted() && $formulairelieux->isValid()){
            
          $em->persist($lieux);
          $em->flush();
        }
        $vars=['formulaire'=>$formulairemonde->createView(),'formulairelieux'=>$formulairelieux->createView(), 'livre'=>$livre];
        return $this->render('sectionUser/pagedocument.html.twig',$vars);
     
    }
     /**
     * @Route("/master/livre/delete", name="deletelivre");
     */
    
    public function LivreDelete(Request $req){
        $em =$this->getDoctrine()->getManager();
        $rep=$em->getRepository(Livre::class);
        
        $idlivre=$req->get('livredelete');
        $livre=$rep->findOneBy(array('id'=>$idlivre));
        
        $em->remove($livre);
        $em->flush();
        
        return $this->redirectToRoute('accueil');
    }


}
