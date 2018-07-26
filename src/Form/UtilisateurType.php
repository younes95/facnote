<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
//use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\Civilite;
//use Sonata\AdminBundle\Form\Type\ModelType;


class UtilisateurType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('idCivilite', EntityType::class, [
                'class' => Civilite::class,
                'choice_label' => 'LibelleCivilite',
                'label' => 'Civilité',
                ])

                ->add('NomUtilisateur', TextType::class, ['label' => 'Nom'])
                ->add('PrenomUtilisateur', TextType::class, ['label' => 'Prénom'])
                ->add('TelUtilisateur', TextType::class, [
                    'label' => 'Téléphone',
                    'required' => false,
                ])
                ->add('MobileUtilisateur', TextType::class, ['label' => 'Mobile'])

             /*   ->add('urlPhoto', FileType::class, array(
                    'label' => 'Photo',
                    'required' => false,
                    'data_class' => null,

                ))*/

                ->add('EmailUtilisateur', EmailType::class, ['label' => 'Email'])

                ->add('loginUtilisateur', TextType::class, ['label' => 'Nom d\'utilisateur'])

                ->add('mdpUtilisateur', RepeatedType::class, array(
                    'type' => PasswordType::class,
                    'first_options' => array('label' => 'Mot de passe'),
                    'second_options' => array('label' => 'Confirmation du mot de passe'),
                ))

                
                ->add('submit', SubmitType::class, ['label'=>'Envoyer', 'attr'=>['class'=>'btn-primary btn-block']])
        ;
    }
}