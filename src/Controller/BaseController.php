<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Form\ContactType;
use App\Entity\Contact;

use App\Form\VisiteType;
use App\Entity\Visite;

use App\Form\AjoutBienType;
use App\Entity\Annonce;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

use App\Repository\AnnonceRepository;

class BaseController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(): Response
    {
        return $this->render('base/index.html.twig', [
            
        ]);
    }

    #[Route('/contact', name: 'contact')]
    public function contact(Request $request, EntityManagerInterface $entityManagerInterface): Response
    {
        $contact = new Contact();
        $form = $this->createForm(ContactType::class, $contact);

        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {   
                // Récupération de l'objet utilisateur actuel
                $user = $this->getUser();

                // Vérifiez si l'utilisateur est connecté et est un objet User
                if ($user instanceof \App\Entity\User) {
                    // Association de l'utilisateur avec le contact
                    $contact->setUser($user);
                } else {
                    // Gérer le cas où l'utilisateur n'est pas connecté ou n'est pas un objet User valide
                    // Vous pouvez rediriger vers la page de connexion ou afficher un message d'erreur
                }
                
                //$contact->setDateEnvoi(new \Datetime());

                $entityManagerInterface->persist($contact);
                $entityManagerInterface->flush();

                return $this->redirectToRoute('contact');
            }
        }

        return $this->render('base/contact.html.twig', [
            'form' => $form->createView()
        ]);
    }
    #[Route('/acheter', name: 'acheter')]
    public function acheter(): Response
    {
        return $this->render('base/acheter.html.twig', [
            
        ]);
    }
    #[Route('/louer', name: 'louer')]
    public function louer(): Response
    {
        return $this->render('base/louer.html.twig', [
            
        ]);
    }
    #[Route('/recherche', name: 'recherche')]
    public function recherche(AnnonceRepository $annonceRepository): Response
    {
        $annonces = $annonceRepository->findAll();

        return $this->render('base/recherche.html.twig', [
            'annonces' => $annonces,

        ]);
    }
    /*#[Route('/visite', name: 'visite')]
    public function visite(Request $request, EntityManagerInterface $entityManagerInterface): Response
    {
        $visite = new Visite();
        $form = $this->createForm(VisiteType::class, $visite);

        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {   
                // Récupération de l'objet utilisateur actuel
                $user = $this->getUser();

                // Vérifiez si l'utilisateur est connecté et est un objet User
                if ($user instanceof \App\Entity\User) {
                    // Association de l'utilisateur avec le contact
                    $visite->setUser($user);
                } else {
                    // Gérer le cas où l'utilisateur n'est pas connecté ou n'est pas un objet User valide
                    // Vous pouvez rediriger vers la page de connexion ou afficher un message d'erreur
                }
                

                $entityManagerInterface->persist($visite);
                $entityManagerInterface->flush();

                return $this->redirectToRoute('visite');
            }
        }

        return $this->render('base/visite.html.twig', [
            'form' => $form->createView()
        ]);
    }*/

    #[Route('/visite/{id}', name: 'visite')]
    public function visite(Request $request, EntityManagerInterface $entityManagerInterface, int $id): Response
    {
        // Récupérer l'entité Annonce par son ID
        $annonce = $entityManagerInterface->getRepository(Annonce::class)->find($id);
    
        if (!$annonce) {
            throw $this->createNotFoundException('Aucune annonce trouvée pour cet id '.$id);
        }
    
        // Créer une nouvelle entité Visite et lui associer l'Annonce récupérée
        $visite = new Visite();
        $visite->setAnnonce($annonce);
    
        // Créer le formulaire pour l'entité Visite
        $form = $this->createForm(VisiteType::class, $visite);
    
        // Traitement de la soumission du formulaire
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // Récupération de l'utilisateur actuel et association à Visite
            $user = $this->getUser();
            if ($user instanceof \App\Entity\User) {
                $visite->setUser($user);
            } else {
                // Gérer le cas d'absence d'utilisateur authentifié si nécessaire
            }
    
            // Persister l'entité Visite
            $entityManagerInterface->persist($visite);
            $entityManagerInterface->flush();
    
            // Redirection ou autre logique post-soumission
            return $this->redirectToRoute('visite', ['id' => $id]);
        }
    
        // Rendu du formulaire dans le template
        return $this->render('base/visite.html.twig', [
            'idAnnonce' => $annonce, // Passer l'objet Annonce complet au template
            'form' => $form->createView(),
        ]);
    }


    #[Route('/ajoutbien', name: 'ajoutbien')]
    public function ajoutbien(Request $request, EntityManagerInterface $entityManagerInterface): Response
    {
        $ajoutbien = new Annonce();
        $form = $this->createForm(AjoutBienType::class, $ajoutbien);

        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {   
                // Récupération de l'objet utilisateur actuel
                $user = $this->getUser();

                // Vérifiez si l'utilisateur est connecté et est un objet User
                if ($user instanceof \App\Entity\User) {
                    // Association de l'utilisateur avec le contact
                    $ajoutbien->setUser($user);
                } else {
                    // Gérer le cas où l'utilisateur n'est pas connecté ou n'est pas un objet User valide
                    // Vous pouvez rediriger vers la page de connexion ou afficher un message d'erreur
                }
                

                $entityManagerInterface->persist($ajoutbien);
                $entityManagerInterface->flush();

                return $this->redirectToRoute('ajoutbien');
            }
        }

        return $this->render('base/ajoutbien.html.twig', [
            'form' => $form->createView()
        ]);
    }
    #[Route('/estimation', name: 'estimation')]
    public function estimation(AnnonceRepository $annonceRepository): Response
    {
        return $this->render('base/estimation.html.twig', [

        ]);
    }
    #[Route('/profil', name: 'profil')]
    public function profil(EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();

        $visiteRepository = $entityManager->getRepository(Visite::class);
        $visites = $visiteRepository->findBy(['user' => $user]);

        return $this->render('base/profil.html.twig', [
            'visites' => $visites,
        ]);
    }
    #[Route('/visite/delete/{id}', name: 'visite_delete')]
    public function delete(Request $request, $id, EntityManagerInterface $entityManager): Response
    {
        $visite = $entityManager->getRepository(Visite::class)->find($id);
    
        if (!$visite) {
            throw $this->createNotFoundException(
                'No visite found for id '.$id
            );
        }
    
        $entityManager->remove($visite);
        $entityManager->flush();
    
        // Redirection après suppression
        return $this->redirectToRoute('profil');
    }
}