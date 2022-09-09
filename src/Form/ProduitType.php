<?php

namespace App\Form;

use App\Entity\Categorie;
use App\Entity\Matiere;
use App\Entity\Produit;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class ProduitType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {

        /**
         * un eleme,nt formulaiter est un form_row()
         * - form_label()
         * - form_errors()
         * - form_widget()
         * - form_help()
         */
        $builder
        ->add('titre', TextType::class, [
            "label" => 'Titre produit',
            "required" => false,
            "attr" => [
                "placeholder" => "saisir le titre du produit",
                "class" => "border border-danger border-2 rounded"

            ],
            "help" => "5 caractères minimum",
            "label_attr" => [
                "id" => "label_titre",
                "class" => "text-succes"

            ],
            "help_attr" => [
                "class" => "text-warning"
            ],
            'row_attr' => [
                "class" => "shadow p-2"
            ],
            // [
            //     'constraints' =>
            //         new NotBlank([
            //             'message' => '5 caractères max'
            //         ]),
            //         new Length([
            //             'min' => 5,
            //             'max' => 40
            //         ])
            // ]

        ] )

        ->add('prix', MoneyType::class,[
            "currency" => "USD",
            "label" => "Prix en $",
            "required" => false,
            "attr" => [
                "placeholder" => "saisir le prix",
                "class" => "border border-danger border-2 rounded"

            ],
            "help" => "5 caractères minimum",
            "label_attr" => [
                "id" => "label_titre",
                "class" => "text-succes"

            ],
            "help_attr" => [
                "class" => "text-warning"
            ],
            'row_attr' => [
                "class" => "shadow p-2"
            ]

        ] )
        ->add('description', TextType::class, [
            "label" => "Description (facultative)",
            "required" => false,
            "attr" => [
                "placeholder" => "Saisir la description",
                "class" => "border border-danger border-2 rounded",
                "rows" => 5
            ],
            "help" => "200 caractères minimum",
            "label_attr" => [
                "id" => "label_titre",
                "class" => "text-succes"

            ],
            "help_attr" => [
                "class" => "text-warning"
            ],
            'row_attr' => [
                "class" => "shadow p-2"
            ]

        ] )
        ->add('relation', EntityType::class, [// element est un relationj avec une autre entity
                "class" => Categorie::class,    //laquelle ? nom de la classe
                "choice_label" => "nom",        //quelle propriété de la class à afficher sur le navigateur
                "expanded" => false,              //si true changer la balise html select pour quelle devienne radio et qu'on nenpuisse pas selectonner 2 categ
                "choice_label" => function(Categorie $relation){
                    return $relation->getNom()." ".'ID: '.$relation->getId();
                },
                "label" => "Categorie",
                "placeholder" => "Saisir une catégorie",

        ] )
        ->add('matieres', EntityType::class, [
            "class" => Matiere::class,
            "choice_label" => "nom",
            "multiple" => true,
            "expanded" => true,

        ])
        //relation => objet
        //matieres => tableau d'objet
            /**
             * SI le formulaire est rattaché à une entity les elements doivent correspondrent aux propriétés de l'entity
             * 
             * La methode add() est un element du formulaire label + input
             * 1er : arg obligatoire, le nom de l'element
             * 2e : class qui def le type de l'element du formulaire
             * 3e : tableau
             * 

             */
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Produit::class,
        ]);
    }
}
