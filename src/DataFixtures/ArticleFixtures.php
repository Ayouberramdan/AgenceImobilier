<?php

namespace App\DataFixtures;

use App\Entity\Articles;
use App\Entity\Category;
use App\Entity\Comment;
use App\Entity\Image;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;

class ArticleFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');
        //cree 3 category
        for($i=1 ; $i <= 4 ; $i++){
            $category = new Category();
            $category ->setTitle($faker->sentence())
                ->setDescription($faker->paragraph());
            $manager->persist($category);

            //cree 10 articles pour chaque categorie
            for($t=0 ; $t <= mt_rand(4,10) ; $t++) {
                $article = new Articles();
                $article->setTitle($faker->sentence())
                    ->setContent($faker->paragraph(5))
                    ->setImage($faker->imageUrl())
                    ->setCreatedAt($faker->dateTimeBetween('-6 months'))
                    ->setCategory($category);
                $manager->persist($article);

                //doner des commentaire pour chaque article
                for($k=1 ; $k <= mt_rand(3,7) ; $k++){
                    $now = new \DateTime();
                    $interval = $now->diff($article->getCreatedAt());
                    $days = $interval->days;
                    $date = '-' . $days .'days' ;
                    $comment = new Comment();
                    $comment->setAuthor($faker->name)
                        ->setContent($faker->paragraph(2))
                        ->setCreatedAt($faker->dateTimeBetween($date))
                        ->setArticle($article);
                    $manager->persist(($comment));

                }
            }
        }


        $manager->flush();
    }
}
