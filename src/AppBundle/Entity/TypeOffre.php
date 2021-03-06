<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TypeOffre
 *
 * @ORM\Table(name="type_offre")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\TypeOffreRepository")
 */
class TypeOffre {

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=255, unique=true)
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="marker", type="string", length=255)
     */
    private $marker;
    
    /**
     * @ORM\OneToMany(targetEntity="Offre", mappedBy="type")
     * @ORM\JoinColumn(onDelete="SET NULL");
     */
    private $offres;

    /**
     * Get id
     *
     * @return int
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set nom
     *
     * @param string $nom
     *
     * @return TypeOffre
     */
    public function setNom($nom) {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get nom
     *
     * @return string
     */
    public function getNom() {
        return $this->nom;
    }

    /**
     * Constructor
     */
    public function __construct() {
        $this->offres = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add offre
     *
     * @param \AppBundle\Entity\Offre $offre
     *
     * @return TypeOffre
     */
    public function addOffre(\AppBundle\Entity\Offre $offre) {
        $this->offres[] = $offre;

        return $this;
    }

    /**
     * Remove offre
     *
     * @param \AppBundle\Entity\Offre $offre
     */
    public function removeOffre(\AppBundle\Entity\Offre $offre) {
        $this->offres->removeElement($offre);
    }

    /**
     * Get offres
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getOffres() {
        return $this->offres;
    }


    /**
     * Set marker
     *
     * @param string $marker
     *
     * @return TypeOffre
     */
    public function setMarker($marker)
    {
        $this->marker = $marker;

        return $this;
    }

    /**
     * Get marker
     *
     * @return string
     */
    public function getMarker()
    {
        return $this->marker;
    }
}
