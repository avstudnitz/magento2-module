<?php
/**
 * Created by PhpStorm.
 * User: SebastianN
 * Date: 09.02.17
 * Time: 16:00
 */

namespace RatePAY\Payment\Helper\Content\Customer;


use Magento\Framework\App\Helper\Context;

class Contacts extends \Magento\Framework\App\Helper\AbstractHelper
{
    /**
     * @var \Magento\Checkout\Model\Session
     */
    protected $_checkoutSession;

    /**
     * Contacts constructor.
     * @param Context $context
     */
    public function __construct(Context $context,
                                \Magento\Checkout\Model\Session\Proxy $checkoutSession)
    {
        parent::__construct($context);
        $this->_checkoutSession = $checkoutSession;
    }

    /**
     * Build Contacts Block of Payment Request
     *
     * @param $quoteOrOrder
     * @return array
     */
    public function setContacts($quoteOrOrder)
    {
        $content = [
            'Email' => $quoteOrOrder->getCustomerEmail(),
        ];

        /*if (!empty($this->_checkoutSession->getRatepayPhone())) {
            $content['Phone']['DirectDial'] = $this->_checkoutSession->getRatepayPhone();
        } else {
            $content['Phone']['DirectDial'] = $quoteOrOrder->getBillingAddress()->getTelephone();
        }*/

        if (!empty($this->_checkoutSession->getRatepayPhone())) {
            $content['Phone']['DirectDial'] = $this->_checkoutSession->getRatepayPhone();
        } elseif (!empty($quoteOrOrder->getBillingAddress()->getTelephone())) {
            $content['Phone']['DirectDial'] = $quoteOrOrder->getBillingAddress()->getTelephone();
        } else { // Mock of RatePAY phone number in case of missing customer phone number
            $content['Phone']['AreaCode'] = "030";
            $content['Phone']['DirectDial'] = "33988560";
        }

        return $content;
    }
}
