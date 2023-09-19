<?php

namespace App\Controller;

use App\Entity\Posts;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;

class PostDetailsController extends AbstractController
{
    #[Route('/post_id{id}', name: 'app_post_details')]
    public function index(ManagerRegistry $doctrine,$id): Response
    {
        $product = $doctrine->getRepository(Posts::class)->find($id);
        if (!$product){
            return $this->render('not.found.html.twig', [
                'controller_name' => 'PostDetailsController',
            ]);
        }else {
            return $this->render('post_details/index.html.twig', [
                'controller_name' => 'PostDetailsController',
                'post' => $product,
            ]);
        }
    }
}
