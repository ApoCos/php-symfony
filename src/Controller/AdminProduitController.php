<?php

namespace App\Controller;

use App\Entity\Produit;
use App\Form\ProduitType;
use App\Repository\ProduitRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

//mettre une route avant la classe permet d'indiquer que toutes les routes du cette classe commenceront par ce morceau de route
#[Route('/admin/produit')]
class AdminProduitController extends AbstractController
{

    /**
     * BACK OFFICE : GESTION DES PRODUITS
     * CRUD
     * 
     * route                        nom de la route
     * /admin/produit/ajouter             produit_ajouter
     * /admin/produit/afficher            produit_afficher
     * /admin/produit/modifier            produit_modifier
     * /admin/produit/supprimer           produit_supprimer
     * 
     */ 

    #[Route('/afficher', name: 'produit_afficher')]
    public function produit_afficher(ProduitRepository $repoProduit): Response
    {
        /**
         * on va requeter pour recuperer les tables de produits de la bdd
         * lorsqu'on créé une entity, on genere aussi en m temps le repository de cette entity
         * 
         * Entity Produit ==> ProduitRepository
         * Le repository est une class permettant d'effectuer toutes les requetes concernant l'entity (INSERT INTO UPDATE DELETE SELECT)
         * (la table)
         * 
         * 
         * exemple avec ProduitRepository
         * Pour SELECT, il y a une methode 
         * findall() ==> SELECT * FROM produit
         * find(int) ==> SELECT * FROM produit WHERE id = int
         * findBy([
         * key => value
         * key ==> propriété propre à l'entité
         * prix => 19.99
         * titre => "bague en or"
         * ])
         * 
         * SELECT * FROM produit WHERE prix = 19.99 AND titre = "bague ne or"
         * 
         * 
         * la fonction produit_afficher() a pour objectif d'afficher les produits qui se trouvent dans la table produit
         * pour cela la fonction a besoin d'un objet issu de la class ProduitRepository
         * Autrement dit, elle va en dépendre..
         * 
         * Les dependances sont les objets générés dans les parentheses de la fonction 
         * syntaxe :
         * 
         * Class $objec, Class2 $object2
         */

        $produits = $repoProduit->findAll(); //retourne un tableau d'objet issue de la class Produit
        // $produits = $repoProduit->find(1); // find(int) pour retourner soir un objet soit null en fonction de chiffre indiquer entre parenthèses

        //pour afficher le resultat
        dump($produits);

        return $this->render('admin_produit/produit_afficher.html.twig', [
            "produits" => $produits
        ]);
    }

    #[Route('/ajouter', name: 'produit_ajouter')]
    public function produit_ajouter(Request $request, ProduitRepository $repoProduit): Response
    {
        // on crée un nouvel objet
        $produit = new Produit();
        //pour verifier 
        //dd($produit);

        /**
         * Pour créer un formulaire on utilise la methode createForm() qui est une methode issue de AbstractController
         * 2arguments obligatoire:
         * - la class qui contient le builder (soit le plan de construction du formulaire)
         * - l'objet issue de la class/Entity
         */
        $form = $this->createForm(ProduitType::class, $produit);
        //récupérer le traitement du formulaire
        $form->handleRequest($request); //$form est un objet

        /**
         * Si le formulaire est soumis et s'il est valide
         */
        if ($form->isSubmitted() && $form->isValid()) {
            //envoyer en bdd le produit
            dump($produit);
            $repoProduit->add($produit, true);            
            // dd($produit); //pour verifié que ça arrive bien en bdd
            /**
             * Notifier avec addFlash()
             */
            $this->addFlash('success', 'Le produit a été bien ajouté');

            return $this->redirectToRoute('produit_afficher');
            /**redirectRoute() est la meme que la fonction Twig path()
             * La fonction path() permet de rediriger sur des liens internens du site :
             * - 1er arg obli : le nom de la route
             * - 2e arg facul : le tableau des paramètres
             */
        }

        return $this->render('admin_produit/produit_ajouter.html.twig', [
            'controller_name' => 'AdminProduitController',
            "formProduit" => $form->createView()
        ]);
    }

    //pour recup le param id, il faut lui donner son nom entre accolade
    #[Route('/modifier/{id}', name: 'produit_modifier')]

    public function produit_modifier(Produit $produit, ProduitRepository $repoProduit, Request $request): Response 
    {
        $form = $this->createForm(ProduitType::class, $produit);
        $form ->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) 
        {
            $repoProduit->add($produit, true);       
            $this->addFlash('success', 'Le produit a été bien modifié');
            return $this->redirectToRoute('produit_afficher');
        }

        // $produit = $repoProduit->find($id); //SELECT * FROM produit WHERE id= $id
        //dd($produit)

        return $this->render('admin_produit/produit_modifier.html.twig', [
            "produit" => $produit,
            "formProduit" => $form->createView(),
            'controller_name' => 'AdminProduitController',
        ]);
    }

    #[Route('/supprimer/{id}', name: 'produit_supprimer')]

    public function produit_supprimer(Produit $produit, ProduitRepository $repoProduit): Response 
    {
        $repoProduit->remove($produit, true);
        $this->addFlash('success', 'Le produit a été bien supprimé');
        return $this->redirectToRoute('produit_afficher');

        return $this->render('admin_produit/produit_supprimer.html.twig', [
            "produit" => $produit,
            'controller_name' => 'AdminProduitController',
        ]);
    }
}
