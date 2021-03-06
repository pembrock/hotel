<?php

namespace Login\LoginBundle\Entity;

/**
 * Promo
 */
class Promo
{
    /**
     * @var string
     */
    private $title = '0';

    /**
     * @var string
     */
    private $text;

    /**
     * @var \DateTime
     */
    private $startTs = 'CURRENT_TIMESTAMP';

    /**
     * @var \DateTime
     */
    private $stopTs = '0000-00-00 00:00:00';

    /**
     * @var boolean
     */
    private $isactive = '0';

    /**
     * @var integer
     */
    private $id;


    /**
     * Set title
     *
     * @param string $title
     *
     * @return Promo
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set text
     *
     * @param string $text
     *
     * @return Promo
     */
    public function setText($text)
    {
        $this->text = $text;

        return $this;
    }

    /**
     * Get text
     *
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * Set startTs
     *
     * @param \DateTime $startTs
     *
     * @return Promo
     */
    public function setStartTs($startTs)
    {
        $this->startTs = $startTs;

        return $this;
    }

    /**
     * Get startTs
     *
     * @return \DateTime
     */
    public function getStartTs()
    {
        return $this->startTs;
    }

    /**
     * Set stopTs
     *
     * @param \DateTime $stopTs
     *
     * @return Promo
     */
    public function setStopTs($stopTs)
    {
        $this->stopTs = $stopTs;

        return $this;
    }

    /**
     * Get stopTs
     *
     * @return \DateTime
     */
    public function getStopTs()
    {
        return $this->stopTs;
    }

    /**
     * Set isactive
     *
     * @param boolean $isactive
     *
     * @return Promo
     */
    public function setIsactive($isactive)
    {
        $this->isactive = $isactive;

        return $this;
    }

    /**
     * Get isactive
     *
     * @return boolean
     */
    public function getIsactive()
    {
        return $this->isactive;
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
