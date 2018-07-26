<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\Civilite;
//use Sonata\AdminBundle\Form\Type\ModelType;


class EditerMdpUtilisateurType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('idCivilite', EntityType::class, [
                'class' => Civilite::class,
                'choice_label' => 'LibelleCivilite',
                'label' => 'Civilité',
                'disabled' => true,
                'required' => false,
                ])

                ->add('NomUtilisateur', TextType::class, [
                        'label' => 'Nom',
                        'disabled' => true,
                    'required' => false,
                ])
                ->add('PrenomUtilisateur', TextType::class, [
                    'label' => 'Prénom',
                    'disabled' => true,
                    'required' => false,
                ])
                ->add('TelUtilisateur', TextType::class, [
                    'label' => 'Téléphone',
                    'disabled' => true,
                    'required' => false,
                ])
                ->add('MobileUtilisateur', TextType::class, [
                    'label' => 'Mobile',
                    'disabled' => true,
                    'required' => false,
                ])

                ->add('EmailUtilisateur', EmailType::class, [
                    'label' => 'Email',
                    'disabled' => true,
                    'required' => false,
                ])

                ->add('loginUtilisateur', TextType::class, [
                    'label' => 'Nom d\'utilisateur',
                    'disabled' => true,
                    'required' => false,
                ])

                ->add('mdpUtilisateur', RepeatedType::class, array(
                    'type' => PasswordType::class,
                    'first_options' => array('label' => 'Mot de passe'),
                    'second_options' => array('label' => 'Confirmation du mot de passe'),
                ))
                ->add('submit', SubmitType::class, ['label'=>'Modifier', 'attr'=>['class'=>'btn-primary btn-block']])
        ;
    }
}