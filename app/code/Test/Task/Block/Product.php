<?php
namespace Test\Task\Block;

use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Test\Task\Helper\Data;

class Product extends Template
{
    /**
     * @var Data
     */
    public $helper;

    /**
     * @var CollectionFactory
     */
    private $productCollectionFactory;

    /**
     * Product constructor.
     * @param Context $context
     * @param Data $helper
     * @param CollectionFactory $productCollectionFactory
     * @param array $data
     */
    public function __construct(
        Context $context,
        Data $helper,
        CollectionFactory $productCollectionFactory,
        array $data = []
    ) {
        $this->helper = $helper;
        $this->productCollectionFactory = $productCollectionFactory;
        parent::__construct($context, $data);
    }

    /**
     * Get product
     *
     * @return \Magento\Catalog\Model\Product|null
     */
    public function getProduct()
    {
        $productCollection = $this->productCollectionFactory->create();
        $productCollection->addAttributeToSelect('*');
        $productCollection->getSelect()->orderRand();
        $productCollection->setPageSize(1);
        return $productCollection->getFirstItem();
    }

    /**
     * Get buy button url
     *
     * @return string
     */
    public function getBuyUrl()
    {
        if ($this->helper->isRedirectToCheckout()) {
            return $this->_urlBuilder->getUrl('checkout/index/index');
        }
        return $this->getProduct()->getProductUrl();
    }

    /**
     * Get the template for the block
     *
     * @return string
     */
    public function getTemplate()
    {
        return 'Test_Task::product.phtml';
    }
}
