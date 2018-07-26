<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use App\Entity\Societe;
use Doctrine\ORM\EntityRepository;
use App\Repository\SocieteRepository;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EditerSocieteUtilisateurType extends AbstractType {

    
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $idConnecter = $options['idConnecter'];
        $builder

                ->add('urlPhoto', HiddenType::class, ['data'=>'',])
               

                 ->add('societes', EntityType::class, array(
                        'class' => Societe::class,
                        'query_builder' => function(SocieteRepository $repo)  use($idConnecter) {
                        return $repo->getSocieteForm( $idConnecter);
                        },
                        'label' => 'Société',
                        'choice_label' => 'RaisonSocial',
                        'by_reference'=> false,
                        'multiple' => true,
                        'expanded' => true,
                    ));


                $builder->add('submit', SubmitType::class, ['label'=>'Suivant', 'attr'=>['class'=>'btn-primary btn-block']])
        ;
    }


    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(array(
            'idConnecter'  => null,
            'attr' => ['id' => 'societecheckbox']
        ));
    }
}