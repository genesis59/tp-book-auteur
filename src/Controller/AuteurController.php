<?php

namespace App\Controller;

use App\Entity\Auteur;
use App\Entity\Author;
use App\Form\AuthorType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AuteurController extends AbstractController
{
    /**
     * @Route("/auteur", name="auteur")
     */
    public function index()
    {
        return $this->render('auteur/index.html.twig', [
            'controller_name' => 'AuteurController',
        ]);
    }

    /**
     * @Route("/author/new", name="author_new")
     * @Route("/author/edit/{id}", name="author_edit",requirements={"id":"\d+"})
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @param Auteur|null $author
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function addEdit(Request $request, EntityManagerInterface $manager, Auteur $author = null){

        if(!$author) $author = new author();
        $form = $this->createForm(AuthorType::class,$author,[]);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $manager->persist($author);
            $manager->flush();

            return $this->redirectToRoute("author");
        }
        return $this->render("author/form.html.twig",[
            'authorForm' => $form->createView()
        ]);
    }
}
