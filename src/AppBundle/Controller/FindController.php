<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Config\Definition\Exception\Exception;
use AppBundle\Entity\Reservation;
use AppBundle\Entity\Offre;

class FindController extends Controller {

    /**
     * @Route("/find", name="find")
     */
    public function indexAction(Request $request) {
        $repository = $this->getDoctrine()->getManager()->getRepository('AppBundle:Offre');
        $offres = $repository->getOffresByUser($this->getUser());

        return $this->render('find/index.html.twig', array(
                    'offres' => $offres,
                    'token_google' => $this->getParameter('GOOGLE_API_KEY')
        ));
    }

    /**
     * @Route("/find/offre/info", name="find_offre_info", methods={"POST"})
     */
    public function infoOffreAction(Request $request) {
        $id = $request->request->get('offre');

        $repository = $this->getDoctrine()->getManager()->getRepository('AppBundle:Offre');
        $offre = $repository->find($id);

        if ($offre !== NULL) {
            $normalizer = new ObjectNormalizer();
            $normalizer->setCircularReferenceLimit(1);
            $normalizer->setCircularReferenceHandler(function ($object) {
                return $object->getId();
            });

            $encoders = array(new XmlEncoder(), new JsonEncoder());
            $normalizers = array($normalizer);
            $serializer = new Serializer($normalizers, $encoders);

            return new JsonResponse($serializer->serialize($offre, 'json'));
        } else {
            throw new Exception("Undefined offre");
        }
    }

    /**
     * @Route("/find/offre/checkout", name="find_offre_checkout", methods={"POST"})
     */
    public function checkoutOffreAction(Request $request) {
        $id = $request->request->get('offre');

        $repository = $this->getDoctrine()->getManager()->getRepository('AppBundle:Offre');
        $offre = $repository->find($id);

        if ($offre !== NULL) {
            $reservations = $repository->getReservations($offre);

            return $this->render('find/checkout.html.twig', array(
                        'offre' => $offre,
                        'reservations' => $reservations,
                        'token_google' => $this->getParameter('GOOGLE_API_KEY')
            ));
        } else {
            throw new Exception("Undefined offre");
        }
    }

    /**
     * @Route("/find/offre/{offre}/reserve", name="find_offre_reserve", methods={"POST"})
     */
    public function reserveOffreAction(Request $request, Offre $offre) {
        $date = $request->request->get('date-resa');

        if ($date !== NULL && $this->validateDate($date)) {
            $date = \DateTime::createFromFormat("d/m/Y", $date);
            $date->setTime(0, 0, 0);
            
            $user = $this->getUser();

            $reservation = new Reservation();
            $reservation->setDate($date);
            $reservation->setOffre($offre);
            $reservation->setUser($user);

            $em = $this->getDoctrine()->getManager();
            $em->persist($reservation);
            $em->flush();

            return $this->redirectToRoute('homepage');
        } else {
            throw new Exception("Date cannot be null");
        }
    }

    private function validateDate($date, $format = 'd/m/Y') {
        $d = \DateTime::createFromFormat($format, $date);
        // The Y ( 4 digits year ) returns TRUE for any integer with any number of digits so changing the comparison from == to === fixes the issue.
        return $d && $d->format($format) === $date;
    }

}
