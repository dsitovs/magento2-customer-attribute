<?php declare(strict_types=1);

namespace TestExample\CustomerAttribute\Block;

use Magento\Customer\Model\Session as CustomerSession;
use Magento\Framework\View\Element\Template;
use TestExample\CustomerAttribute\Api\CustomerStatusInterface;

class Form extends Template
{
    private CustomerSession $customerSession;
    private CustomerStatusInterface $customerStatus;

    /**
     * @param Template\Context $context
     * @param CustomerSession $customerSession
     * @param CustomerStatusInterface $customerStatus
     * @param array $data
     */
    public function __construct(Template\Context $context, CustomerSession $customerSession, CustomerStatusInterface $customerStatus, array $data = [])
    {
        parent::__construct($context, $data);

        $this->customerSession = $customerSession;
        $this->customerStatus = $customerStatus;
    }

    /**
     * @return string
     */
    public function getPostActionUrl(): string
    {
        return $this->getUrl('customer_attribute/status/submit');
    }

    /**
     * @return string|null
     */
    public function getCustomerStatus(): ?string
    {
        return $this->customerStatus->getStatus($this->customerSession->getCustomer()->getDataModel());
    }
}
