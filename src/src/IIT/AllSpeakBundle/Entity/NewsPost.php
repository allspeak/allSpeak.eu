<?php

namespace IIT\AllSpeakBundle\Entity;

/**
 * NewsPost
 */
class NewsPost
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $itText;

    /**
     * @var string
     */
    private $enText;

    /**
     * @var string
     */
    private $link;

    /**
     * @var \DateTime
     */
    private $ts;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set itText
     *
     * @param string $itText
     *
     * @return NewsPost
     */
    public function setItText($itText)
    {
        $this->itText = $itText;

        return $this;
    }

    /**
     * Get itText
     *
     * @return string
     */
    public function getItText()
    {
        return $this->itText;
    }

    /**
     * Set enText
     *
     * @param string $enText
     *
     * @return NewsPost
     */
    public function setEnText($enText)
    {
        $this->enText = $enText;

        return $this;
    }

    /**
     * Get enText
     *
     * @return string
     */
    public function getEnText()
    {
        return $this->enText;
    }

    /**
     * Set link
     *
     * @param string $link
     *
     * @return NewsPost
     */
    public function setLink($link)
    {
        $this->link = $link;

        return $this;
    }

    /**
     * Get link
     *
     * @return string
     */
    public function getLink()
    {
        return $this->link;
    }

    /**
     * Set ts
     *
     * @param \DateTime $ts
     *
     * @return NewsPost
     */
    public function setTs($ts)
    {
        $this->ts = $ts;

        return $this;
    }

    /**
     * Get ts
     *
     * @return \DateTime
     */
    public function getTs()
    {
        return $this->ts;
    }
}

