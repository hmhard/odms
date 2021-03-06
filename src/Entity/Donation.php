<?php

namespace App\Entity;

use App\Repository\DonationRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=DonationRepository::class)
 */
class Donation
{
    const DONATION_CREATED=0;
    const DONATION_DONE=1;
    const DONATION_CANCELLED=2;
    const DONATION_APPROVED=3;
    const DONATION_FINISHED=4;
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Donor::class, inversedBy="donations")
     * @ORM\JoinColumn(nullable=false)
     */
    private $donor;

    /**
     * @ORM\ManyToOne(targetEntity=Recipient::class, inversedBy="donations")
     * @ORM\JoinColumn(nullable=false)
     */
    private $recipient;

    /**
     * @ORM\ManyToOne(targetEntity=DonationCenter::class, inversedBy="donationCenterDonations")
     * @ORM\JoinColumn(nullable=false)
     */
    private $donationCenter;

    /**
     * @ORM\ManyToOne(targetEntity=OrganType::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $organ;

    /**
     * @ORM\ManyToOne(targetEntity=User::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $processedBy;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private $processedAt;

    /**
     * @ORM\ManyToOne(targetEntity=User::class)
     */
    private $followedBy;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $donorStatus;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $recipientStatus;

    /**
     * @ORM\Column(type="integer")
     */
    private $status;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $followerFeedback;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $donorFeedback;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $recipientFeedback;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $doctorFeedback;

    public function __construct()
    {
        $this->status = 0;
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getDonationCenter(): ?DonationCenter
    {
        return $this->donationCenter;
    }

    public function setDonationCenter(?DonationCenter $donationCenter): self
    {
        $this->donationCenter = $donationCenter;

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

    public function getProcessedBy(): ?User
    {
        return $this->processedBy;
    }

    public function setProcessedBy(?User $processedBy): self
    {
        $this->processedBy = $processedBy;

        return $this;
    }

    public function getProcessedAt(): ?\DateTimeImmutable
    {
        return $this->processedAt;
    }

    public function setProcessedAt(\DateTimeImmutable $processedAt): self
    {
        $this->processedAt = $processedAt;

        return $this;
    }

    public function getFollowedBy(): ?User
    {
        return $this->followedBy;
    }

    public function setFollowedBy(?User $followedBy): self
    {
        $this->followedBy = $followedBy;

        return $this;
    }

    public function getDonorStatus(): ?string
    {
        return $this->donorStatus;
    }

    public function setDonorStatus(?string $donorStatus): self
    {
        $this->donorStatus = $donorStatus;

        return $this;
    }

    public function getRecipientStatus(): ?string
    {
        return $this->recipientStatus;
    }

    public function setRecipientStatus(?string $recipientStatus): self
    {
        $this->recipientStatus = $recipientStatus;

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

    public function getFollowerFeedback(): ?string
    {
        return $this->followerFeedback;
    }

    public function setFollowerFeedback(?string $followerFeedback): self
    {
        $this->followerFeedback = $followerFeedback;

        return $this;
    }

    public function getDonorFeedback(): ?string
    {
        return $this->donorFeedback;
    }

    public function setDonorFeedback(?string $donorFeedback): self
    {
        $this->donorFeedback = $donorFeedback;

        return $this;
    }

    public function getRecipientFeedback(): ?string
    {
        return $this->recipientFeedback;
    }

    public function setRecipientFeedback(?string $recipientFeedback): self
    {
        $this->recipientFeedback = $recipientFeedback;

        return $this;
    }

    public function getDoctorFeedback(): ?string
    {
        return $this->doctorFeedback;
    }

    public function setDoctorFeedback(?string $doctorFeedback): self
    {
        $this->doctorFeedback = $doctorFeedback;

        return $this;
    }
}
