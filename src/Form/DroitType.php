<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

use Doctrine\ORM\EntityRepository;

use App\Entity\Module;

use App\Entity\Droit;
use App\Repository\DroitRepository;

use App\Entity\Societe;
use App\Repository\SocieteRepository;

use Symfony\Component\OptionsResolver\OptionsResolver;
//use Sonata\AdminBundle\Form\Type\ModelType;

class DroitType extends AbstractType {

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $idConnecter = $options['idConnecter'];

        $builder
                 ->add('SocieteId', EntityType::class, [
                'class' => Societe::class,
                'choice_label' => 'RaisonSocial',
                'label' => 'Société',
                'disabled'=> true,
                ])

                ->add('lectureEcritureSuppression', ChoiceType::class, array(
                    'choices'  => array(
                        'Lecture' => 1,
                        'Modification' => 2,
                        'Suppression' => 3,
                        'Accès bloqué' => 0,
                    ),
                    'choice_attr' => [
                        'Lecture' => ['data-type' => 'lecture'],
                        'Modification' => ['data-type' => 'modification'],
                        'Suppression' => ['data-type' => 'suppression'],
                        'Accès bloqué' => ['data-type' => 'bloque'],
                    ],

                    'label' => false,
                    'choice_label' => false,
                    'multiple'=>false,
                    'expanded'=>true,
                ))

                ->add('SeulTous', CheckboxType::class, array(
                    'label' => false,
                 //   'label'    => 'Seulement son compte',
                    'required' => false,
                    'value' => false,
                ))

               /* ->add('SeulTous', ChoiceType::class, array(
                    'choices'  => array(
                        'Seulement son compte ' => 0,
                        'Tous les comptes' => 1,
                    ),
                    'label' => 'Compte',
                    'multiple'=>false,
                    'expanded'=>true,
                ))*/

                ->add('moduleID', EntityType::class, [
                    'class' => Module::class,
                    'choice_label' => 'nomModule',
                    'label' => 'Module',
                    'disabled'=> true,
                    'attr' => ['readonly' => true, 'class' => 'form-control-plaintext',],
                ])    

        ;
    }


    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'App\Entity\Droit',
            'idConnecter'  => null,
        ));
    }
}