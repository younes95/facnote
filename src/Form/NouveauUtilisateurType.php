<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\Civilite;
use App\Entity\Societe;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Doctrine\ORM\EntityRepository;
use App\Repository\SocieteRepository;
//use Sonata\AdminBundle\Form\Type\ModelType;

use Symfony\Component\Security\Core\Security;


class NouveauUtilisateurType extends AbstractType {

    protected $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $idConnecter = $options['idConnecter'];
        $builder
                ->add('idCivilite', EntityType::class, [
                'class' => Civilite::class,
                'choice_label' => 'LibelleCivilite',
                'label' => 'Civilité',
                ])

                ->add('NomUtilisateur', TextType::class, [
                    'label' => 'Nom',
                ])
                ->add('PrenomUtilisateur', TextType::class, ['label' => 'Prénom', 'required' => false,])
                ->add('TelUtilisateur', TextType::class, [
                    'label' => 'Téléphone',
                    'required' => false,
                ])
                ->add('MobileUtilisateur', TextType::class, [
                    'label' => 'Mobile',
                    'required' => false,
                ])

                ->add('EmailUtilisateur', EmailType::class, ['label' => 'Email', 'required' => false,])

                ->add('urlPhoto', FileType::class, array(
                    'label' => 'Photo',
                    'required' => false,
                    'data_class' => null,

                ))

                ->add('loginUtilisateur', TextType::class, ['label' => 'Nom d\'utilisateur'])

                ->add('mdpUtilisateur', RepeatedType::class, array(
                    'type' => PasswordType::class,
                    'first_options' => array('label' => 'Mot de passe'),
                    'second_options' => array('label' => 'Confirmation du mot de passe'),
                ));

/*                ->add('societes', EntityType::class, array(
                        'class' => Societe::class,
                        'query_builder' => function(SocieteRepository $repo)  use($idConnecter) {
                        return $repo->getSocieteForm( $idConnecter);
                        },
                        'label' => 'Société',
                        'choice_label' => 'RaisonSocial',
                        'by_reference'=> false,
                        'multiple' => true,
                        'required' => true,
                    ));

                if ($this->security->isGranted('ROLE_GERANT')) {

                    $builder->add('roles', ChoiceType::class, array(
                        'attr' => array(
                            'class' => 'form-control',
                            'value' => 'ROLE_USER',
                            'required' => false,
                        ),
                        'multiple' => true,
                        'choices' => [
                            'Utilisateur' => 'ROLE_USER',
                            'Affichage' => 'ROLE_AFFICHAGE',
                            'Affichage, Edition' => 'ROLE_EDITION',
                            'Affichage, Edition, Suppression' => 'ROLE_SUPPRESSION',
                            'Gérant' => 'ROLE_GERANT',
                            'Comptable' => 'ROLE_COMPTABLE',
                            'Admin FACNOTE' => 'ROLE_ADMIN',
                        ]
                    ));
                }*/
                $builder->add('submit', SubmitType::class, ['label'=>'Suivant', 'attr'=>['class'=>'btn-primary btn-block']])
        ;
    }

    public function configureOptions(OptionsResolver $resolver) {
    $resolver->setDefaults(array(
        'idConnecter'  => null
    ));
}
}