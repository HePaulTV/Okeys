<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

use App\Form\ContactType;
use App\Entity\Contact;

use App\Form\VisiteType;
use App\Entity\Visite;

use App\Form\AjoutBienType;
use App\Entity\Annonce;
use App\Entity\Images;

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
        $idAnnonce=$entityManagerInterface->getRepository(Annonce::class)->find($id);

        $visite = new Visite();
        $form = $this->createForm(VisiteType::class, $visite, ['annonce_id' => $id,]);

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
            'idAnnonce' => $idAnnonce,
            'form' => $form->createView()
        ]);
    }


    #[Route('/ajoutbien', name: 'ajoutbien')]
    public function ajoutbien(Request $request, EntityManagerInterface $entityManager, SluggerInterface $slugger): Response
    {
        // Créez un nouvel objet Annonce
        $ajoutbien = new Annonce();
        
        // Créez le formulaire avec l'objet Annonce
        $form = $this->createForm(AjoutBienType::class, $ajoutbien);
    
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // Traitement des images téléchargées
            $images = $form->get('images')->getData();
            foreach ($images as $image) {
                $imageName = uniqid().'.'.$image->guessExtension();
                $image->move(
                    $this->getParameter('file_directory'), // Répertoire de stockage
                    $imageName
                );
    
                // Créez une nouvelle instance de l'entité Images
                $imageEntity = new Images();
                $imageEntity->setNom($imageName);
                $imageEntity->setAnnonce($ajoutbien);
    
                // Enregistrez l'image dans la base de données
                $entityManager->persist($imageEntity);
            }
    
            $entityManager->persist($ajoutbien);
            $entityManager->flush();
    
            return $this->redirectToRoute('ajoutbien');
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
}
