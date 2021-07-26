<?php

namespace App\Entity;

use App\Repository\DonorRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=DonorRepository::class)
 */
class Donor
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="donors",cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity=OrganType::class, inversedBy="donors",cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $organ;

    /**
     * @ORM\OneToMany(targetEntity=Donation::class, mappedBy="donor")
     */
    private $donations;

    /**
     * @ORM\OneToMany(targetEntity=Appointment::class, mappedBy="donor")
     */
    private $appointments;

    /**
     * @ORM\ManyToOne(targetEntity=BloodType::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $bloodType;

    /**
     * @ORM\ManyToOne(targetEntity=DonationCenter::class, inversedBy="donors")
     */
    private $donationCenter;

    /**
     * @ORM\Column(type="integer",nullable=true)
     */
    private $status;

    public function __construct()
    {
        
        $this->donations = new ArrayCollection();
        $this->appointments = new ArrayCollection();
    }
    public function __toString()
    {
     return $this->user;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getOrgan(): ?OrganType
    {
        return $this->organ;
    }

    public function setOrgan(?OrganType $organ): self
    {
        $this->organ = $organ;

        return $this;
    }

    /**
     * @return Collection|Donation[]
     */
    public function getDonations(): Collection
    {
        return $this->donations;
    }

    public function addDonation(Donation $donation): self
    {
        if (!$this->donations->contains($donation)) {
            $this->donations[] = $donation;
            $donation->setDonor($this);
        }

        return $this;
    }

    public function removeDonation(Donation $donation): self
    {
        if ($this->donations->removeElement($donation)) {
            // set the owning side to null (unless already changed)
            if ($donation->getDonor() === $this) {
                $donation->setDonor(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Appointment[]
     */
    public function getAppointments(): Collection
    {
        return $this->appointments;
    }

    public function addAppointment(Appointment $appointment): self
    {
        if (!$this->appointments->contains($appointment)) {
            $this->appointments[] = $appointment;
            $appointment->setDonor($this);
        }

        return $this;
    }

    public function removeAppointment(Appointment $appointment): self
    {
        if ($this->appointments->removeElement($appointment)) {
            // set the owning side to null (unless already changed)
            if ($appointment->getDonor() === $this) {
                $appointment->setDonor(null);
            }
        }

        return $this;
    }

    public function getBloodType(): ?BloodType
    {
        return $this->bloodType;
    }

    public function setBloodType(?BloodType $bloodType): self
    {
        $this->bloodType = $bloodType;

        return $this;
    }

    public function getDonationCenter(): ?DonationCenter
    {
        return $this->donationCenter;
    }

    public function setDonationCenter(?DonationCenter $donationCenter): self
    {
        $this->donationCenter = $donationCenter;

        return $this;
    }

    public function getStatus(): ?int
    {
        return $this->status;
    }

    public function setStatus(int $status): self
    {
        $this->status = $status;

        return $this;
    }
}
