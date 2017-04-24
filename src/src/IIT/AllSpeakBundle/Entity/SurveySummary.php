<?php

namespace IIT\AllSpeakBundle\Entity;

/**
 * SurveySummary
 */
class SurveySummary
{

    /**
     * @var int
     */
    private $answersNum;

    /**
     * @var int
     */
    private $maleRatio;

    /**
     * @var int
     */
    private $averageAge;

    /**
     * @var \DateInterval
     */
    private $averageTimeSinceDiagnosis;


    public function __construct(
        int $answersNum,
        int $maleRatio,
        int $averageAge,
        \DateInterval $averageTimeSinceDiagnosis = null
    )
    {
        $this->answersNum = $answersNum;
        $this->maleRatio = $maleRatio;
        $this->averageAge = $averageAge;
        $this->averageTimeSinceDiagnosis = $averageTimeSinceDiagnosis;
    }

    /**
     * @return int
     */
    public function getAnswersNum(): int
    {
        return $this->answersNum;
    }

    /**
     * @param int $answersNum
     * @return SurveySummary
     */
    public function setAnswersNum(int $answersNum): SurveySummary
    {
        $this->answersNum = $answersNum;
        return $this;
    }

    /**
     * @return int
     */
    public function getMaleRatio(): int
    {
        return $this->maleRatio;
    }

    /**
     * @param int $maleRatio
     * @return SurveySummary
     */
    public function setMaleRatio(int $maleRatio): SurveySummary
    {
        $this->maleRatio = $maleRatio;
        return $this;
    }

    /**
     * @return int
     */
    public function getAverageAge(): int
    {
        return $this->averageAge;
    }

    /**
     * @param int $averageAge
     * @return SurveySummary
     */
    public function setAverageAge(int $averageAge): SurveySummary
    {
        $this->averageAge = $averageAge;
        return $this;
    }

    /**
     * @return \DateInterval
     */
    public function getAverageTimeSinceDiagnosis(): \DateInterval
    {
        return $this->averageTimeSinceDiagnosis;
    }

    /**
     * @param \DateInterval $averageTimeSinceDiagnosis
     * @return SurveySummary
     */
    public function setAverageTimeSinceDiagnosis(\DateInterval $averageTimeSinceDiagnosis): SurveySummary
    {
        $this->averageTimeSinceDiagnosis = $averageTimeSinceDiagnosis;
        return $this;
    }

}

