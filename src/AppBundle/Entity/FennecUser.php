<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as BaseUser;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\FennecUserRepository")
 * @ORM\Table(name="`fennec_user`")
 * @ORM\AttributeOverrides({
 *     @ORM\AttributeOverride(name="password",
 *          column=@ORM\Column(
 *              nullable=true
 *          ))
 *     })
 */
class FennecUser extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @return mixed
     */
    public function getGithubAccessToken()
    {
        return $this->github_access_token;
    }

    /**
     * @param mixed $github_access_token
     */
    public function setGithubAccessToken($github_access_token)
    {
        $this->github_access_token = $github_access_token;
    }

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $github_access_token;

    /**
     * @ORM\Column(type="string",nullable=true)
     */
    private $firstName;

    /**
     * @ORM\Column(type="string",nullable=true)
     */
    private $lastName;


    /**
     * @var \AppBundle\Entity\WebuserData
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\WebuserData", mappedBy="webuser")
     * @deprecated
     */
    private $data;

    /**
     * @return mixed
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * @param mixed $firstName
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
    }

    /**
     * @return mixed
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * @param mixed $lastName
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
    }

    public function getId()
    {
        return $this->id;
    }

    /**
     * Add datum.
     *
     * @param \AppBundle\Entity\WebuserData $data
     *
     * @return FennecUser
     * @deprecated
     */
    public function addData(\AppBundle\Entity\WebuserData $data)
    {
        $this->data[] = $data;

        return $this;
    }

    /**
     * Remove datum.
     *
     * @param \AppBundle\Entity\WebuserData $data
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     * @deprecated
     */
    public function removeData(\AppBundle\Entity\WebuserData $data)
    {
        return $this->data->removeElement($data);
    }

    /**
     * Get data.
     *
     * @return \Doctrine\Common\Collections\Collection
     * @deprecated
     */
    public function getData()
    {
        return $this->data;
    }
}
