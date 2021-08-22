<?php

namespace App\Http\Controllers;

use App\Services\CustomerService;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    /**
     * @var CustomerService
     */
    private $customerService;

    public function __construct(CustomerService $customerService)
    {
        $this->customerService = $customerService;
    }

    public function getAllCustomers()
    {
        $result = $this->customerService->getAllCustomers();
        return [
            'status' => 'success',
            'code' => 200,
            'results' => json_encode($result)
        ];
    }

    public function getCustomer(Request $request, $customerId)
    {
        $result = $this->customerService->getCustomer($customerId);
        return [
            'status' => 'success',
            'code' => 200,
            'results' => json_encode($result)
        ];
    }
}
