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
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

use App\Entity\TypeSociete;

class EditSocieteType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
              
                ->add('idTypeSociete', EntityType::class, [
                'class' => TypeSociete::class,
                'choice_label' => 'nomTypeSociete',
                'label' => 'Type',
                ])
                ->add('RaisonSocial', TextType::class, ['label' => 'Raison social'])
                ->add('AdresseSociete', TextareaType::class, ['label' => 'Adresse', 'required' => false,])
                ->add('CodePostalSociete', TextType::class, ['label' => 'Code postal', 'required' => false,])
                ->add('Ville', TextType::class, ['label' => 'Ville', 'required' => false,])
                ->add('Pays', TextType::class, [
                    'label' => 'Pays',
                    'required' => false,
                ])
                ->add('TelSociete', TextType::class, [
                    'label' => 'Téléphone',
                    'required' => false,
                ])
                ->add('MobileSociete', TextType::class, ['label' => 'Mobile', 'required' => false,])
                ->add('EmailSociete', EmailType::class, ['label' => 'Email', 'required' => false,])
                ->add('SIRETSociete', TextType::class, [
                    'label' => 'SIRET',
                    'required' => false,
                ])
                ->add('RCSociete', TextType::class, ['label' => 'R.C.S', 'required' => false,])
                ->add('NumTVASociete', TextType::class, [
                    'label' => 'Numéro de TVA',
                    'required' => false,
                ])
                ->add('logoSociete', FileType::class, array(
                    'label' => 'Logo',
                    'required' => false,
                    'data_class' => null,

                ))

                
                ->add('submit', SubmitType::class, ['label'=>'Modifier', 'attr'=>['class'=>'btn-primary btn-block']])
        ;
    }
}