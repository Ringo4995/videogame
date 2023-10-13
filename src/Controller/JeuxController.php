<?php

namespace App\Controller;

use App\Entity\Jeux;
use App\Entity\Joueurs;
use App\Form\JoueurType;
use App\Form\JeuType;
use App\Repository\JeuxRepository;
use App\Repository\JoueursRepository;
use Doctrine\Persistence\ManagerRegistry as PersistenceManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class JeuxController extends AbstractController
{
    #[Route('/jeux', name: 'app_jeux')]
    public function index(JeuxRepository $jeuxRepository): Response
    {

        $jeux = $jeuxRepository->findAll();
        // dd($jeux); ==> vardump

        return $this->render('jeux/index.html.twig', [
            "jeux" => $jeux
        ]);
    }
    #[Route('/ajoutJeux', name: 'ajoutjeux')]
    public function newGame(Request $requete, PersistenceManagerRegistry $manager)
    {
        $jeux = new Jeux();
        $formulaire = $this->createForm(JeuType::class, $jeux);
        $formulaire->handleRequest($requete);
        if ($formulaire->isSubmitted() && $formulaire->isValid()) {
            $imgCouverture = $formulaire->get('imgCouverture')->getData();
            if ($imgCouverture) {
                $newImgjeux = "cover" . uniqid() . "." . $imgCouverture->guessExtension();

                try {
                    $imgCouverture->move($this->getParameter('dossierJeu'), $newImgjeux);
                } catch (FileException $e) {
                    $e->getMessage();
                }
            }
            $jeux->setImgCouverture($newImgjeux);
            $OM = $manager->getManager();
            $OM->persist($jeux);
            $OM->flush();

            return $this->redirectToRoute('app_jeux');
        }
        return $this->render('jeux/ajoutjeux.html.twig', [
            "formulaire" => $formulaire->createView()
        ]);
    }


    #[Route('/joueurs', name: 'joueurs')]
    #[Route('/editJoueur/{id}', name: 'editJoueur')] // le {id} nous permet de rappeler l'id
    public function ajoutJoueur(Request $requete, PersistenceManagerRegistry $manager, JoueursRepository $joueursRepository, $id = null)
    {
        if (!$id) {
            $joueurs = new Joueurs();
        } else {
            $joueurs = $joueursRepository->find($id);
        }



        $formulaire = $this->createForm(JoueurType::class, $joueurs);
        $formulaire->handleRequest($requete);

        if ($formulaire->isSubmitted() && $formulaire->isValid()) {
            $imageFile = $formulaire->get('avatar')->getData();
            if ($imageFile) {
                $newFilename = "avatar" . uniqid() . "." . $imageFile->guessExtension();

                try {
                    $imageFile->move($this->getParameter('dossierImage'), $newFilename);
                } catch (FileException $e) {
                    $e->getMessage();
                }
            }
            $joueurs->setAvatar($newFilename);
            $OM = $manager->getManager();
            $OM->persist($joueurs);
            $OM->flush();


            return $this->redirectToRoute('afficherjoueur');
        }


        return $this->render('jeux/ajoutjoueur.html.twig', [
            "formulaire" => $formulaire->createView()
        ]);
    }
    #[Route('/afficherjoueur', name: "afficherjoueur")]
    public function afficherJoueur(JoueursRepository $joueursRepository)
    {
        $joueurs = $joueursRepository->findAll();
        return $this->render("jeux/afficherjoueur.html.twig", [
            "joueurs" => $joueurs
        ]);
    }

    #[Route("/deleteJoueur/{id}", name: "deletejoueur")]
    public function suppressionJoueur(PersistenceManagerRegistry $manager, JoueursRepository $joueursRepository, $id)
    {
        $joueur = $joueursRepository->find($id);
        $manager = $manager->getManager();
        $manager->remove($joueur);
        $manager->flush();

        return $this->redirectToRoute('afficherjoueur');
    }
    #[Route("informationjoueur/{id}", name:"informationjoueur")]
    public function informationjoueur(JoueursRepository $joueursRepository, $id){
        $joueur = $joueursRepository->find($id);
        return $this->render("jeux/informationjoueur.html.twig", [
            "joueur" => $joueur
        ]);
    }
}
