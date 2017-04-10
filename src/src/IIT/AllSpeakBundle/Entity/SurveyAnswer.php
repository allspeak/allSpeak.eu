<?php

namespace IIT\AllSpeakBundle\Entity;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * SurveyAnswer
 */
class SurveyAnswer
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var \DateTime
     */
    private $ts;

    /**
     * @var string
     */
    private $gender;

    /**
     * @var int
     */
    private $birthYear;

    /**
     * @var int
     */
    private $diagnosisYear;

    /**
     * @var int
     */
    private $alsfrsr;

    /**
     * @var int
     */
    private $verbalScore;

    /**
     * @var string
     */
    private $diagnosis;

    /**
     * @var \Doctrine\ORM\ArrayCollection
     */
    private $sentences;


    public function __construct()
    {
        $this->setTs(new \DateTime());
    }


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
     * Set ts
     *
     * @param \DateTime $ts
     *
     * @return SurveyAnswer
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

    /**
     * Set gender
     *
     * @param string $gender
     *
     * @return SurveyAnswer
     */
    public function setGender($gender)
    {
        $this->gender = $gender;

        return $this;
    }

    /**
     * Get gender
     *
     * @return string
     */
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * Set birthYear
     *
     * @param integer $birthYear
     *
     * @return SurveyAnswer
     */
    public function setBirthYear($birthYear)
    {
        $this->birthYear = $birthYear;

        return $this;
    }

    /**
     * Get birthYear
     *
     * @return int
     */
    public function getBirthYear()
    {
        return $this->birthYear;
    }

    /**
     * Set diagnosisYear
     *
     * @param integer $diagnosisYear
     *
     * @return SurveyAnswer
     */
    public function setDiagnosisYear($diagnosisYear)
    {
        $this->diagnosisYear = $diagnosisYear;

        return $this;
    }

    /**
     * Get diagnosisYear
     *
     * @return int
     */
    public function getDiagnosisYear()
    {
        return $this->diagnosisYear;
    }

    /**
     * Set alsfrsr
     *
     * @param integer $alsfrsr
     *
     * @return SurveyAnswer
     */
    public function setAlsfrsr($alsfrsr)
    {
        $this->alsfrsr = $alsfrsr;

        return $this;
    }

    /**
     * Get alsfrsr
     *
     * @return int
     */
    public function getAlsfrsr()
    {
        return $this->alsfrsr;
    }

    /**
     * Set verbalScore
     *
     * @param integer $verbalScore
     *
     * @return SurveyAnswer
     */
    public function setVerbalScore($verbalScore)
    {
        $this->verbalScore = $verbalScore;

        return $this;
    }

    /**
     * Get verbalScore
     *
     * @return int
     */
    public function getVerbalScore()
    {
        return $this->verbalScore;
    }

    /**
     * Set diagnosis
     *
     * @param string $diagnosis
     *
     * @return SurveyAnswer
     */
    public function setDiagnosis($diagnosis)
    {
        $this->diagnosis = $diagnosis;

        return $this;
    }

    /**
     * Get diagnosis
     *
     * @return string
     */
    public function getDiagnosis()
    {
        return $this->diagnosis;
    }

    /**
     * Set sentences
     *
     * @param \Doctrine\ORM\ArrayCollection
     *
     * @return SurveyAnswer
     */
    public function setSentences(ArrayCollection $sentences)
    {
        $this->sentences = $sentences;

        return $this;
    }

    /**
     * Get sentences
     *
     * @return \Doctrine\ORM\ArrayCollection
     */
    public function getSentences()
    {
        return $this->sentences;
    }
}

