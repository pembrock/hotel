<?php

namespace Login\LoginBundle\Entity;

/**
 * Role
 */
class Role
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $descr;

    /**
     * @var boolean
     */
    private $isEnabled = '0';

    /**
     * @var boolean
     */
    private $isDeleted = '0';

    /**
     * @var string
     */
    private $sys;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set name
     *
     * @param string $name
     *
     * @return Role
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set descr
     *
     * @param string $descr
     *
     * @return Role
     */
    public function setDescr($descr)
    {
        $this->descr = $descr;

        return $this;
    }

    /**
     * Get descr
     *
     * @return string
     */
    public function getDescr()
    {
        return $this->descr;
    }

    /**
     * Set isEnabled
     *
     * @param boolean $isEnabled
     *
     * @return Role
     */
    public function setIsEnabled($isEnabled)
    {
        $this->isEnabled = $isEnabled;

        return $this;
    }

    /**
     * Get isEnabled
     *
     * @return boolean
     */
    public function getIsEnabled()
    {
        return $this->isEnabled;
    }

    /**
     * Set isDeleted
     *
     * @param boolean $isDeleted
     *
     * @return Role
     */
    public function setIsDeleted($isDeleted)
    {
        $this->isDeleted = $isDeleted;

        return $this;
    }

    /**
     * Get isDeleted
     *
     * @return boolean
     */
    public function getIsDeleted()
    {
        return $this->isDeleted;
    }

    /**
     * Set sys
     *
     * @param string $sys
     *
     * @return Role
     */
    public function setSys($sys)
    {
        $this->sys = $sys;

        return $this;
    }

    /**
     * Get sys
     *
     * @return string
     */
    public function getSys()
    {
        return $this->sys;
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }
}

