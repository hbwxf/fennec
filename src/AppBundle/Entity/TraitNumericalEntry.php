<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TraitNumericalEntry
 *
 * @ORM\Table(name="trait_categorical_entry", indexes={@ORM\Index(name="IDX_DDFBB816594DA73F", columns={"fennec_id"}), @ORM\Index(name="IDX_DDFBB8163B8FE7EB", columns={"trait_categorical_value_id"}), @ORM\Index(name="IDX_DDFBB81650F4882D", columns={"trait_citation_id"}), @ORM\Index(name="IDX_DDFBB816788909E7", columns={"trait_type_id"}), @ORM\Index(name="IDX_DDFBB81649279951", columns={"webuser_id"})})
 * @ORM\Entity
 */
class TraitNumericalEntry
{
    function __construct()
    {
        $this->creationDate = new \DateTime();
    }

    /**
     * @var bool
     *
     * @ORM\Column(name="private", type="boolean", nullable=false)
     */
    private $private;

    /**
     * @var string|null
     *
     * @ORM\Column(name="origin_url", type="text", nullable=true)
     */
    private $originUrl;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="creation_date", type="datetimetz", nullable=false)
     */
    private $creationDate = 'now()';

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="deletion_date", type="datetimetz", nullable=true)
     */
    private $deletionDate;

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\SequenceGenerator(sequenceName="trait_categorical_entry_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var \AppBundle\Entity\Organism
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Organism")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="fennec_id", referencedColumnName="fennec_id", nullable=false)
     * })
     */
    private $fennec;

    /**
     * @var \AppBundle\Entity\TraitNumericalValue
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\TraitNumericalValue")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="trait_categorical_value_id", referencedColumnName="id", nullable=false)
     * })
     */
    private $traitCategoricalValue;

    /**
     * @var \AppBundle\Entity\TraitCitation
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\TraitCitation")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="trait_citation_id", referencedColumnName="id")
     * })
     */
    private $traitCitation;

    /**
     * @var \AppBundle\Entity\TraitType
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\TraitType")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="trait_type_id", referencedColumnName="id", nullable=false)
     * })
     */
    private $traitType;

    /**
     * @var \AppBundle\Entity\Webuser
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Webuser")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="webuser_id", referencedColumnName="webuser_id", nullable=false)
     * })
     */
    private $webuser;



    /**
     * Set private.
     *
     * @param bool $private
     *
     * @return TraitNumericalEntry
     */
    public function setPrivate($private)
    {
        $this->private = $private;

        return $this;
    }

    /**
     * Get private.
     *
     * @return bool
     */
    public function getPrivate()
    {
        return $this->private;
    }

    /**
     * Set originUrl.
     *
     * @param string|null $originUrl
     *
     * @return TraitNumericalEntry
     */
    public function setOriginUrl($originUrl = null)
    {
        $this->originUrl = $originUrl;

        return $this;
    }

    /**
     * Get originUrl.
     *
     * @return string|null
     */
    public function getOriginUrl()
    {
        return $this->originUrl;
    }

    /**
     * Set creationDate.
     *
     * @param \DateTime $creationDate
     *
     * @return TraitNumericalEntry
     */
    public function setCreationDate($creationDate)
    {
        $this->creationDate = $creationDate;

        return $this;
    }

    /**
     * Get creationDate.
     *
     * @return \DateTime
     */
    public function getCreationDate()
    {
        return $this->creationDate;
    }

    /**
     * Set deletionDate.
     *
     * @param \DateTime|null $deletionDate
     *
     * @return TraitNumericalEntry
     */
    public function setDeletionDate($deletionDate = null)
    {
        $this->deletionDate = $deletionDate;

        return $this;
    }

    /**
     * Get deletionDate.
     *
     * @return \DateTime|null
     */
    public function getDeletionDate()
    {
        return $this->deletionDate;
    }

    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set fennec.
     *
     * @param \AppBundle\Entity\Organism|null $fennec
     *
     * @return TraitNumericalEntry
     */
    public function setFennec(\AppBundle\Entity\Organism $fennec = null)
    {
        $this->fennec = $fennec;

        return $this;
    }

    /**
     * Get fennec.
     *
     * @return \AppBundle\Entity\Organism|null
     */
    public function getFennec()
    {
        return $this->fennec;
    }

    /**
     * Set traitCategoricalValue.
     *
     * @param \AppBundle\Entity\TraitNumericalValue|null $traitCategoricalValue
     *
     * @return TraitNumericalEntry
     */
    public function setTraitNumericalValue(\AppBundle\Entity\TraitNumericalValue $traitCategoricalValue = null)
    {
        $this->traitCategoricalValue = $traitCategoricalValue;

        return $this;
    }

    /**
     * Get traitCategoricalValue.
     *
     * @return \AppBundle\Entity\TraitNumericalValue|null
     */
    public function getTraitNumericalValue()
    {
        return $this->traitCategoricalValue;
    }

    /**
     * Set traitCitation.
     *
     * @param \AppBundle\Entity\TraitCitation|null $traitCitation
     *
     * @return TraitNumericalEntry
     */
    public function setTraitCitation(\AppBundle\Entity\TraitCitation $traitCitation = null)
    {
        $this->traitCitation = $traitCitation;

        return $this;
    }

    /**
     * Get traitCitation.
     *
     * @return \AppBundle\Entity\TraitCitation|null
     */
    public function getTraitCitation()
    {
        return $this->traitCitation;
    }

    /**
     * Set traitType.
     *
     * @param \AppBundle\Entity\TraitType|null $traitType
     *
     * @return TraitNumericalEntry
     */
    public function setTraitType(\AppBundle\Entity\TraitType $traitType = null)
    {
        $this->traitType = $traitType;

        return $this;
    }

    /**
     * Get traitType.
     *
     * @return \AppBundle\Entity\TraitType|null
     */
    public function getTraitType()
    {
        return $this->traitType;
    }

    /**
     * Set webuser.
     *
     * @param \AppBundle\Entity\Webuser|null $webuser
     *
     * @return TraitNumericalEntry
     */
    public function setWebuser(\AppBundle\Entity\Webuser $webuser = null)
    {
        $this->webuser = $webuser;

        return $this;
    }

    /**
     * Get webuser.
     *
     * @return \AppBundle\Entity\Webuser|null
     */
    public function getWebuser()
    {
        return $this->webuser;
    }
}
