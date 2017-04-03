<?php

namespace IIT\AllSpeakBundle\Entity;

/**
 * SurveySentence
 */
class SurveySentence
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $text;


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
     * Set text
     *
     * @param string $text
     *
     * @return SurveySentence
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
}

