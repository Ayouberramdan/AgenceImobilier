<?php

namespace App\Controller;

use App\Entity\Articles;
use App\Repository\ArticlesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Routing\Annotation\Route;

class BlogController extends AbstractController
{
    /**
     * @Route("/blog", name="blog")
     */
    public function index(ArticlesRepository $repo)
    {
        $article = $repo->findAll();
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
     * @Route("/blog/new" , name="blog_create")
     */
    public function create() {
        $article = new Articles();
        $form = $this->createFormBuilder($article)
                     ->add('title')
                     ->add('content')
                     ->add('image')
                     ->getForm();

        return $this->render('blog/create.html.twig' , [
            'formArticle' => $form->createView(),
        ]);
    }

    /**
     * @Route("/blog/{id}" , name="blog_show")
     */
    //parameConverter Convertir un param de la requete a un objet
    public function show(Articles $article){
        return $this->render('blog/show.html.twig' , [
            'article' => $article ,
        ]);
    }


}
