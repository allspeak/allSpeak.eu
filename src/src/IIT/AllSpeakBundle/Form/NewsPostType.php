<?php

namespace IIT\AllSpeakBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\DateTime;

class NewsPostType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('itText', TextareaType::class, ['label' => 'NewsPost.itText', 'required' => false])
            ->add('enText', TextareaType::class, ['label' => 'NewsPost.enText', 'required' => false])
            ->add('link', TextType::class, ['label' => 'NewsPost.link', 'required' => false])
            ->add('ts', DateTimeType::class, ['label' => 'NewsPost.ts']);
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'IIT\AllSpeakBundle\Entity\NewsPost'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'iit_allspeakbundle_newspost';
    }


}
