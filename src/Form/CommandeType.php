<?php

namespace App\Form;

use App\Entity\Client;
use App\Entity\Commande;
use App\Entity\Produit;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CommandeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            // ->add('NumCom')
            ->add('dateCom',DateType::class,['label' => 'Date Commande:   : ','widget' => 'single_text'])
            ->add('total', TextType::class, array(
                'label' => 'Prix De Vente :'))
            ->add('observation',TextType::class, array(
                'label' => 'Observation : '))
            ->add('Client',EntityType::class, [
                'class' => Client::class,
                'choice_label' => 'name',])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Commande::class,
        ]);
    }
}
