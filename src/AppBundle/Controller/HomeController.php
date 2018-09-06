<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use AppBundle\Service\Data;

class HomeController extends Controller {

    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request) {
        $service = new Data($this->getDoctrine());
        $repository = $this->getDoctrine()->getManager()->getRepository('AppBundle:Reservation');
        
        return $this->render('home/index.html.twig', [
                    'countEmplacements' => $service->getTotalOffre(),
                    'userEmplacements' => $service->getUserOfre($this->getUser()),
                    'countReservations' => $service->getReservation($this->getUser()),
                    'reservations' => $repository->findBy(array('user' => $this->getUser())),
                    'token_google' => $this->getParameter('GOOGLE_API_KEY')
        ]);
    }

}
