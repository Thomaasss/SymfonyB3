<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\RideRepository")
 */
class Ride
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(min = 3, max = 255, minMessage = "3 caractères minimum !")
     */
    private $departure;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(min = 3, max = 255, minMessage = "3 caractères minimum !")
     */
    private $arrival;

    /**
     * @ORM\Column(type="datetime")
     */
    private $departureDateTime;

    /**
     * @ORM\Column(type="datetime")
     */
    private $arrivalDateTime;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Train", inversedBy="rides")
     * @ORM\JoinColumn(nullable=false)
     */
    private $train;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Booking", mappedBy="ride", orphanRemoval=true)
     */
    private $bookings;

    public function __construct()
    {
        $this->bookings = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDeparture(): ?string
    {
        return $this->departure;
    }

    public function setDeparture(string $departure): self
    {
        $this->departure = $departure;

        return $this;
    }

    public function getArrival(): ?string
    {
        return $this->arrival;
    }

    public function setArrival(string $arrival): self
    {
        $this->arrival = $arrival;

        return $this;
    }

    public function getDepartureDateTime(): ?\DateTimeInterface
    {
        return $this->departureDateTime;
    }

    public function setDepartureDateTime(\DateTimeInterface $departureDateTime): self
    {
        $this->departureDateTime = $departureDateTime;

        return $this;
    }

    public function getArrivalDateTime(): ?\DateTimeInterface
    {
        return $this->arrivalDateTime;
    }

    public function setArrivalDateTime(\DateTimeInterface $arrivalDateTime): self
    {
        $this->arrivalDateTime = $arrivalDateTime;

        return $this;
    }

    public function getTrain(): ?Train
    {
        return $this->train;
    }

    public function setTrain(?Train $train): self
    {
        $this->train = $train;

        return $this;
    }

    /**
     * @return Collection|Booking[]
     */
    public function getBookings(): Collection
    {
        return $this->bookings;
    }

    public function addBooking(Booking $booking): self
    {
        if (!$this->bookings->contains($booking)) {
            $this->bookings[] = $booking;
            $booking->setRide($this);
        }

        return $this;
    }

    public function removeBooking(Booking $booking): self
    {
        if ($this->bookings->contains($booking)) {
            $this->bookings->removeElement($booking);
            // set the owning side to null (unless already changed)
            if ($booking->getRide() === $this) {
                $booking->setRide(null);
            }
        }

        return $this;
    }
}
