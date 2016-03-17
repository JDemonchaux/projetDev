<?php

namespace JavaLeEET\UtilisateurBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class SignatureType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('signature', 'file')
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'JavaLeEET\UtilisateurBundle\Document\Signature'
        ));
    }

    public function getName()
    {
        return 'javaleeet_utilisateurbundle_signaturetype';
    }
}
