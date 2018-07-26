<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\Civilite;
use App\Entity\Utilisateur;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Doctrine\ORM\EntityRepository;
use App\Repository\UtilisateurRepository;
//use Sonata\AdminBundle\Form\Type\ModelType;

use Symfony\Component\Security\Core\Security;


class NouveauClientType extends AbstractType {

    protected $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $idSociete = $options['idSociete'];
        $builder
                ->add('idCivilite', EntityType::class, [
                'class' => Civilite::class,
                'choice_label' => 'LibelleCivilite',
                'label' => 'Civilité',
                ])

                ->add('nomClient', TextType::class, [
                    'label' => 'Nom',
                ])
                ->add('prenomClient', TextType::class, [
                    'label' => 'Prénom', 
                    'required' => false,
                ])

                ->add('telClient', TextType::class, [
                    'label' => 'Téléphone',
                    'required' => false,
                ])
                ->add('mobileClient', TextType::class, [
                    'label' => 'Mobile',
                    'required' => false,
                ])

                ->add('emailClient', EmailType::class, [
                    'label' => 'Email', 
                    'required' => false,
                ])

                ->add('adresseClient', TextareaType::class, [
                    'label' => 'Adresse',
                    'required' => false,
                ])
                ->add('codePostalClient', TextType::class, [
                    'label' => 'Code postal',
                    'required' => false,
                ])
                ->add('villeClient', TextType::class, [
                    'label' => 'Ville',
                    'required' => false,
                ])

                ->add('paysClient', TextType::class, [
                    'label' => 'Pays',
                    'required' => false,
                ])

                ->add('siretClient', TextType::class, [
                    'label' => 'SIRET',
                    'required' => false,
                ])

                ->add('numeroTvaClient', TextType::class, [
                    'label' => 'N° TVA',
                    'required' => false,
                ])

                ->add('idUtilisateur', EntityType::class, array(
                        'class' => Utilisateur::class,
                        'query_builder' => function(UtilisateurRepository $repo)  use($idSociete) {
                        return $repo->getUtilisateurForm($idSociete);
                        },
                        'label' => 'Commercial',
                        'choice_label' => 'NomUtilisateur',
                        'by_reference'=> false,
                        'multiple' => false,
                        'required' => true,
                    ))

                ->add('notesClient', TextareaType::class, [
                    'label' => 'Notes',
                    'required' => false,
                ])

                
/*
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
                ;
                $builder->add('submit', SubmitType::class, ['label'=>'Suivant', 'attr'=>['class'=>'btn-primary btn-block']])
        ;
    }

    public function configureOptions(OptionsResolver $resolver) {
    $resolver->setDefaults(array(
        'idSociete'  => null
    ));
}
}