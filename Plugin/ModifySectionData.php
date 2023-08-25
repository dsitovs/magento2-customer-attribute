<?php declare(strict_types=1);

namespace TestExample\CustomerAttribute\Plugin;

use Magento\Customer\CustomerData\Customer;
use Magento\Customer\Model\Session as CustomerSession;
use TestExample\CustomerAttribute\Api\CustomerStatusInterface;

class ModifySectionData
{
    private CustomerSession $customerSession;
    private CustomerStatusInterface $customerStatus;

    /**
     * @param CustomerSession $customerSession
     * @param CustomerStatusInterface $customerStatus
     */
    public function __construct(CustomerSession $customerSession, CustomerStatusInterface $customerStatus)
    {
        $this->customerSession = $customerSession;
        $this->customerStatus = $customerStatus;
    }

    /**
     * @param Customer $subject
     * @param array $result
     * @return array
     */
    public function afterGetSectionData(Customer $subject, array $result): array
    {
        if (!empty($result)) {
            $result[CustomerStatusInterface::CUSTOMER_STATUS] = $this->customerStatus->getStatus($this->customerSession->getCustomer()->getDataModel());
        }

        return $result;
    }
}
