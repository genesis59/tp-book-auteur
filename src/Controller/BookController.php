<?php

namespace App\Controller;

use App\Entity\Auteur;
use App\Entity\Book;
use App\Form\AuteurType;
use App\Form\BookType;
use App\Repository\BookRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class BookController extends AbstractController
{
    private function getPagination($source,PaginatorInterface $paginator, Request $request){
        return $paginator->paginate(
                $source,
                $request->query->getInt('page',1),
                10
        );
    }

    private function authorForBase(){
        $repository = $this->getDoctrine()->getRepository("App:Auteur");
        $authors = $repository->findAll();
        return $authors;
    }

    private function publisherForBase(){
        $repository = $this->getDoctrine()->getRepository("App:Editeur");
        $publishers = $repository->findAll();
        return $publishers;
    }

    private function publishedAtForBase(){
        $repository = $this->getDoctrine()->getRepository("App:Book");
        $date = $repository->getAllDateOfPublication();
        return $date;
    }
    private function genreForBase(){
        $repository = $this->getDoctrine()->getRepository("App:Genre");
        $genre = $repository->findAll();
        return $genre;
    }

    private function createBookForm(Request $request){
        $form = $this->createForm(BookType::class);
        $form->handleRequest($request);
        return $form;
    }

    private function testSearch($value, $form,Request $request,BookRepository $repository,PaginatorInterface $paginator){
        $pagination = null;
        if($form->isSubmitted() && $form->isValid()){
            if ($repository->getAllBooksByDate($value) != []){
                $pagination = $this->getPagination(
                    $repository->getAllBooksByDate($value),
                    $paginator,
                    $request
                );
            }
            if ($repository->getAllBooksByTitle($value) != []){
                $pagination = $this->getPagination(
                    $repository->getAllBooksByTitle($value),
                    $paginator,
                    $request
                );
            }
            if ($repository->getAllBooksByGenre($value) != []){
                $pagination = $this->getPagination(
                    $repository->getAllBooksByGenre($value),
                    $paginator,
                    $request
                );
            }
            elseif ($repository->getAllBooksByAuthor($value) != []){
                $pagination = $this->getPagination(
                    $repository->getAllBooksByAuthor($value),
                    $paginator,
                    $request
                );
            }
            elseif ($repository->getAllBooksByPublisher($value) != []){
                $pagination = $this->getPagination(
                    $repository->getAllBooksByPublisher($value),
                    $paginator,
                    $request
                );
            }
        }
        return $pagination;
    }

    /**
     * @Route("/book/new",name="book_add")
     * @Route("/book/new/{id}",name="book_update")
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @param Book $book
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function addEdit(Request $request, EntityManagerInterface $manager, Book $book = null){
        if(!$book ) $book = new Book();
        $form = $this->createForm(BookType::class,$book);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $manager->persist($book);
            $manager->flush();
            return $this->redirectToRoute('book');
        }
        return $this->render('book/form.html.twig',[
            'bookForm' => $form->createView()
        ]);
    }


    /**
     * @Route("/book", name="book")
     * @param BookRepository $repository
     * @param PaginatorInterface $paginator
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index(BookRepository $repository, PaginatorInterface $paginator,Request $request)
    {
        $pagination = null;
        $form = $this->createBookForm($request);

        $pagination = $this->testSearch($form->get('title')->getData(),$form,$request,$repository,$paginator);

        if($pagination == null){
            $pagination = $this->getPagination(
                $repository->findAll(),
                $paginator,
                $request
            );
        }

        $authorBase = $this->authorForBase();
        $publisherBase = $this->publisherForBase();
        $publishedAtForBase = $this->publishedAtForBase();
        $genreForBase = $this->genreForBase();

        return $this->render('book/index.html.twig', [
            'bookList' => $pagination,
            'title' => "Tous les livres",
            'authorList' => $authorBase,
            'publisherList' => $publisherBase,
            'publishedAtList' => $publishedAtForBase,
            'genreList' => $genreForBase,
            'bookForm' => $form->createView()
        ]);
    }

    /**
     * @Route("/book/costing-more-than/{price}",name="book_costing_more_than")
     * @param int $price
     * @param BookRepository $repository
     * @param PaginatorInterface $paginator
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function bookCostingMoreThan(int $price, BookRepository $repository, PaginatorInterface $paginator,Request $request){

        $pagination = $this->getPagination(
            $repository->getAllBooksCostingMoreThan($price),
            $paginator,
            $request
        );
        $authorBase = $this->authorForBase();
        $publisherBase = $this->publisherForBase();
        $publishedAtForBase = $this->publishedAtForBase();
        $genreForBase = $this->genreForBase();
        return $this->render('book/index.html.twig', [
            'bookList' => $pagination,
            'title' => "Les livres qui coûtent plus de $price euros",
            'authorList' => $authorBase,
            'publisherList' => $publisherBase,
            'publishedAtList' => $publishedAtForBase,
            'genreList' => $genreForBase
        ]);
    }

    /**
     * @Route("/book/by-date/{date}",name="book_by_date")
     * @param string $date
     * @param BookRepository $repository
     * @param PaginatorInterface $paginator
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function bookByDate(string $date, BookRepository $repository, PaginatorInterface $paginator,Request $request){

        $pagination = $this->getPagination(
            $repository->getAllBooksByDate($date),
            $paginator,
            $request
        );
        $authorBase = $this->authorForBase();
        $publisherBase = $this->publisherForBase();
        $publishedAtForBase = $this->publishedAtForBase();
        $nbDates = $repository->getNbLineInRequestDate($date)->getSingleScalarResult();
        $genreForBase = $this->genreForBase();
        return $this->render('book/index.html.twig', [
            'bookList' => $pagination,
            'title' => "$date",
            'authorList' => $authorBase,
            'publisherList' => $publisherBase,
            'publishedAtList' => $publishedAtForBase,
            'genreList' => $genreForBase,
            'nbDate' => $nbDates
        ]);
    }

    /**
     * @Route("/book/by-genre/{genre}",name="book_by_genre")
     * @param string $genre
     * @param BookRepository $repository
     * @param PaginatorInterface $paginator
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function bookByGenre(string $genre, BookRepository $repository,PaginatorInterface $paginator,Request $request){

        $pagination = $this->getPagination(
            $repository->getAllBooksByGenre($genre),
            $paginator,
            $request
        );
        $authorBase = $this->authorForBase();
        $publisherBase = $this->publisherForBase();
        $publishedAtForBase = $this->publishedAtForBase();
        $genreForBase = $this->genreForBase();
        $genres = $repository->getNbLineInRequestGenre($genre)->getSingleScalarResult();
        return $this->render('book/index.html.twig', [
            'bookList' => $pagination,
            'title' => $genre,
            'authorList' => $authorBase,
            'publisherList' => $publisherBase,
            'publishedAtList' => $publishedAtForBase,
            'genreList' => $genreForBase,
            'nbGenres' => $genres
        ]);
    }

    /**
     * @Route("/book/by-auteur/{auteur}",name="book_by_auteur")
     * @param string $auteur
     * @param BookRepository $repository
     * @param PaginatorInterface $paginator
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function bookByAuthor(string $auteur,BookRepository $repository,PaginatorInterface $paginator,Request $request){

        $pagination = $this->getPagination(
            $repository->getAllBooksByAuthor($auteur),
            $paginator,
            $request
        );
        $authorBase = $this->authorForBase();
        $publisherBase = $this->publisherForBase();
        $publishedAtForBase = $this->publishedAtForBase();
        $nbAuthors = $repository->getNbLineInRequestAuthor($auteur)->getSingleScalarResult();
        $genreForBase = $this->genreForBase();
        return $this->render('book/index.html.twig', [
            'bookList' => $pagination,
            'title' => $auteur,
            'authorList' => $authorBase,
            'publisherList' => $publisherBase,
            'publishedAtList' => $publishedAtForBase,
            'nbAuthor' => $nbAuthors,
            'genreList' => $genreForBase
        ]);
    }


    /**
     * @Route("/book/by-publisher/{publisher}",name="book_by_publisher")
     * @param string $publisher
     * @param BookRepository $repository
     * @param PaginatorInterface $paginator
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function bookByPublisher(string $publisher, BookRepository $repository,PaginatorInterface $paginator,Request $request){

        $pagination = $this->getPagination(
            $repository->getAllBooksByPublisher($publisher),
            $paginator,
            $request
        );
        $authorBase = $this->authorForBase();
        $publisherBase = $this->publisherForBase();
        $publishedAtForBase = $this->publishedAtForBase();
        $nbEditeurs = $repository->getNbLineInRequestEditeur($publisher)->getSingleScalarResult();
        $genreForBase = $this->genreForBase();
        return $this->render('book/index.html.twig', [
            'bookList' => $pagination,
            'title' => $publisher,
            'authorList' => $authorBase,
            'publisherList' => $publisherBase,
            'publishedAtList' => $publishedAtForBase,
            'nbEditeurs' => $nbEditeurs,
            'genreList' => $genreForBase
        ]);
    }
}
