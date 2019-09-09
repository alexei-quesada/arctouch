<?php

namespace App\DataFixtures;

use App\Entity\Event;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class EventFixtures extends Fixture implements DependentFixtureInterface
{
    private $passwordEncoder;
    private const LOREM_IPSUM = "Lorem ipsum dolor sit amet consectetur adipiscing elit ultrices, porta habitant rutrum dignissim ante felis sociosqu interdum, sagittis massa mus fermentum himenaeos suspendisse placerat. Dapibus condimentum dui eleifend lacus scelerisque mattis mauris egestas litora eros venenatis, hendrerit sem sociis risus vestibulum consequat lacinia sodales tincidunt. Sociis facilisis ridiculus nostra eget nulla mattis taciti venenatis nisi velit, turpis tristique arcu cras egestas dignissim sapien condimentum maecenas hac, et non ante leo platea cum rutrum litora aliquam. Inceptos phasellus a rutrum cubilia arcu metus penatibus, augue ac potenti tincidunt enim venenatis facilisi himenaeos, elementum sagittis viverra egestas odio mollis. Neque accumsan metus dis senectus nam egestas porta urna, nulla facilisi faucibus venenatis vivamus fames tempus natoque ac, nostra tempor taciti litora duis ullamcorper curae. Laoreet semper erat neque maecenas felis dapibus luctus mi dictumst conubia, augue tempus primis nullam sagittis risus venenatis mattis condimentum, sollicitudin platea ridiculus placerat vel nulla faucibus tristique euismod.";

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    /**
     * @param ObjectManager $manager
     * @throws \Exception
     */
    public function load(ObjectManager $manager)
    {
        $locations = [
            '-27.544256,-48.501639', //arcTouch
            '-27.614002,-48.640635', //São José
            '-26.910107,-48.671192', //Itajai (more than 20 miles from Florianópolis)
        ];

        $baseDate1 = \DateTime::createFromFormat('Y-m-d', '2019-10-01');
        $baseDate2 = \DateTime::createFromFormat('Y-m-d', '2019-10-01');
        $baseDate3 = \DateTime::createFromFormat('Y-m-d', '2019-10-01');
        $dayIncrement = 1;

        for($i=0; $i<20; $i++) {
            $eventArcTouch = new Event();
            $eventSaoJose = new Event();
            $eventItajai = new Event();

            $baseDate1->add(new \DateInterval('P'.$dayIncrement++.'D'));
            $baseDate2->add(new \DateInterval('P'.$dayIncrement++.'D'));
            $baseDate3->add(new \DateInterval('P'.$dayIncrement++.'D'));

            self::fillEvent($eventArcTouch,"LGPD- Lei Geral de Proteção de Dados - o que você precisa saber","lgpd-lei-geral-de-protecao-de-dados-". $baseDate1->format('Y-m-d'), $baseDate1, $locations[0], "img1.jpg");
            self::fillEvent($eventSaoJose,"Treinamento - Qlik Sense Intermediário e Avançado","treinamento-qlik-sense-intermediario-avancado-". $baseDate2->format('Y-m-d'), $baseDate2, $locations[1], "img2.jpg");
            self::fillEvent($eventItajai,"Curso Revit Express - Aprendendo a usar a Ferramenta Bim","curso-revit-express-aprendendo-ferramenta-bim-". $baseDate3->format('Y-m-d'), $baseDate3, $locations[2], "img3.jpg");

            $manager->persist($eventArcTouch);
            $manager->persist($eventSaoJose);
            $manager->persist($eventItajai);

            $manager->flush();
        }
    }

    private function fillEvent(&$event, $name, $slug, $date, $location, $image){
        $event->setName($name)
            ->setSlug($slug)
            ->setDate($date)
            ->setDescription(self::LOREM_IPSUM)
            ->setLocation($location)
            ->setImage($image)
            ->addAttendee($this->getReference(UserFixtures::REGULAR_USER_REFERENCE_1))
            ->addAttendee($this->getReference(UserFixtures::REGULAR_USER_REFERENCE_2));
    }

    public function getDependencies()
    {
        return array(
            UserFixtures::class,
        );
    }
}