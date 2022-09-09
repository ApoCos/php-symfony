<?php

namespace App\Controller; /*dans le composer on peut voir le le dossier App correspond en fait au dossier src*/

use App\Entity\Produit;
use App\Repository\ProduitRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

// TOUTE CLASS SYMFONY UTILISEE DOIT ETRE IMPORTEE

class FrontController extends AbstractController //heritage
{
    /**
     * 1e argument : la route , à placer entre ""
     *    ===> URL
     * 127.0.0.1:8000 en local
     * nomDeDomaine.fr en ligne
     * 
     * 127.0.0.1:8000/front
     * 
     * 2e argument : le nom de la route (redirection, liens, etc)
     * Attention: 
     * 
     * en php 7 et avant, on ecrit de la manière suivante :
     * @Route("/front", name="front") 
     * 
     * en php 8 :
     * #[Route('/front', name:'frontName')]
     * mais on peut utiliser la syntahxe de php 7 en php 8
     * 
     */

    public function front(): Response
    {
        /*
        la methode render() permet de retourner une view
        1er argument obligatoire 
        */
        $prenomController = "Jules";

        dump($prenomController);

        /*
         * dump permet d'afficher dans le profiler symfony (barre noire en bas de l'ecran en mode dev)
         * la valeur située dans le dump ===> variable, tableau, objet, etc
         * 
         * on peut tuer le code (le stopper) avec le terme die
         * dump(); die;
         * Tout ce qui suit le die ne sera pas "lu"
         * on peut l'ecrire plus simplement abec la fonction dd()
         */

        return $this->render("front/front.html.twig", [
            //key => value
            //key: nom de la variable twig
            //value: nom de la variable controller
            "prenomTwig" => $prenomController
        ]);
    }

#[Route('/home', name: 'home')]

    public function home(): Response
    {
        return $this->render('home/home.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }


#[Route('/catalogue', name:'catalogue')]

    public function catalogue(ProduitRepository $repoProduit): Response
    {
        $produits = $repoProduit->findAll();


        return $this->render('front/catalogue.html.twig', [
            "produits" => $produits
        ]);
    }

#[Route('/fiche_produit/{id}', name:'fiche_produit')]

    public function fiche_produit(Produit $produit, ProduitRepository $repoProduit): Response
    {
        // $produit = $repoProduit->find($id);


        return $this->render('front/fiche_produit.html.twig', [
            "produit" => $produit
        ]);
    }
} 
//on n'ajoute rien en dessous !