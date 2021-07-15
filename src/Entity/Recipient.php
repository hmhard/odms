<?php

namespace App\Entity;

use App\Repository\RecipientRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=RecipientRepository::class)
 */
class Recipient
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="recipients")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity=BloodType::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $bloodType;

    /**
     * @ORM\ManyToOne(targetEntity=OrganType::class, inversedBy="recipients")
     */
    private $organNeeded;

    /**
     * @ORM\OneToMany(targetEntity=Donation::class, mappedBy="recipient")
     */
    private $donations;

    /**
     * @ORM\OneToMany(targetEntity=Appointment::class, mappedBy="recipient")
     */
    private $appointments;

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

    public function getBloodType(): ?BloodType
    {
        return $this->bloodType;
    }

    public function setBloodType(?BloodType $bloodType): self
    {
        $this->bloodType = $bloodType;

        return $this;
    }

    public function getOrganNeeded(): ?OrganType
    {
        return $this->organNeeded;
    }

    public function setOrganNeeded(?OrganType $organNeeded): self
    {
        $this->organNeeded = $organNeeded;

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
            $donation->setRecipient($this);
        }

        return $this;
    }

    public function removeDonation(Donation $donation): self
    {
        if ($this->donations->removeElement($donation)) {
            // set the owning side to null (unless already changed)
            if ($donation->getRecipient() === $this) {
                $donation->setRecipient(null);
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
            $appointment->setRecipient($this);
        }

        return $this;
    }

    public function removeAppointment(Appointment $appointment): self
    {
        if ($this->appointments->removeElement($appointment)) {
            // set the owning side to null (unless already changed)
            if ($appointment->getRecipient() === $this) {
                $appointment->setRecipient(null);
            }
        }

        return $this;
    }
}
