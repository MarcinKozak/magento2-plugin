<?php
/**
 * @license Copyright 2011-2014 BitPay Inc., MIT License
 * @see https://github.com/bitpay/magento-plugin/blob/master/LICENSE
 * 
 * TODO: Finish this iFrame implemenation... :/
 */

namespace Bitpay\Core\Block;

class Iframe extends \Magento\Framework\View\Element\Template
{

    protected $_bitpayModel;
    /**
     * @var \Bitpay\Core\Helper\Data
     */
    protected $_dataHelper;

    

    /**
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param \Bitpay\Core\Model\Invoice $_bitpayModel
     * @param \Bitpay\Core\Helper\Data $_dataHelper
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Bitpay\Core\Model\Invoice $_bitpayModel,
        \Bitpay\Core\Helper\Data $_dataHelper,
        array $data = []
    ) {
        
         $this->_bitpayModel = $_bitpayModel;
        $this->_dataHelper = $_dataHelper;
        parent::__construct($context,$data);
    }

    

     /**
    *
    *
    **/
    protected function getHelper()
    {
        $bitpayHelper = $this->_dataHelper;
        return $bitpayHelper;
    }

    /**
     * create an invoice and return the url so that iframe.phtml can display it
     *
     * @return string
     */
    public function getFrameActionUrl()
    {
        $last_success_quote_id = $this->getLastQuoteId();
        $invoiceFactory = $this->_bitpayModel;
        $invoice = $invoiceFactory->load($last_success_quote_id,'quote_id');
        return $invoice->getData('url').'&view=iframe';
    }

    public function getLastQuoteId()
    {
        $objectmanager = \Magento\Framework\App\ObjectManager::getInstance();
        $quote = $objectmanager->get('\Magento\Checkout\Model\Session');
        return $quote->getData('last_success_quote_id');
    }

    public function getValidateUrl()
    {
        $validateUrl = $this->getUrl('bitpay/index/index');
        return $validateUrl;
    }

    public function getSuccessUrl()
    {
        $successUrl = $this->getUrl('checkout/onepage/success');
        return $successUrl;
    }
}
