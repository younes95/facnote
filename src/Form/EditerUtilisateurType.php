<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\Civilite;
use App\Entity\Societe;
use Doctrine\ORM\EntityRepository;
use App\Repository\SocieteRepository;
use Symfony\Component\OptionsResolver\OptionsResolver;
//use Sonata\AdminBundle\Form\Type\ModelType;
use Symfony\Component\Security\Core\Security;

class EditerUtilisateurType extends AbstractType {

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

                ->add('NomUtilisateur', TextType::class, ['label' => 'Nom', 'required' => false,])
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

                ->add('loginUtilisateur', TextType::class, ['label' => 'Nom d\'utilisateur']);

                
                $builder->add('submit', SubmitType::class, ['label'=>'Suivant', 'attr'=>['class'=>'btn-primary btn-block']])
        ;
    }


    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(array(
            'idConnecter'  => null
        ));
    }
}