<?php

class Pektsekye_OptionExtended_Model_Product_Option_Type_Select extends Mage_Catalog_Model_Product_Option_Type_Select
{

    public function isCustomizedView()
    {
      return $this->canDisplayOptionImages();         
    }

    /**
     * Return option html
     *
     * @param array $optionInfo
     * @return string
     */
    public function getCustomizedView($optionInfo)
    {		 
        return $optionInfo['value'];
    }	

	
    /**
     * Return printable option value
     *
     * @param string $optionValue Prepared for cart option value
     * @return string
     */
    public function getPrintableOptionValue($optionValue)
    {
        return parent::getFormattedOptionValue($optionValue);
    }

    	
    public function getFormattedOptionValue($optionValue)
    {

			$formattedValue = parent::getFormattedOptionValue($optionValue);
 			
      if ($this->canDisplayOptionImages()){
			  $option = $this->getOption();	
			  if (!$this->_isSingleSelection()) {
				  $formattedValues = explode(', ', $formattedValue);
			    $result = '';				  
				  foreach (explode(',', $optionValue) as $k => $valueId) {
				  
				    $result .= ($k > 0 ? ', ' : '') . $formattedValues[$k];
				    if (!is_null($option->getValueById($valueId))){
				    	$image = $option->getValueById($valueId)->getImage();
				    	if (is_null($image))
    				  	$image = Mage::getModel('optionextended/value')->load($valueId, 'option_type_id')->getImage();
					    if ($image != '')				
						    $result .= $this->makeImage($image);
						}
				  }
				  $formattedValue = $result;
			  } else {
				  if (!is_null($option->getValueById($optionValue))){			  
			      $image = $option->getValueById($optionValue)->getImage();
			    	if (is_null($image))
				    	$image = Mage::getModel('optionextended/value')->load($optionValue, 'option_type_id')->getImage();			    
				    if ($image != '')
					    $formattedValue .= $this->makeImage($image);
					}
			  }		  		  
      }
           
      return $formattedValue;
      			
   }


    public function makeImage($image)
    {    						
			$url = Mage::helper('catalog/image')->init(Mage::getModel('catalog/product'), 'thumbnail', $image)->resize(45,45)->__toString();
			return  '<img src="'.$url.'" style="vertical-align:middle;margin:5px;">';
    }


     public function canDisplayOptionImages()
    {	
      $request = Mage::app()->getRequest();
      $path = $request->getModuleName() .'_'. $request->getControllerName() .'_'. $request->getActionName(); 
         	 
      return Mage::getStoreConfig('checkout/cart/custom_option_images') == 1 && $path == 'checkout_cart_index';
    }	 

    /**
     *
     * Validate user input for option
     *
     * @throws Mage_Core_Exception
     * @param array $values All product option values, i.e. array (option_id => mixed, option_id => mixed...)
     * @return Mage_Catalog_Model_Product_Option_Type_Default
     */
    public function validateUserValue($values)
    {
        Mage_Catalog_Model_Product_Option_Type_Default::validateUserValue($values);

        $option = $this->getOption();
        $value = $this->getUserValue();

        if (empty($value) && $option->getIsRequire() && !$this->getProduct()->getSkipCheckRequiredOption()) {
            $this->setIsValid(false);
            Mage::throwException(Mage::helper('catalog')->__('Please specify the product required option(s)'));
        }

        if (!empty($value)){
			    if (!$this->_isSingleSelection()) {			  
				    foreach ($value as $valueId)
				    	if (is_null($option->getValueById($valueId)))
                  Mage::throwException(Mage::helper('catalog')->__('Please specify the product required option(s)'));              						  				    
			    } else {
			    	if (is_null($option->getValueById($value))) 
              Mage::throwException(Mage::helper('catalog')->__('Please specify the product required option(s)'));            		
			    }	
        }
        
        return $this;
    }   

    /**
     * Return Price for selected option
     *
     * @param string $optionValue Prepared for cart option value
     * @return float
     */
    public function getOptionPrice($optionValue, $basePrice)
    {
        $option = $this->getOption();
        $result = 0;

        if (!$this->_isSingleSelection()) {
            foreach(explode(',', $optionValue) as $value) {
				    	if (!is_null($option->getValueById($value))) {            
                $result += $this->_getChargableOptionPrice(
                    $option->getValueById($value)->getPrice(),
                    $option->getValueById($value)->getPriceType() == 'percent',
                    $basePrice
                );
              }  
            }
        } elseif ($this->_isSingleSelection()) {
				  if (!is_null($option->getValueById($optionValue))) {          
            $result = $this->_getChargableOptionPrice(
                $option->getValueById($optionValue)->getPrice(),
                $option->getValueById($optionValue)->getPriceType() == 'percent',
                $basePrice
            );
          }
        }

        return $result;
    }

    /**
     * Return SKU for selected option
     *
     * @param string $optionValue Prepared for cart option value
     * @param string $skuDelimiter Delimiter for Sku parts
     * @return string
     */
    public function getOptionSku($optionValue, $skuDelimiter)
    {
        $option = $this->getOption();
        $result = '';
        if (!$this->_isSingleSelection()) {
            $skus = array();
            foreach(explode(',', $optionValue) as $value) {
            	if (!is_null($option->getValueById($value))) {  
                if ($optionSku = $option->getValueById($value)->getSku()) {
                    $skus[] = $optionSku;
                }
              }
            }
            $result = implode($skuDelimiter, $skus);
        } else {
				  if (!is_null($option->getValueById($optionValue)))           
            $result = $option->getValueById($optionValue)->getSku();
        } 

        return $result;
    } 

    /**
     * Return formatted option value ready to edit, ready to parse
     *
     * @param string $optionValue Prepared for cart option value
     * @return string
     */
    public function getEditableOptionValue($optionValue)
    {
        $option = $this->getOption();
        $result = '';
        if (!$this->_isSingleSelection()) {
            foreach (explode(',', $optionValue) as $_value) {
            	if (!is_null($option->getValueById($_value)))            
                $result .= $option->getValueById($_value)->getTitle() . ', ';
            }
            $result = Mage::helper('core/string')->substr($result, 0, -2);
        } elseif ($this->_isSingleSelection()) {
				  if (!is_null($option->getValueById($optionValue)))         
            $result = $option->getValueById($optionValue)->getTitle();
        } 
        return $result;
    }
           

}
