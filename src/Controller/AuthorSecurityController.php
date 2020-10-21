<?php


namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AuthorSecurityController extends AbstractController
{
    /**
     * @Route("/login-author", name="author_login")
     */
    public function login(){
        return $this->render('author-login.html.twig');
    }
}