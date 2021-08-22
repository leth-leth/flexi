<?php

namespace App\Services\Import;

use App\Entity\Customer;
use App\Repository\CustomerRepository;

class ImportCustomerService
{

    /**
     * @var CustomerRepository
     */
    private $customerRepository;

    private $importRequestApi;

    public function __construct(CustomerRepository $customerRepository, ImportRequestApi $importRequestApi)
    {
        $this->customerRepository = $customerRepository;
        $this->importRequestApi = $importRequestApi;
    }

    /**
     * @param string $nationality
     * @param string $limit
     * @throws \Exception
     */
    public function import($nationality, $limit)
    {
        try {
            $endpoint = sprintf("https://randomuser.me/api/?results=%s&nat=%s", $limit, $nationality);
            $results = $this->importRequestApi->getApiResponse($endpoint);
            $this->processResults($results);
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * @param $results
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    private function processResults($results) : void
    {
        foreach ($results->results as $result) {
            $record = [
                'firstName' => $result->name->first ?? '',
                'lastName' => $result->name->last ?? '',
                'email' => $result->email ?? '',
                'username' => $result->login->username ?? '',
                'password' => md5($result->login->password) ?? '',
                'gender' => $result->gender ?? '',
                'country' => $result->location->country ?? '',
                'city' => $result->location->city ?? '',
                'phone' => $result->phone ?? ''
            ];
            $this->upsertRecord($record);
        }
    }

    /**
     * @param array $record
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    private function upsertRecord(array $record)
    {
        $customer = $this->customerRepository->emailOfCustomer($record['email']);
        if (empty($customer)) {
            $customer = new Customer();
        }

        $this->customerRepository->flushData($this->customerRepository->prepareData($customer, $record));
    }
}
