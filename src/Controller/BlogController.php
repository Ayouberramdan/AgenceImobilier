<?php

namespace App\Controller;

use App\Entity\Articles;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class BlogController extends AbstractController
{
    /**
     * @Route("/blog", name="blog")
     */
    public function index()
    {
        $repo = $this->getDoctrine()->getRepository(Articles::class);
        $article = $repo ->findAll();
        return $this->render('blog/index.html.twig', [
            'controller_name' => 'BlogController',
            'articles' => $article ,
        ]);
    }

    /**
     * @Route("/")
     */
    public function home()
    {
        return $this->render('blog/home.html.twig' ,[
            'title' => 'HOME',
        ]);
    }

    /**
     * @Route("/blog/{id}" , name="blog_show")
     */
    public function show($id){
        $repo = $this->getDoctrine()->getRepository(Articles::class);
        $article = $repo->find($id);
        return $this->render('blog/show.html.twig' , [
            'article' => $article ,
        ]);
    }
}
