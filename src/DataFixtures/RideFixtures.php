<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Ride;
use App\Entity\Train;
use App\Entity\Booking;

class RideFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
          $faker = \Faker\Factory::create('fr_FR');

          for ($i = 0; $i < 3; $i++) {
               $train = new Train();
               $trainTitle = "Train n°" . $faker->numberBetween(100, 1000);
               $train->setTitle($trainTitle)
                     ->setDescription($faker->paragraph());

               $manager->persist($train);

               for ($j = 0; $j < mt_rand(4, 6); $j++) {
                    $ride = new Ride();
                    $ride->setDeparture($faker->city)
                    ->setArrival($faker->city)
                    ->setDepartureDateTime($faker->dateTimeThisYear())
                    ->setArrivalDateTime($faker->dateTimeThisYear())
                    ->setTrain($train);

                    $manager->persist($ride);

                    for ($k = 0; $k < mt_rand(3, 10); $k++) {
                         $booking = new Booking;

                         $booking->setUser($faker->name)
                                 ->setBookedAt(new \DateTime())
                                 ->setRide($ride);

                         $manager->persist($booking);
                    }
               }
          }

          $manager->flush();
    }
}
