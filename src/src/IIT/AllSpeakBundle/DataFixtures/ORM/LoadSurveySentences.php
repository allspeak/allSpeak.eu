<?php

namespace IIT\AllSpeakBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use IIT\AllSpeakBundle\Entity\SurveySentence;

class LoadSurveySentences implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {

        $sentencesRepository = $manager->getRepository('IITAllSpeakBundle:SurveySentence');
        $surveySentencesCount = $sentencesRepository->count();
        if ($surveySentencesCount > 0)
            return;

        $sentences = [
            'Ho fame',
            'Ho sete',
            'Ho sonno',
            'Ho caldo',
            'Ho freddo',
            'Devo andare in bagno',
            'Ho dolore',
            'Ciao',
            'Come stai?',
            'Come sta...?',
            'Ci vediamo domani',
            'Chiama ...',
            'Salutami ...',
            'Ti voglio bene',
            'Ho troppa saliva',
            'Ho bisogno di lavarmi',
            'Grazie',
            'Prego',
            'Sono arrabbiato',
            'Sono triste',
            'Tutto bene',
            'Passami il telefono',
            'Voglio stare solo'
        ];
        foreach ($sentences as $s) {
            $surveySentence = new SurveySentence();
            $surveySentence->setText($s);
            $manager->persist($surveySentence);
        };

        $manager->flush();
    }
}