<?php

namespace App\Form;

use App\Entity\Commande;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CommandeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('NumCom')
            ->add('dateCom')
            ->add('total')
            ->add('observation')
            ->add('Client')
            ->add('Produit', CollectionType::class, [
                'entry_type' => ProduitType::class,
                'entry_options' => ['label' => true],
                'allow_add' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Commande::class,
        ]);
    }
}
