<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Ride;
use App\Repository\RideRepository;
use App\Entity\Train;
use App\Repository\TrainRepository;
use App\Entity\Booking;
use App\Repository\BookingRepository;

// FORM USES
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use App\Form\RideType;
use App\Form\TrainType;
use App\Form\BookingType;

class ReservationController extends AbstractController
{
    /**
     * @Route("/reservation", name="reservation")
     */
    public function index(RideRepository $repo)
    {
        $rides = $repo->findAll();

        return $this->render('reservation/index.html.twig', [
            'rides' => $rides
        ]);
    }

    /**
     * @Route("/", name="home")
     */
    public function home()
    {
        return $this->render('reservation/home.html.twig', [
        ]);
    }

    /**
     * @Route("/trains", name="trains")
     */
    public function trains(TrainRepository $repo, Train $train = null, request $request, ObjectManager $manager)
    {
        $trains = $repo->findAll();

        $train = new Train();

        $form = $this->createForm(TrainType::class, $train);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $manager->persist($train);
            $manager->flush();

            return $this->redirectToRoute('trains');
        }

        return $this->render('reservation/trains.html.twig', [
            'formTrain' => $form->createView(),
            'trains' => $trains
        ]);
    }

    /**
     * @Route("/booking/new", name="booking_create")
     * * @Route("/booking/{id}/edit", name="booking_edit")
     */
    public function form(Ride $ride = null, request $request, ObjectManager $manager) {

        if(!$ride) {
            $ride = new Ride();
        }

        $form = $this->createForm(RideType::class, $ride);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $manager->persist($ride);
            $manager->flush();

            return $this->redirectToRoute('booking', ['id' => $ride->getId()]);
        }
        return $this->render('reservation/create.html.twig', [
            'formBooking' => $form->createView(),
            'editMode' => $ride->getId() !== null
        ]);
    }

    /**
     * @Route("/booking/{id}", name="booking")
     */
    public function booking(Ride $ride, Booking $booking = null, request $request, ObjectManager $manager)
    {
        $booking = new Booking();

        $form = $this->createForm(BookingType::class, $booking);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $booking->setRide($ride)
                    ->setBookedAt(new \DateTime());
            $manager->persist($booking);
            $manager->flush();

            return $this->redirectToRoute('booking', ['id' => $ride->getId()]);
        }

        return $this->render('reservation/booking.html.twig', [
            'formBooking' => $form->createView(),
            'ride' => $ride
        ]);
    }
}
