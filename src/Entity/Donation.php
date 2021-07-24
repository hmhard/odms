<?php

namespace App\Entity;

use App\Repository\DonationRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=DonationRepository::class)
 */
class Donation
{
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
}
