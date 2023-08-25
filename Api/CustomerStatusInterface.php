<?php

namespace TestExample\CustomerAttribute\Api;

use Magento\Customer\Api\Data\CustomerInterface;

interface CustomerStatusInterface
{
    public const CUSTOMER_STATUS = 'customer_status';

    /**
     * @param CustomerInterface $customer
     * @return string|null
     */
    public function getStatus(CustomerInterface $customer): ?string;

    /**
     * @param CustomerInterface $customer
     * @param string|null $status
     * @return void
     */
    public function saveStatus(CustomerInterface $customer, ?string $status): void;
}
