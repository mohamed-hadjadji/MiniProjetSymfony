<?php

namespace App\Controller;

use App\Entity\Personne;
use App\Form\PersonneType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Twig\Node\Expression\Test\NullTest;

class PersonneController extends AbstractController
{
    public function __construct(private ManagerRegistry $doctrine){}
   
    #[Route('/personne', name: 'app_personne')]
    public function index(): Response
    {
        $repository = $this->doctrine->getRepository(Personne::class);
        $personnes = $repository->findAll();

        return $this->render('personne/index.html.twig', [
            'personnes' => $personnes,
        ]);
    }

    #[Route('/personne/edit/{id?0}', name: 'edit_personne')]
    public function edit(Request $request, Personne $personne = null, SluggerInterface $slugger): Response
    {
        if (!$personne)
           $personne = new Personne();
           $form = $this->createForm(PersonneType::class, $personne);
           $form->handleRequest($request);

           if ($form->isSubmitted() && $form->isValid()) {
            /* Todo :  Ajouter la personne dans la base de données*/
            /* dd($personne); */

            $image = $form->get('image')->getData();
            // this condition is needed because the 'brochure' field is not required
            // so the PDF file must be processed only when a file is uploaded
            if ($image) {
                /* On renome */
                $originalFilename = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$image->guessExtension();
                /* dd($newFilename); */
                // Move the file to the directory where brochures are stored
                /* On déplace le fichier dans notre serveur */
                try {
                    $image->move(
                        $this->getParameter('personne_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

                // updates the 'imagename' property to store the PDF file name
                // instead of its contents
                $personne->setPath($newFilename);
            }
            $manager = $this->doctrine->getManager();
            $manager->persist($personne);
            $manager->flush();
            return $this->redirectToRoute('app_personne');
        }
        return $this->render('personne/edit.html.twig', [
            'form' => $form->createView()
        ]);

    }
}
