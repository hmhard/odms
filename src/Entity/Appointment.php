<?php

namespace App\Entity;

use App\Repository\AppointmentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AppointmentRepository::class)
 */
class Appointment
{

    const APPOINTMENT_CREATED = 0;
    const APPOINTMENT_POSTPHONED = 1;
    const APPOINTMENT_APPROVED = 2;
    const APPOINTMENT_DONE = 3;
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $appointmentDate;

    /**
     * @ORM\ManyToOne(targetEntity=User::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $appointedBy;

    /**
     * @ORM\ManyToOne(targetEntity=Donor::class, inversedBy="appointments")
     */
    private $donor;

    /**
     * @ORM\ManyToOne(targetEntity=Recipient::class, inversedBy="appointments")
     */
    private $recipient;

    /**
     * @ORM\Column(type="integer")
     */
    private $status;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updatedAt;

    /**
     * @ORM\OneToMany(targetEntity=AppointmentConversation::class, mappedBy="appointment")
     */
    private $appointmentConversations;


    public function __construct()
    {
        $this->status = 0;
        $this->createdAt = new \DateTime('now');
        $this->appointmentConversations = new ArrayCollection();
    }
    public function __toString()
    {
        return $this->appointmentDate->format("F j Y, H:iA");
    }

    public function getStatusDesc()
    {
        if ($this->status == self::APPOINTMENT_CREATED)
            return "Created";
        if ($this->status == self::APPOINTMENT_POSTPHONED)
            return "POSTPHONED";
        if ($this->status == self::APPOINTMENT_APPROVED)
            return "APPROVED";
        if ($this->status == self::APPOINTMENT_DONE)
            return "DONE";
        return "Unknown";
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAppointmentDate(): ?\DateTimeInterface
    {
        return $this->appointmentDate;
    }

    public function setAppointmentDate(\DateTimeInterface $appointmentDate): self
    {
        $this->appointmentDate = $appointmentDate;

        return $this;
    }

    public function getAppointedBy(): ?User
    {
        return $this->appointedBy;
    }

    public function setAppointedBy(?User $appointedBy): self
    {
        $this->appointedBy = $appointedBy;

        return $this;
    }

    public function getDonor(): ?Donor
    {
        return $this->donor;
    }

    public function setDonor(?Donor $donor): self
    {
        $this->donor = $donor;

        return $this;
    }

    public function getRecipient(): ?Recipient
    {
        return $this->recipient;
    }

    public function setRecipient(?Recipient $recipient): self
    {
        $this->recipient = $recipient;

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

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * @return Collection|AppointmentConversation[]
     */
    public function getAppointmentConversations(): Collection
    {
        return $this->appointmentConversations;
    }

    public function addAppointmentConversation(AppointmentConversation $appointmentConversation): self
    {
        if (!$this->appointmentConversations->contains($appointmentConversation)) {
            $this->appointmentConversations[] = $appointmentConversation;
            $appointmentConversation->setAppointment($this);
        }

        return $this;
    }

    public function removeAppointmentConversation(AppointmentConversation $appointmentConversation): self
    {
        if ($this->appointmentConversations->removeElement($appointmentConversation)) {
            // set the owning side to null (unless already changed)
            if ($appointmentConversation->getAppointment() === $this) {
                $appointmentConversation->setAppointment(null);
            }
        }

        return $this;
    }
}
