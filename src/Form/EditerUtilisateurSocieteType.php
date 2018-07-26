<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use App\Entity\Utilisateur;
use Doctrine\ORM\EntityRepository;
use App\Repository\UtilisateurRepository;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EditerUtilisateurSocieteType extends AbstractType {

    
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $idSociete = $options['idSociete'];
        $idGerant = $options['idGerant'];
        $builder

                 ->add('logoSociete', HiddenType::class, ['data'=>'',])

                 ->add('utilisateurs', EntityType::class, array(
                        'class' => Utilisateur::class,
                        'query_builder' => function(UtilisateurRepository $repo)  use($idGerant) {
                        return $repo->getUtilisateurFils( $idGerant);
                        },
                        'label' => 'Séléctionnez les utilisateurs pour cette société',
                        'choice_label' => 'loginUtilisateur',
                        'by_reference'=> false,
                        'multiple' => true,
                        'expanded' => true,
                    ));


                $builder->add('submit', SubmitType::class, ['label'=>'Suivant', 'attr'=>['class'=>'btn-primary btn-block']])
        ;
    }


    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(array(
            'idSociete'  => null,
            'idGerant' => null,
        ));
    }
}