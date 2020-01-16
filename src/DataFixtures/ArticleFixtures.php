<?php

namespace App\DataFixtures;

use App\Entity\Articles;
use App\Entity\Image;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class ArticleFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);
        for($i=0 ; $i <= 10 ; $i++) {
            $article = new Articles();
            $article->setTitle("Titre de l'article n $i")
                ->setContent("<p>Contenu de l'article n $i</p>")
                ->setImage("http://placehold.it/350x150")
                ->setCreatedAt(new \DateTime());

            for ($j = 0; $j <= mt_rand(3 , 5); $j++) {
                $image = new Image();
                $image->setUrl("http://placehold.it/350x150")
                    ->setCaption("Contenu de l'article n $i")
                    ->setArticles($article);
                $manager->persist($image);
            }


            $manager->persist($article);
        }


        $manager->flush();
    }
}
