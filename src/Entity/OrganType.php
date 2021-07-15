<?php

namespace App\Entity;

use App\Repository\OrganTypeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=OrganTypeRepository::class)
 */
class OrganType
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
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private $registeredAt;

    /**
     * @ORM\OneToMany(targetEntity=Recipient::class, mappedBy="organNeeded")
     */
    private $recipients;

    /**
     * @ORM\OneToMany(targetEntity=Donor::class, mappedBy="organ")
     */
    private $donors;

    public function __construct()
    {
        $this->registeredAt= new \DateTimeImmutable();
        $this->recipients = new ArrayCollection();
        $this->donors = new ArrayCollection();
    }


    public function __toString()
{
    return $this->name;
    

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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getRegisteredAt(): ?\DateTimeImmutable
    {
        return $this->registeredAt;
    }

    public function setRegisteredAt(\DateTimeImmutable $registeredAt): self
    {
        $this->registeredAt = $registeredAt;

        return $this;
    }

    /**
     * @return Collection|Recipient[]
     */
    public function getRecipients(): Collection
    {
        return $this->recipients;
    }

    public function addRecipient(Recipient $recipient): self
    {
        if (!$this->recipients->contains($recipient)) {
            $this->recipients[] = $recipient;
            $recipient->setOrganNeeded($this);
        }

        return $this;
    }

    public function removeRecipient(Recipient $recipient): self
    {
        if ($this->recipients->removeElement($recipient)) {
            // set the owning side to null (unless already changed)
            if ($recipient->getOrganNeeded() === $this) {
                $recipient->setOrganNeeded(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Donor[]
     */
    public function getDonors(): Collection
    {
        return $this->donors;
    }

    public function addDonor(Donor $donor): self
    {
        if (!$this->donors->contains($donor)) {
            $this->donors[] = $donor;
            $donor->setOrgan($this);
        }

        return $this;
    }

    public function removeDonor(Donor $donor): self
    {
        if ($this->donors->removeElement($donor)) {
            // set the owning side to null (unless already changed)
            if ($donor->getOrgan() === $this) {
                $donor->setOrgan(null);
            }
        }

        return $this;
    }
}
