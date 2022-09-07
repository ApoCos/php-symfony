<?php

namespace App\Controller; /*dans le composer on peut voir le le dossier App correspond en fait au dossier src*/

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

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
     * @Route("/front", name="frontName") 
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
        $prenomController = "louis";
        return $this->render("front/front.html.twig", [
            //key => value
            //key: nom de la variable twig
            //value: nom de la variable controller
            "prenomTwig" => $prenomController
        ]);
    }
} 
//on n'ajoute rien en dessous !