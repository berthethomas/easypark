<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use AppBundle\Entity\Reservation;
use AppBundle\Form\MessageType;
use Symfony\Component\Config\Definition\Exception\Exception;
use AppBundle\Entity\Message;
use AppBundle\Entity\Offre;

class MessageController extends Controller {

    /**
     * @Route("/message/{reservation}", name="messages")
     */
    public function indexAction(Reservation $reservation) {
        if ($reservation->getUser()->getId() == $this->getUser()->getId()) {
            $form = $this->createForm(MessageType::class, new Message());

            $repository = $this->getDoctrine()->getManager()->getRepository('AppBundle:Message');

            return $this->render('message/index.html.twig', [
                        'user' => $this->getUser(),
                        'reservation' => $reservation,
                        'messages' => $repository->findBy(array('reservation' => $reservation), array('date' => "ASC")),
                        'form' => $form->createView()
            ]);
        } else {
            throw new Exception("Vous n'avez pas accès à ces messages.");
        }
    }

    /**
     * @Route("/offres/{offre}/reservations/{reservation}/messages", name="messages_proprietaire")
     */
    public function proprietaireAction(Offre $offre, Reservation $reservation) {
        if ($offre->getAuteur()->getId() == $this->getUser()->getId()) {
            $form = $this->createForm(MessageType::class, new Message());

            $repository = $this->getDoctrine()->getManager()->getRepository('AppBundle:Message');

            return $this->render('message/proprietaire.html.twig', [
                        'user' => $this->getUser(),
                        'reservation' => $reservation,
                        'messages' => $repository->findBy(array('reservation' => $reservation), array('date' => "ASC")),
                        'form' => $form->createView()
            ]);
        } else {
            throw new Exception("Vous n'avez pas accès à ces messages.");
        }
    }

    /**
     * @Route("/message/{reservation}/send/{redirect}", name="send_message")
     */
    public function sendMessageAction(Request $request, Reservation $reservation, $redirect = 'messages') {
        $message = new Message();
        $form = $this->createForm(MessageType::class, $message);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $message->setDate(new \DateTime());
            $message->setAuteur($this->getUser());
            $message->setReservation($reservation);

            $em = $this->getDoctrine()->getManager();
            $em->persist($message);
            $em->flush();
        }

        if ($redirect == "messages") {
            return $this->redirectToRoute($redirect, array('reservation' => $reservation->getId()));
        } else {
            return $this->redirectToRoute($redirect, array('reservation' => $reservation->getId(), 'offre' => $reservation->getOffre()->getId()));
        }
    }

}
