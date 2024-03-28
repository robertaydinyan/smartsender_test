<?php

namespace App\Entity;

use App\Repository\ChannelRepository;
use Cassandra\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ChannelRepository::class)]
class Channel
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column]
    private ?int $enabled = null;

    #[ORM\Column]
    private ?int $email = null;

    #[ORM\Column]
    private ?int $sms = null;

    #[ORM\Column]
    private ?int $webpush = null;

    #[ORM\Column]
    private ?int $telegram = null;

    #[ORM\Column]
    private ?int $viber = null;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Customer", mappedBy="channels")
     */
    private $customers;

    public function __construct()
    {
        $this->customers = new ArrayCollection();
    }

    /**
     * @return Collection|Customer[]
     */
    public function getCustomers(): Collection
    {
        return $this->customers;
    }

    public function addCustomer(Customer $customer): self
    {
        if (!$this->customers->contains($customer)) {
            $this->customers[] = $customer;
            $customer->addChannel($this);
        }

        return $this;
    }

    public function removeCustomer(Customer $customer): self
    {
        if ($this->customers->removeElement($customer)) {
            $customer->removeChannel($this);
        }

        return $this;
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

    public function getEnabled(): ?int
    {
        return $this->enabled;
    }

    public function setEnabled(int $enabled): static
    {
        $this->enabled = $enabled;

        return $this;
    }

    public function getEmail(): ?int
    {
        return $this->email;
    }

    public function setEmail(int $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getSms(): ?int
    {
        return $this->sms;
    }

    public function setSms(int $sms): static
    {
        $this->sms = $sms;

        return $this;
    }

    public function getWebpush(): ?int
    {
        return $this->webpush;
    }

    public function setWebpush(int $webpush): static
    {
        $this->webpush = $webpush;

        return $this;
    }

    public function getTelegram(): ?int
    {
        return $this->telegram;
    }

    public function setTelegram(int $telegram): static
    {
        $this->telegram = $telegram;

        return $this;
    }

    public function getViber(): ?int
    {
        return $this->viber;
    }

    public function setViber(int $viber): static
    {
        $this->viber = $viber;

        return $this;
    }
}
