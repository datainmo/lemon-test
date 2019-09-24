<?php

namespace App\Form;

use App\Entity\Person;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PersonType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('lastname', TextType::class,[
                'attr' => array(
                    'placeholder' => 'Nom'
                ),
                'label' => false
            ])
            ->add('firstname', TextType::class,[
                'attr' => array(
                    'placeholder' => 'Prénom'
                ),
                'label' => false
                ])
            ->add('birthDate', DateType::class,[
                'label' => false,
            ])
            ->add('email', EmailType::class,[
                'attr' => array(
                        'placeholder' => 'Email'
                    ),
                'label' => false
                ])
            ->add('gender', ChoiceType::class, [
                    'choices' => $this->getChoices(Person::GENDER),
                'placeholder' => 'Sexe',
                    'label' => false
                ])
            ->add('jobTitle',ChoiceType::class, [
                'choices' => $this->getChoices(Person::JOB),
                'placeholder' => 'Métier',
                'label' => false
                ])
            ->add('nationality', CountryType::class, [
                'placeholder' => 'Pays',
                'label' => false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Person::class,
            'translation_domain' => 'forms'
        ]);
    }

    private function getChoices($field)
    {
        $choices = $field;
        $output = [];
        foreach ($choices as $k => $v){
            $output[$v] = $k;
        }
        return $output;
    }
}
