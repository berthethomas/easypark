<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Adresse
 *
 * @ORM\Table(name="adresse")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\AdresseRepository")
 */
class Adresse {

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
     * @ORM\Column(name="numero", type="string", length=255, nullable=true)
     */
    private $numero;

    /**
     * @var string
     *
     * @ORM\Column(name="nomRue", type="string", length=255, nullable=true)
     */
    private $nomRue;

    /**
     * @var string
     *
     * @ORM\Column(name="lieuDit", type="string", length=255, nullable=true)
     */
    private $lieuDit;

    /**
     * @var string
     *
     * @ORM\Column(name="codePostal", type="string", length=255)
     */
    private $codePostal;

    /**
     * @var string
     *
     * @ORM\Column(name="ville", type="string", length=255)
     */
    private $ville;

    /**
     * @var string
     *
     * @ORM\Column(name="latitude", type="string", length=255, nullable=true)
     */
    private $latitude;

    /**
     * @var string
     *
     * @ORM\Column(name="longitude", type="string", length=255, nullable=true)
     */
    private $longitude;

    /**
     * @ORM\OneToOne(targetEntity="Offre", inversedBy="adresse", cascade={"persist"})
     * @ORM\JoinColumn(onDelete="CASCADE");
     */
    private $offre;

    /**
     * Get id
     *
     * @return int
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set numero
     *
     * @param string $numero
     *
     * @return Adresse
     */
    public function setNumero($numero) {
        $this->numero = $numero;

        return $this;
    }

    /**
     * Get numero
     *
     * @return string
     */
    public function getNumero() {
        return $this->numero;
    }

    /**
     * Set nomRue
     *
     * @param string $nomRue
     *
     * @return Adresse
     */
    public function setNomRue($nomRue) {
        $this->nomRue = $nomRue;

        return $this;
    }

    /**
     * Get nomRue
     *
     * @return string
     */
    public function getNomRue() {
        return $this->nomRue;
    }

    /**
     * Set lieuDit
     *
     * @param string $lieuDit
     *
     * @return Adresse
     */
    public function setLieuDit($lieuDit) {
        $this->lieuDit = $lieuDit;

        return $this;
    }

    /**
     * Get lieuDit
     *
     * @return string
     */
    public function getLieuDit() {
        return $this->lieuDit;
    }

    /**
     * Set codePostal
     *
     * @param string $codePostal
     *
     * @return Adresse
     */
    public function setCodePostal($codePostal) {
        $this->codePostal = $codePostal;

        return $this;
    }

    /**
     * Get codePostal
     *
     * @return string
     */
    public function getCodePostal() {
        return $this->codePostal;
    }

    /**
     * Set ville
     *
     * @param string $ville
     *
     * @return Adresse
     */
    public function setVille($ville) {
        $this->ville = $ville;

        return $this;
    }

    /**
     * Get ville
     *
     * @return string
     */
    public function getVille() {
        return $this->ville;
    }

    /**
     * Set latitude
     *
     * @param string $latitude
     *
     * @return Adresse
     */
    public function setLatitude($latitude) {
        $this->latitude = $latitude;

        return $this;
    }

    /**
     * Get latitude
     *
     * @return string
     */
    public function getLatitude() {
        return $this->latitude;
    }

    /**
     * Set longitude
     *
     * @param string $longitude
     *
     * @return Adresse
     */
    public function setLongitude($longitude) {
        $this->longitude = $longitude;

        return $this;
    }

    /**
     * Get longitude
     *
     * @return string
     */
    public function getLongitude() {
        return $this->longitude;
    }

    /**
     * Set offre
     *
     * @param \AppBundle\Entity\Offre $offre
     *
     * @return Adresse
     */
    public function setOffre(\AppBundle\Entity\Offre $offre = null) {
        $this->offre = $offre;

        return $this;
    }

    /**
     * Get offre
     *
     * @return \AppBundle\Entity\Offre
     */
    public function getOffre() {
        return $this->offre;
    }

    public function getParsedAdresse() {
        return str_replace(" ", "+", urlencode($this->numero . "+" . $this->nomRue . "+" . $this->lieuDit . "+" . $this->codePostal . "+" . $this->ville));
    }

    public function getFormatedAdresse() {
        return $this->numero . " " . $this->nomRue . " " . $this->lieuDit . " " . $this->codePostal . " " . $this->ville;
    }

}
