<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Form\ContactType;
use App\Entity\Contact;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

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
    public function recherche(): Response
    {
        return $this->render('base/recherche.html.twig', [
            
        ]);
    }
}
