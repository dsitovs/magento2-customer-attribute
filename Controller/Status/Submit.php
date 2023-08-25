<?php declare(strict_types=1);

namespace TestExample\CustomerAttribute\Controller\Status;

use Magento\Customer\Model\Session as CustomerSession;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Controller\Result\RedirectFactory;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Message\ManagerInterface;
use Magento\Framework\Phrase;
use Magento\Framework\UrlInterface;
use TestExample\CustomerAttribute\Api\CustomerStatusInterface;

class Submit implements HttpPostActionInterface
{
    private ManagerInterface $messageManager;
    private UrlInterface $urlModel;
    private RedirectFactory $resultRedirectFactory;
    private CustomerSession $customerSession;
    private RequestInterface $request;
    private CustomerStatusInterface $customerStatus;

    public function __construct(
        ManagerInterface $messageManager,
        UrlInterface $urlModel,
        RedirectFactory $resultRedirectFactory,
        CustomerSession $customerSession,
        RequestInterface $request,
        CustomerStatusInterface $customerStatus
    ) {
        $this->messageManager = $messageManager;
        $this->urlModel = $urlModel;
        $this->resultRedirectFactory = $resultRedirectFactory;
        $this->customerSession = $customerSession;
        $this->request = $request;
        $this->customerStatus = $customerStatus;
    }

    /**
     * @return ResultInterface
     */
    public function execute(): ResultInterface
    {
        $resultRedirect = $this->resultRedirectFactory->create();

        try {
            if (!$this->customerSession->isLoggedIn()) {
                $url = $this->urlModel->getUrl('customer/account', ['_secure' => true]);
                return $resultRedirect->setUrl($url);
            }

            $newStatus = $this->request->getParam('status');
            $this->customerStatus->saveStatus($this->customerSession->getCustomer()->getDataModel(), $newStatus);
            $this->messageManager->addSuccessMessage(__('Your status has been updated.'));
        } catch (LocalizedException $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
        } catch (\Exception $e) {
            $this->messageManager->addExceptionMessage($e, __('Something went wrong when saving customer status.'));
        }

        return $resultRedirect->setUrl($this->urlModel->getUrl('*/*'));
    }
}
