<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as BaseUser;

/**
 * User
 *
 * @ORM\Table(name="user")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UserRepository")
 */
class User extends BaseUser {

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="facebook_id", type="string", length=255, nullable=true)
     */
    private $facebookId;

    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=255, nullable=true)
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="prenom", type="string", length=255, nullable=true)
     */
    private $prenom;

    /**
     * @var string
     *
     * @ORM\Column(name="phonenumber", type="string", length=255, nullable=true)
     */
    private $phonenumber;

    /**
     * @ORM\ManyToOne(targetEntity="TypeUser", inversedBy="users")
     * @ORM\JoinColumn(onDelete="SET NULL", nullable=true);
     */
    private $type;

    /**
     * @ORM\ManyToOne(targetEntity="Vehicule", inversedBy="users")
     * @ORM\JoinColumn(onDelete="SET NULL", nullable=true);
     */
    private $vehicule;

    /**
     * @ORM\OneToMany(targetEntity="Offre", mappedBy="auteur")
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
     * @return User
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
     * Set prenom
     *
     * @param string $prenom
     *
     * @return User
     */
    public function setPrenom($prenom) {
        $this->prenom = $prenom;

        return $this;
    }

    /**
     * Get prenom
     *
     * @return string
     */
    public function getPrenom() {
        return $this->prenom;
    }

    /**
     * Set phonenumber
     *
     * @param string $phonenumber
     *
     * @return User
     */
    public function setPhonenumber($phonenumber) {
        $this->phonenumber = $phonenumber;

        return $this;
    }

    /**
     * Get phonenumber
     *
     * @return string
     */
    public function getPhonenumber() {
        return $this->phonenumber;
    }

    /**
     * Set type
     *
     * @param \AppBundle\Entity\TypeUser $type
     *
     * @return User
     */
    public function setType(\AppBundle\Entity\TypeUser $type = null) {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return \AppBundle\Entity\TypeUser
     */
    public function getType() {
        return $this->type;
    }

    /**
     * Set vehicule
     *
     * @param \AppBundle\Entity\Vehicule $vehicule
     *
     * @return User
     */
    public function setVehicule(\AppBundle\Entity\Vehicule $vehicule = null) {
        $this->vehicule = $vehicule;

        return $this;
    }

    /**
     * Get vehicule
     *
     * @return \AppBundle\Entity\Vehicule
     */
    public function getVehicule() {
        return $this->vehicule;
    }

    /**
     * Add offre
     *
     * @param \AppBundle\Entity\Offre $offre
     *
     * @return User
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
     * Set facebookId
     *
     * @param string $facebookId
     *
     * @return User
     */
    public function setFacebookId($facebookId) {
        $this->facebookId = $facebookId;

        return $this;
    }

    /**
     * Get facebookId
     *
     * @return string
     */
    public function getFacebookId() {
        return $this->facebookId;
    }

}
