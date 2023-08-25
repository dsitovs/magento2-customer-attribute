<?php declare(strict_types=1);

namespace TestExample\CustomerAttribute\Controller\Status;

use Magento\Customer\Model\Session as CustomerSession;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\Result\RedirectFactory;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Message\ManagerInterface;
use Magento\Framework\UrlInterface;
use Magento\Framework\View\Result\PageFactory;

class Index implements HttpGetActionInterface
{
    private PageFactory $resultPageFactory;
    private ManagerInterface $messageManager;
    private UrlInterface $urlModel;
    private RedirectFactory $resultRedirectFactory;
    private CustomerSession $customerSession;

    /**
     * @param ManagerInterface $messageManager
     * @param UrlInterface $urlModel
     * @param RedirectFactory $resultRedirectFactory
     * @param CustomerSession $customerSession
     * @param PageFactory $resultPageFactory
     */
    public function __construct(
        ManagerInterface $messageManager,
        UrlInterface $urlModel,
        RedirectFactory $resultRedirectFactory,
        CustomerSession $customerSession,
        PageFactory $resultPageFactory
    ) {
        $this->messageManager = $messageManager;
        $this->urlModel = $urlModel;
        $this->resultRedirectFactory = $resultRedirectFactory;
        $this->customerSession = $customerSession;
        $this->resultPageFactory = $resultPageFactory;
    }

    /**
     * @return ResultInterface|ResponseInterface
     */
    public function execute(): ResultInterface|ResponseInterface
    {
        if (!$this->customerSession->isLoggedIn()) {
            $resultRedirect = $this->resultRedirectFactory->create();
            $url = $this->urlModel->getUrl('customer/account', ['_secure' => true]);
            $this->messageManager->addErrorMessage(__('Please login to proceed.'));

            return $resultRedirect->setUrl($url);
        }

        return $this->resultPageFactory->create();
    }
}
