<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use AppBundle\Entity\Offre;
use AppBundle\Form\OffreType;
use AppBundle\Service\Data;

class OffreController extends Controller {

    /**
     * @Route("/offres", name="offres")
     */
    public function indexAction(Request $request) {
        $user = $this->getUser();

        return $this->render('offres/index.html.twig', array(
                    'user' => $user
        ));
    }

    /**
     * @Route("/offres/add", name="offre_add")
     */
    public function addOffreAction(Request $request) {
        $offre = new Offre();
        $offre->setAuteur($this->getUser());

        $form = $this->createForm(OffreType::class, $offre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($offre);

            $adresse = $offre->getAdresse();
            $adresse->setOffre($offre);
            $em->persist($adresse);

            $em->flush();

            $service = new Data($this->getDoctrine());
            $service->getGeoCodeAdresse($adresse, $this->getParameter('GOOGLE_API_KEY'));

            return $this->redirectToRoute('offres');
        }

        return $this->render('offres/addOffre.html.twig', array(
                    'offre' => $offre,
                    'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/offres/edit/{offre}", name="offre_edit")
     */
    public function editOffreAction(Request $request, Offre $offre) {
        $offre->setAuteur($this->getUser());

        $form = $this->createForm(OffreType::class, $offre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($offre);

            $adresse = $offre->getAdresse();
            $adresse->setOffre($offre);
            $em->persist($adresse);

            $em->flush();

            $service = new Data($this->getDoctrine());
            $service->getGeoCodeAdresse($adresse, $this->getParameter('GOOGLE_API_KEY'));

            return $this->redirectToRoute('offres');
        }

        return $this->render('offres/editOffre.html.twig', array(
                    'offre' => $offre,
                    'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/offres/remove/{offre}", name="offre_remove")
     */
    public function removeOffreAction(Offre $offre) {
        $em = $this->getDoctrine()->getManager();
        $em->remove($offre);
        $em->flush();

        return $this->redirectToRoute('offres');
    }

}
