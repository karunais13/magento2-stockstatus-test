<?php
  namespace Karunais\StockStatus\Controller\Adminhtml\StockList;

  class Index extends \Magento\Backend\App\Action
  {
    /**
    * @var \Magento\Framework\View\Result\PageFactory
    */
    protected $resultPageFactory;

    /**
     * Constructor
     *
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory
    ) {
         parent::__construct($context);
         $this->resultPageFactory = $resultPageFactory;
    }
    /**
     * Load the page defined in view/adminhtml/layout
     *
     * @return \Magento\Framework\View\Result\Page
     */
    public function execute()
    {
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('Karunais_StockStatus::stockstatus');
        $resultPage->addBreadcrumb(__('Stock Status'), __('Stock Status'));
        $resultPage->getConfig()->getTitle()->prepend(__('Stock Status'));
        return  $resultPage;
    }
  }
?>
