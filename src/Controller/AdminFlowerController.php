<?php

namespace App\Controller;

use App\Entity\Flower;
use App\Form\FlowerType;
use App\Repository\FlowerRepository;
use Doctrine\Persistence\ManagerRegistry;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

#[IsGranted('ROLE_ADMIN')]
class AdminFlowerController extends AbstractController
{
    /**
     * Get all the flowers
     *
     * @param FlowerRepository $flowerRepository
     * @return Response
     */
    #[Route('/admin/flower', name: 'app_admin_flower')]
    public function getAll(FlowerRepository $flowerRepository): Response
    {
        $flowers = $flowerRepository->findAll();

        return $this->render('admin_flower/index.html.twig', [
            'flowers' => $flowers
        ]);
    }

    /**
     * Update or Create a flower
     *
     * @param Flower|null $flower
     * @param Request $request
     * @param ManagerRegistry $managerRegistry
     * @return Response
     */
    #[Route('/admin/flower/create', name: 'app_admin_create_flower')]
    #[Route('/admin/flower/{id}', name: 'app_admin_update_flower', methods: 'GET|POST')]
    public function createOrUpdate(?Flower $flower, Request $request, ManagerRegistry $managerRegistry, SluggerInterface $slugger): Response
    {
        if(!$flower) {
            $flower = new Flower();
        }
        $isUpdated = $flower->getId() !== null;
        if($isUpdated) {
            $oldImage = $this->getParameter('directory_images_flowers').'/'. $flower->getImage();
        }

        $form = $this->createForm(FlowerType::class, $flower);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {

            // Get the uploaded image file
            $imageFile = $form->get('imageFile')->getData();
            // Check if the image file is valid
            if($imageFile) {
                $imageFileOriginal = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                // Reformat the image file name to be conform to an URL
                $imageFileReformat = $slugger->slug($imageFileOriginal);
                // Create a unique name & unique id for the image file
                $imageName = $imageFileReformat.'-'.uniqid().'-'.$imageFile->getExtension();
                // Move the image file to a specific directory in the server
                try {
                    $imageFile->move(
                        $this->getParameter('directory_images_flowers'),
                        $imageName
                    );
                } catch(FileException $e) {
                    throw $e;
                }
                // Save the name of the image file only
                $flower->setImage($imageName);
            }

            $managerRegistry->getManager()->persist($flower);
            $managerRegistry->getManager()->flush();

            if($isUpdated) {
                if (file_exists($oldImage)) {
                    unlink($oldImage);
                }
            }
            $this->addFlash("success", ($isUpdated) ? "La modification a bien été effectuée." : "L'ajout a bien été effectué.");
            return $this->redirectToRoute('app_admin_flower');
        }

        return $this->render('admin_flower/createOrUpdate.html.twig', [
            'flower' => $flower,
            'form' => $form->createView(),
            'isUpdated' => $flower->getId() !== null
        ]);
    }

    /**
     * Delete a flower
     *
     * @param Flower $flower
     * @param Request $request
     * @param ManagerRegistry $managerRegistry
     * @return Response
     */
    #[Route('/admin/flower/{id}', name: 'app_admin_delete_flower', methods: 'DELETE')]
    public function delete(Flower $flower, Request $request, ManagerRegistry $managerRegistry): Response
    {
        $image = $this->getParameter('directory_images_flowers').'/'.$flower->getImage();

        if($this->isCsrfTokenValid('REMOVE'.$flower->getId(), $request->get('_token'))) {
            // Delete a flower in the database
            $managerRegistry->getManager()->remove($flower);
            $managerRegistry->getManager()->flush();
            // Delete a flower in the server
            if($image){
                if (file_exists($image)) {
                    unlink($image);
                }
            }
            $this->addFlash("success", "La suppression a bien été effectuée.");
            return $this->redirectToRoute('app_admin_flower');
        }
    }

}
