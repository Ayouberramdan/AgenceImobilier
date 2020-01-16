<?php

namespace App\Controller;

use App\Entity\Articles;
use App\Repository\ArticlesRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\BrowserKit\Response;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

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
        dump($this);
        return $this->render('blog/home.html.twig' ,[
            'title' => 'HOME',
        ]);
    }

    /**
     * @Route("/blog/new" , name="blog_create")
     * @Route("/blog/{id}/edit" , name="blog_edit")
     */
    public function create(?Articles $article ,Request $request ,EntityManagerInterface $manager) {
        if(!$article){
            $article = new Articles();
        }
        $form = $this->createFormBuilder($article)
                     ->add('title')
                     ->add('content')
                     ->add('image')
                     ->getForm();

        //Analuser la requettes
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            if(!$article->getId()){
                $article->setCreatedAt(new \DateTime());
            }
            $manager->persist($article);
            $manager->flush();
            return $this->redirectToRoute('blog_show' , ['id'=> $article->getId()]);
        }
        return $this->render('blog/create.html.twig' , [
            'formArticle' => $form->createView(),
            'EditMode' => $article->getId()!== null ,
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
