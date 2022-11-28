<?php

namespace App\DataFixtures;


use App\Entity\Discount;
use App\Entity\Category;
use App\Entity\Flower;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class FlowerFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $date1 = new DateTime();
        $date2 = new DateTime('2023/05/31');

        $discount1 = new Discount();
        $discount1->setValue(0.20)
            ->setStart($date1)
            ->setEnd($date2);
        $manager->persist($discount1);

        $discount2 = new Discount();
        $discount2->setValue(0.50)
            ->setStart($date1)
            ->setEnd($date2);
        $manager->persist($discount2);

        $discount3 = new Discount();
        $discount3->setValue(0.70)
            ->setStart($date1)
            ->setEnd($date2);
        $manager->persist($discount3);


        $category1 = new Category();
        $category1->setName("printemps");
        $manager->persist($category1);

        $category2 = new Category();
        $category2->setName("été");
        $manager->persist($category2);

        $category3 = new Category();
        $category3->setName("automne");
        $manager->persist($category3);

        $category4 = new Category();
        $category4->setName("hiver");
        $manager->persist($category4);


        $flower1 = new Flower();
        $flower1->setDiscount($discount1)
            ->setName("Anémone")
            ->setPrice(6.50)
            ->setContent("L'anémone est une fleur de la famille des Renonculacées qui pousse dans les zones tempérées des deux hémisphères.")
            ->setIsNew(true)
            ->setImage("anemone-hiver.png")
            ->addCategory($category4);
        $manager->persist($flower1);

        $flower2 = new Flower();
        $flower2->setName("Jasmin")
            ->setPrice(18.90)
            ->setContent("le jasmin est un arbuste grimpant de la famille des Oleaceae au feuillage caduc à semi-persistant donnant une abondante floraison parfumée durant tout l'été.")
            ->setIsNew(true)
            ->setImage("jasmin-printemps-ete-automne.png")
            ->addCategory($category1)
            ->addCategory($category2)
            ->addCategory($category3);
        $manager->persist($flower2);

        $flower3 = new Flower();
        $flower3->setDiscount($discount2)
            ->setName("Clématite")
            ->setPrice(17.90)
            ->setContent("La clématite est une plante grimpante qui compte près de 400 espèces. Avec ses tiges volubiles, elle s'enroule autour de son support grâce aux vrilles.")
            ->setIsNew(false)
            ->setImage("clematite-ete.png")
            ->addCategory($category2);
        $manager->persist($flower3);

        $flower4 = new Flower();
        $flower4->setDiscount($discount3)
            ->setName("Rose")
            ->setPrice(7.80)
            ->setContent("La rose est la fleur du rosier, arbuste du genre Rosa et de la famille des Rosaceae. La rose des jardins se caractérise avant tout par la multiplication de ses pétales imbriqués.")
            ->setIsNew(false)
            ->setImage("rose-printemps.png")
            ->addCategory($category1);
        $manager->persist($flower4);

        $manager->flush();
    }
}
