<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Dompdf\Dompdf;
use Dompdf\Options;
use App\Entity\Livre;

class PdfProducerController extends AbstractController
{
    /**
     * @Route("/pdf/producer/couv/in/pdf", name="pdf_producer")
     */
    public function couvInPdf(Request $req)
    {
        
        $em=$this->getDoctrine()->getManager();
        $replivre=$em->getRepository(Livre::class);
        $monlivre=$req->getSession()->get("bookid");
        $idlivre=$monlivre->getId();
        
        $pdfOptions=new Options();
        $pdfOptions->set ('default_Font','Times');
        
        $dompdf=new Dompdf($pdfOptions);
        $html=$this->render('pdf_producer/index.html.twig', [
            'title' => $monlivre->getTitre(),"livre"=>$monlivre
        ]);
        
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4','portrait');
        $dompdf->render();
        
        $dompdf->stream("mypdf.pdf",["Attachment"=>true]);
        
       return $this->redirectToRoute('nouvhistoire',['idlivre'=>$idlivre]) ;
    }
}
