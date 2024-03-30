<?php

namespace App\Event;

use App\Entity\Customer;
use Symfony\Contracts\EventDispatcher\Event;

class CustomerRegisteredEvent extends Event
{
    public const NAME = 'customer.registered';

    private $customer;

    public function __construct(Customer $customer)
    {
        $this->customer = $customer;
    }

    public function getCustomer(): Customer
    {
        return $this->customer;
    }
}
