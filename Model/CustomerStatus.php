<?php declare(strict_types=1);

namespace TestExample\CustomerAttribute\Model;

use Magento\Customer\Api\CustomerRepositoryInterface;
use Magento\Customer\Api\Data\CustomerInterface;
use Magento\Framework\Exception\InputException;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\State\InputMismatchException;
use TestExample\CustomerAttribute\Api\CustomerStatusInterface;

class CustomerStatus implements CustomerStatusInterface
{
    const MAX_LENGTH = 255;
    private CustomerRepositoryInterface $customerRepository;

    /**
     * @param CustomerRepositoryInterface $customerRepository
     */
    public function __construct(
        CustomerRepositoryInterface $customerRepository
    ) {
        $this->customerRepository = $customerRepository;
    }

    /**
     * @param CustomerInterface $customer
     * @return string|null
     */
    public function getStatus(CustomerInterface $customer): ?string
    {
        $statusAttribute = $customer->getCustomAttribute(self::CUSTOMER_STATUS);

        return ($statusAttribute?->getValue());
    }

    /**
     * @param CustomerInterface $customer
     * @param string|null $status
     * @return void
     * @throws InputException
     * @throws LocalizedException
     * @throws InputMismatchException
     */
    public function saveStatus(CustomerInterface $customer, ?string $status): void
    {
        $value = $this->validateAndSanitize($status);
        $customer->setCustomAttribute(self::CUSTOMER_STATUS, $value);

        $this->customerRepository->save($customer);
    }

    /**
     * @throws InputException
     */
    private function validateAndSanitize($status): string
    {
        $result = trim($status);

        if (strlen($result) > self::MAX_LENGTH) {
            throw new InputException(__('Only 255 characters or less are allowed.'));
        }

        return $result;
    }
}
