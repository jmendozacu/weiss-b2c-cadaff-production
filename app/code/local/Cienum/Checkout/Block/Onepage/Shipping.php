<?php

class Cienum_Checkout_Block_Onepage_Shipping extends Mage_Checkout_Block_Onepage_Shipping
{
	protected function _construct()
	{
        if(Mage::app()->getWebsite()->getCode() == 'pro')
            return parent::_construct();

        parent::_construct();
		if ($this->isCustomerLoggedIn()) {
			$this->getCheckout()->setStepData('shipping', 'allow', true);
		}
	}
	
	public function isUseShippingAddressForBilling()
    {
        // if (($this->getQuote()->getIsVirtual())
            // || !$this->getQuote()->getBillingAddress()->getSameAsShipping()) {
            // return false;
        // }
        return true;
    }
	
	public function getAddressesHtmlSelect($type)
    {
        if(Mage::app()->getWebsite()->getCode() == 'pro')
            return parent::getAddressesHtmlSelect($type);

        if ($this->isCustomerLoggedIn()) {
            $options = array();
            foreach ($this->getCustomer()->getAddresses() as $address) {
                $options[] = array(
                    'value' => $address->getId(),
                    'label' => $address->format('oneline')
                );
            }

            $addressId = $this->getAddress()->getCustomerAddressId();
            if (empty($addressId)) {
                if ($type=='billing') {
                    $address = $this->getCustomer()->getPrimaryBillingAddress();
                } else {
                    $address = $this->getCustomer()->getPrimaryShippingAddress();
                }
                if ($address) {
                    $addressId = $address->getId();
                }
            }

            $options[] = array(
                'value' => '',
                'label' => Mage::helper('checkout')->__('Nouvelle Adresse')
            );

            $html = '<ul class="addresses-list">';
            $isArrayOption = true;
            foreach($options as $key => $option) {
                if ($isArrayOption && is_array($option)) {
                    $value  = $option['value'];
                    $label  = (string)$option['label'];
                    $params = (!empty($option['params'])) ? $option['params'] : array();
                } else {
                    $value = (string)$key;
                    $label = (string)$option;
                    $isArrayOption = false;
                    $params = array();
                }

                $html .= $this->_optionToHtml(
                    array(
                        'value' => $value,
                        'label' => $label,
                        'js'    => 'onchange="'.$type.'.newAddress(!this.value)"',
                        'name'  => $type.'_address_id',
                        'params' => $params
                    ),
                    $value == $addressId
                );
            }
            $html .= '</ul>';
            return $html;

        }
        return '';
    }

    /**
     * Return option HTML node
     *
     * @param array $option
     * @param boolean $selected
     * @return string
     */
    protected function _optionToHtml($option, $selected = false)
    {
        $selectedHtml = $selected ? ' checked' : '';
        $active       = $selected ? ' active' : '';
        $params = '';
        if (!empty($option['params']) && is_array($option['params'])) {
            foreach ($option['params'] as $key => $value) {
                if (is_array($value)) {
                    foreach ($value as $keyMulti => $valueMulti) {
                        $params .= sprintf(' %s="%s" ', $keyMulti, $valueMulti);
                    }
                } else {
                    $params .= sprintf(' %s="%s" ', $key, $value);
                }
            }
        }

        $strong = $option['value'] ? '' : 'strong';
        $id = 'shipping-address-radio'.$option['value'] ;
        if($strong)
            $html = sprintf('<li class="control control-radio %s %s"><div class="block-check"><span class="empty-span"></span>
                        <input id="%s" name="%s" type="radio" value="%s"%s %s>
                        <span class="empty-span"></span>
                        <label for="%s"><strong>%s</strong></label>
                        </div>
                        </li>',
                $active,
                $strong,
                $id,
                $this->escapeHtml($option['name']),
                $this->escapeHtml($option['value']),
                $selectedHtml,
                $option['js'],
                $id,
                $this->escapeHtml($option['label'])
            );

        else
            $html = sprintf('<li class="control control-radio %s %s"><div class="block-check"><span class="empty-span"></span>
                            <input id="%s" name="%s" type="radio" value="%s"%s %s>
                            <span class="empty-span"></span>
                            <label for="%s">%s</label>
                            </div>
                            </li>',
                $active,
                $strong,
                $id,
                $this->escapeHtml($option['name']),
                $this->escapeHtml($option['value']),
                $selectedHtml,
                $option['js'],
                $id,
                $this->escapeHtml($option['label'])
                );

        return $html;
    }
}