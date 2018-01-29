<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Entity
 * @ORM\Table(name="permissions")
 */
class Permissions
{
    /**
     * @var int
     *
     * @ORM\Column(name="permission_id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $permissionId;

    /**
     * @return int
     */
    public function getPermissionId()
    {
        return $this->permissionId;
    }

    /**
     * @var \AppBundle\Entity\FennecUser
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\FennecUser", cascade={"persist"}, inversedBy="permissions")
     * @ORM\JoinColumn(name="id", referencedColumnName="id", nullable=false)
     */
    private $webuser;

    /**
     * @ORM\Column(type="string")
     */
    private $permission;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\WebuserData")
     * @ORM\JoinColumn(name="webuser_data_id", referencedColumnName="webuser_data_id", nullable=false)
     */
    private $webuserData;

    /**
     * @return FennecUser
     */
    public function getWebuser()
    {
        return $this->webuser;
    }

    /**
     * @param FennecUser $webuser
     */
    public function setWebuser($webuser)
    {
        $this->webuser = $webuser;
    }

    /**
     * @return mixed
     */
    public function getPermission()
    {
        return $this->permission;
    }

    /**
     * @param mixed $permission
     */
    public function setPermission($permission)
    {
        $this->permission = $permission;
    }

    /**
     * @return mixed
     */
    public function getWebuserData()
    {
        return $this->webuserData;
    }

    /**
     * @param mixed $webuserData
     */
    public function setWebuserData($webuserData)
    {
        $this->webuserData = $webuserData;
    }


}