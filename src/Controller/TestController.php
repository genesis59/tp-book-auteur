<?php

namespace App\Controller;

use App\Repository\BookRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class TestController extends AbstractController
{
    /**
     * @Route("/test", name="test")
     */
    public function index(BookRepository $repository)
    {

        return $this->render('test/index.html.twig', [
            'listQueryBuilder' => $repository->getAllWithQueryBuilder()->getResult(),
            'listDQL' => $repository->getAllWithDQL()->getArrayResult(),
            'listSQL' => $repository->getAllWithSQL(),
            'moyenneGenre' => $repository->getAveragePriceByGenre()->getArrayResult(),
            'bookNumber' => $repository->getTotalNumberOfBooks()->getSingleScalarResult()
        ]);
    }
}
