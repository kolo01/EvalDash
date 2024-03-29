<?php

namespace App\Form;

use App\Entity\LigneCommande;
use App\Entity\Produit;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LigneCommandeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            // ->add('Numc')
            ->add('PrixVente',NumberType::class,[
                'required'   => true,


            ])
            ->add('quantite',NumberType::class,[
                'data'=> 1,
                'attr' => [
                    'onchange'=>"calculate(this)"
                 ],
            ])
            ->add('Produit', EntityType::class, [
                'class' => Produit::class,
                'choice_label' => 'libelle',
                'required' => true,
                'attr' => ['class' => 'ProduitClass',
                    'onchange'=>"myFunction(this)"
                 ],
                'choice_attr' => function (Produit $produit) {
                    return ['data-prix' => $produit->getPv()];
                },

            ]);
            
           
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => LigneCommande::class,
        ]);
    }
}
