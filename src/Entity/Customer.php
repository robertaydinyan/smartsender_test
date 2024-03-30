<?php

namespace App\Entity;

use App\Repository\CustomerRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;

#[ORM\Entity(repositoryClass: CustomerRepository::class)]
class Customer
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $lastname = null;

    #[ORM\Column(length: 255)]
    private ?string $phone_number = null;

    #[ORM\Column(length: 255)]
    private ?string $email = null;

    #[ORM\OneToMany(targetEntity: ChannelCustomers::class, mappedBy: 'customer', orphanRemoval: true)]
    private Collection $channelCustomers;


    public function __construct()
    {
        $this->channelCustomers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): static
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getPhoneNumber(): ?string
    {
        return $this->phone_number;
    }

    public function setPhoneNumber(string $phone_number): static
    {
        $this->phone_number = $phone_number;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return Collection<int, ChannelCustomers>
     */
    public function getChannelCustomers(): Collection
    {
        return $this->channelCustomers;
    }

    public function addChannelCustomer(ChannelCustomers $channelCustomer): static
    {
        if (!$this->channelCustomers->contains($channelCustomer)) {
            $this->channelCustomers->add($channelCustomer);
            $channelCustomer->setCustomer($this);
        }

        return $this;
    }

    public function removeChannelCustomer(ChannelCustomers $channelCustomer): static
    {
        if ($this->channelCustomers->removeElement($channelCustomer)) {
            // set the owning side to null (unless already changed)
            if ($channelCustomer->getCustomer() === $this) {
                $channelCustomer->setCustomer(null);
            }
        }

        return $this;
    }
}
