<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Posts;

class HomeController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/', name: 'app_home')]
    public function index(ManagerRegistry $doctrine,PaginatorInterface $paginator,Request $request): Response
    {
        $data = $request->request->all();
        var_dump($data);
        $postsRepository = $doctrine->getRepository(Posts::class);
        $queryBuilder = $postsRepository->createQueryBuilder('p');
        $getParams = $request->query->get('page');
        if (!empty($getParams)) {
            $page = $request->query->getInt('page', $getParams);
        }else{
            $page = $request->query->getInt('page',1);
        }
        $query = $queryBuilder->getQuery(); // Получаем объект Query
        $pagination = $paginator->paginate($query, $page, 4);
        foreach ($paginator as $post) {
            echo $post->getTitle();
        }

        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'posts' => $doctrine->getRepository(Posts::class)->findAll(),
            'pagination' => $pagination
        ]);
    }
}
