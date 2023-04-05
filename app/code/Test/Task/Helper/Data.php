<?php
namespace Test\Task\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Store\Model\ScopeInterface;

class Data extends AbstractHelper
{
    const XML_PATH_ENABLED = 'task/general/enabled';
    const XML_PATH_BLOCK_TITLE = 'task/general/block_title';
    const XML_PATH_REDIRECT_TO_CHECKOUT = 'task/general/redirect_to_checkout';

    /**
     * Check if the extension is enabled
     *
     * @return bool
     */
    public function isEnabled()
    {
        return $this->scopeConfig->isSetFlag(self::XML_PATH_ENABLED, ScopeInterface::SCOPE_STORE);
    }

    /**
     * Check if the "Redirect directly to checkout" option is enabled
     *
     * @return bool
     */
    public function isRedirectToCheckout()
    {
        return $this->scopeConfig->isSetFlag(self::XML_PATH_REDIRECT_TO_CHECKOUT, ScopeInterface::SCOPE_STORE);
    }

    /**
     * Get block title
     *
     * @return string
     */
    public function getBlockTitle()
    {
        $title = $this->scopeConfig->getValue(self::XML_PATH_BLOCK_TITLE, ScopeInterface::SCOPE_STORE);
        if (empty($title)) {
            $title = __('Featured Product');
        }
        return $title;
    }
}
