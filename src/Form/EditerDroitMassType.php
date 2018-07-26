<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

use Doctrine\ORM\EntityRepository;

use App\Form\DroitMassType;

use Symfony\Component\OptionsResolver\OptionsResolver;
//use Sonata\AdminBundle\Form\Type\ModelType;

class EditerDroitMassType extends AbstractType {

   

    public function buildForm(FormBuilderInterface $builder, array $options) {

        $builder
                

              ->add('modules', CollectionType::class, array(
          'entry_type' => DroitMassType::class));

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => null
        ));
    }
 
    public function getName()
    {
        return 'droit_mass_container_type';
    }

}