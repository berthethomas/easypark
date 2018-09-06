<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Offre
 *
 * @ORM\Table(name="offre")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\OffreRepository")
 */
class Offre {

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var float
     *
     * @ORM\Column(name="prix", type="float")
     */
    private $prix;

    /**
     * @var string
     *
     * @ORM\Column(name="titre", type="string", nullable=true)
     */
    private $titre;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_debut_validite", type="datetime")
     */
    private $dateDebutValiditee;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_fin_validite", type="datetime")
     */
    private $dateFinValiditee;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="offres")
     * @ORM\JoinColumn(onDelete="SET NULL", nullable=true);
     */
    private $auteur;

    /**
     * @ORM\OneToOne(targetEntity="Adresse", mappedBy="offre", cascade={"persist"})
     * @ORM\JoinColumn(onDelete="CASCADE");
     */
    private $adresse;

    /**
     * @ORM\ManyToOne(targetEntity="TypeOffre", inversedBy="offres")
     * @ORM\JoinColumn(onDelete="SET NULL", nullable=true);
     */
    private $type;

    /**
     * @ORM\OneToMany(targetEntity="Reservation", mappedBy="offre")
     */
    private $reservations;

    /**
     * Get id
     *
     * @return int
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set prix
     *
     * @param float $prix
     *
     * @return Offre
     */
    public function setPrix($prix) {
        $this->prix = $prix;

        return $this;
    }

    /**
     * Get prix
     *
     * @return float
     */
    public function getPrix() {
        return $this->prix;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Offre
     */
    public function setDescription($description) {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription() {
        return $this->description;
    }

    /**
     * Set auteur
     *
     * @param \AppBundle\Entity\User $auteur
     *
     * @return Offre
     */
    public function setAuteur(\AppBundle\Entity\User $auteur = null) {
        $this->auteur = $auteur;

        return $this;
    }

    /**
     * Get auteur
     *
     * @return \AppBundle\Entity\User
     */
    public function getAuteur() {
        return $this->auteur;
    }

    /**
     * Set dateDebutValiditee
     *
     * @param \DateTime $dateDebutValiditee
     *
     * @return Offre
     */
    public function setDateDebutValiditee($dateDebutValiditee) {
        $this->dateDebutValiditee = $dateDebutValiditee;

        return $this;
    }

    /**
     * Get dateDebutValiditee
     *
     * @return \DateTime
     */
    public function getDateDebutValiditee() {
        return $this->dateDebutValiditee;
    }

    /**
     * Set dateFinValiditee
     *
     * @param \DateTime $dateFinValiditee
     *
     * @return Offre
     */
    public function setDateFinValiditee($dateFinValiditee) {
        $this->dateFinValiditee = $dateFinValiditee;

        return $this;
    }

    /**
     * Get dateFinValiditee
     *
     * @return \DateTime
     */
    public function getDateFinValiditee() {
        return $this->dateFinValiditee;
    }

    /**
     * Set adresse
     *
     * @param \AppBundle\Entity\Adresse $adresse
     *
     * @return Offre
     */
    public function setAdresse(\AppBundle\Entity\Adresse $adresse = null) {
        $this->adresse = $adresse;

        return $this;
    }

    /**
     * Get adresse
     *
     * @return \AppBundle\Entity\Adresse
     */
    public function getAdresse() {
        return $this->adresse;
    }

    /**
     * Set titre
     *
     * @param string $titre
     *
     * @return Offre
     */
    public function setTitre($titre) {
        $this->titre = $titre;

        return $this;
    }

    /**
     * Get titre
     *
     * @return string
     */
    public function getTitre() {
        return $this->titre;
    }

    /**
     * Set type
     *
     * @param \AppBundle\Entity\TypeOffre $type
     *
     * @return Offre
     */
    public function setType(\AppBundle\Entity\TypeOffre $type = null) {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return \AppBundle\Entity\TypeOffre
     */
    public function getType() {
        return $this->type;
    }

    /**
     * Constructor
     */
    public function __construct() {
        $this->reservations = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add reservation
     *
     * @param \AppBundle\Entity\Reservation $reservation
     *
     * @return Offre
     */
    public function addReservation(\AppBundle\Entity\Reservation $reservation) {
        $this->reservations[] = $reservation;

        return $this;
    }

    /**
     * Remove reservation
     *
     * @param \AppBundle\Entity\Reservation $reservation
     */
    public function removeReservation(\AppBundle\Entity\Reservation $reservation) {
        $this->reservations->removeElement($reservation);
    }

    /**
     * Get reservations
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getReservations() {
        return $this->reservations;
    }

}
