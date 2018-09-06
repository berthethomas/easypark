<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use AppBundle\Entity\Offre;
use Symfony\Component\Config\Definition\Exception\Exception;

class ReservationController extends Controller {

    /**
     * @Route("/offres/{offre}/reservations", name="consult_reservations")
     */
    public function indexAction(Offre $offre) {
        if ($offre->getAuteur()->getId() == $this->getUser()->getId()) {
            return $this->render('reservation/index.html.twig', [
                        'offre' => $offre
            ]);
        } else {
            throw new Exception("Acces Denied");
        }
    }

}
