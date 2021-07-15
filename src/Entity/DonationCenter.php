<?php

namespace App\Entity;

use App\Repository\DonationCenterRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=DonationCenterRepository::class)
 */
class DonationCenter
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $address;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $photo;

    /**
     * @ORM\Column(type="datetime")
     */
    private $registeredAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updatedAt;

    /**
     * @ORM\OneToMany(targetEntity=Donation::class, mappedBy="donationCenter")
     */
    private $donationCenterDonations;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $location;

    public function __construct()
    {
        $this->registeredAt= new \DateTime('now');
        $this->donationCenterDonations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getPhoto(): ?string
    {
        return $this->photo;
    }

    public function setPhoto(?string $photo): self
    {
        $this->photo = $photo;

        return $this;
    }

    public function getRegisteredAt(): ?\DateTimeInterface
    {
        return $this->registeredAt;
    }

    public function setRegisteredAt(\DateTimeInterface $registeredAt): self
    {
        $this->registeredAt = $registeredAt;

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
     * @return Collection|Donation[]
     */
    public function getDonationCenterDonations(): Collection
    {
        return $this->donationCenterDonations;
    }

    public function addDonationCenterDonation(Donation $donationCenterDonation): self
    {
        if (!$this->donationCenterDonations->contains($donationCenterDonation)) {
            $this->donationCenterDonations[] = $donationCenterDonation;
            $donationCenterDonation->setDonationCenter($this);
        }

        return $this;
    }

    public function removeDonationCenterDonation(Donation $donationCenterDonation): self
    {
        if ($this->donationCenterDonations->removeElement($donationCenterDonation)) {
            // set the owning side to null (unless already changed)
            if ($donationCenterDonation->getDonationCenter() === $this) {
                $donationCenterDonation->setDonationCenter(null);
            }
        }

        return $this;
    }

    public function getLocation(): ?string
    {
        return $this->location;
    }

    public function setLocation(?string $location): self
    {
        $this->location = $location;

        return $this;
    }
}
