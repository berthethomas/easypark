<?php

namespace AppBundle\Service;

use AppBundle\Entity\User;
use AppBundle\Entity\Adresse;

class Data {
    
    public function __construct($doctrine = NULL) {
        $this->doctrine = $doctrine;
    }

    public function getTotalOffre() {
        $repository = $this->doctrine->getManager()->getRepository('AppBundle:Offre');
        return count($repository->findAll());
    }
    
    public function getUserOfre(User $user) {
        $repository = $this->doctrine->getManager()->getRepository('AppBundle:Offre');
        return count($repository->findBy(array('auteur' => $user)));
    }
    
    public function getReservation(User $user) {
        $repository = $this->doctrine->getManager()->getRepository('AppBundle:Reservation');
        return count($repository->findBy(array('user' => $user)));
    }
    
    public function getGeoCodeAdresse(Adresse $adresse, $googleToken) {
        $value = $adresse->getParsedAdresse();
        $data = json_decode(file_get_contents("https://maps.googleapis.com/maps/api/geocode/json?address=" . $value . "&key=" . $googleToken));

        $lat = null;
        $lng = null;

        if (isset($data->results)) {
            if (isset($data->results[0])) {
                if (isset($data->results[0]->geometry)) {
                    if (isset($data->results[0]->geometry->location)) {
                        if (isset($data->results[0]->geometry->location->lat)) {
                            $lat = $data->results[0]->geometry->location->lat;
                        } if (isset($data->results[0]->geometry->location->lng)) {
                            $lng = $data->results[0]->geometry->location->lng;
                        }
                    }
                }
            }
        }

        if ($lat !== null && $lng !== null) {
            $adresse->setLatitude($lat);
            $adresse->setLongitude($lng);

            $em = $this->doctrine->getManager();
            $em->persist($adresse);
            $em->flush();
        }
    }

}
