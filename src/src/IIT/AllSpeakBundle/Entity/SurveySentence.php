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
    private $itText;


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
     * @param string $itText
     *
     * @return SurveySentence
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
}

