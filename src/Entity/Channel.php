<?php

namespace App\Entity;

use App\Constants\FormOptions;
use App\Repository\ChannelRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Form\FormEvent;

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

    #[ORM\OneToMany(targetEntity: ChannelCustomers::class, mappedBy: 'channel', orphanRemoval: true)]
    private Collection $channelCustomers;

    #[ORM\OneToMany(targetEntity: MessageHistory::class, mappedBy: 'channel', orphanRemoval: true)]
    private Collection $messageHistories;

    #[ORM\OneToOne(mappedBy: 'channel', cascade: ['persist', 'remove'])]

    public function __construct()
    {
        $this->channelCustomers = new ArrayCollection();
        $this->messageHistories = new ArrayCollection();
    }

    public function getCustomers()
    {
        return $this->channelCustomers->map(function($channelCustomer) {
            return $channelCustomer->getCustomer();
        })->toArray();
    }

    public function setCustomers($customers)
    {
        $this->customers = $customers;

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
            $channelCustomer->setChannel($this);
        }

        return $this;
    }

    public function removeChannelCustomer(ChannelCustomers $channelCustomer): static
    {
        if ($this->channelCustomers->removeElement($channelCustomer)) {
            // set the owning side to null (unless already changed)
            if ($channelCustomer->getChannel() === $this) {
                $channelCustomer->setChannel(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, MessageHistory>
     */
    public function getMessageHistories(): Collection
    {
        return $this->messageHistories;
    }

    public function addMessageHistory(MessageHistory $messageHistory): static
    {
        if (!$this->messageHistories->contains($messageHistory)) {
            $this->messageHistories->add($messageHistory);
            $messageHistory->setChannel($this);
        }

        return $this;
    }

    public function removeMessageHistory(MessageHistory $messageHistory): static
    {
        if ($this->messageHistories->removeElement($messageHistory)) {
            // set the owning side to null (unless already changed)
            if ($messageHistory->getChannel() === $this) {
                $messageHistory->setChannel(null);
            }
        }

        return $this;
    }

    public function getTypes() {
        $types = FormOptions::MESSAGE_OPTIONS;
        if ($this->email != 1) {
            unset($types[0]);
        }

        if ($this->sms != 1) {
            unset($types[1]);
        }

        if ($this->webpush != 1) {
            unset($types[2]);
        }

        if ($this->telegram != 1) {
            unset($types[3]);
        }

        if ($this->viber != 1) {
            unset($types[4]);
        }
        return $types;

    }
}
