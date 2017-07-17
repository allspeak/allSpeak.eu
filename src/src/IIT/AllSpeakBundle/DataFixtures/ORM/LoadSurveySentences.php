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

        $itSentences = [
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
        $enSentences = [
            "I'm hungry",
            "I'm thirsty",
            "I'm sleepy",
            "I'm hot",
            "I'm cold",
            "I need to go to the toilet",
            "I'm sore",
            "Hello",
            "How are you?",
            "How is ...?",
            "See you tomorrow",
            "Call ...",
            "Say hello to ...",
            "I love you",
            "Too much saliva",
            "I'd like to take a shower",
            "Thanks",
            "You are welcome",
            "I'm angry",
            "I'm sad",
            "It's all right",
            "Hand me the phone",
            "I want to be alone"
        ];
        foreach ($itSentences as $i => $itS) {
            $enS = $enSentences[$i];
            $surveySentence = new SurveySentence();
            $surveySentence->setItText($itS);
            $surveySentence->setenText($enS);
            $manager->persist($surveySentence);
        };

        $manager->flush();
    }
}