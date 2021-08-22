<?php

namespace App\Services;

use App\Repository\CustomerRepository;

class CustomerService
{
    /**
     * @var CustomerRepository
     */
    private $customerRepository;

    public function __construct(CustomerRepository $customerRepository)
    {
        $this->customerRepository = $customerRepository;
    }

    /**
     * @return array
     */
    public function getAllCustomers(): array
    {
        return $this->customerRepository->findAll();
    }

    /**
     * @param $customerId
     * @return array
     */
    public function getCustomer($customerId) : array
    {
        return $this->customerRepository->customerOfId($customerId);
    }
}
