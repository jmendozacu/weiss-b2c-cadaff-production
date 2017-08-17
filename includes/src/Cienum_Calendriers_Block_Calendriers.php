<?php
class Cienum_Calendriers_Block_Calendriers extends Mage_Adminhtml_Block_Template
{
	public function getConfig()
	{
		return json_decode(Mage::getStoreConfig('calendriers/calendriers'), true);
	}
	
	public function getDays()
	{
		return ['dimanche', 'lundi', 'mardi', 'mercredi', 'jeudi', 'vendredi', 'samedi'];
	}
	
	public function getCarriers()
	{
		
		$methods = array();
				
		$carriers = Mage::getSingleton('shipping/config')->getActiveCarriers('1');
		ksort($carriers);
		foreach ($carriers as $carrierCode=>$carrierModel) 
		{
			if(strpos($carrierCode, 'owebia') !== 0 || strpos($carrierCode, 'owebiashipping4') === 0)
				continue;
			if (!$carrierModel->isActive() && (bool)$isActiveOnlyFlag === true)
				continue;
			$carrierMethods = $carrierModel->getAllowedMethods();
			if (!$carrierMethods)
				continue;
			$carrierTitle = Mage::getStoreConfig('carriers/'.$carrierCode.'/title');
			foreach ($carrierMethods as $methodCode => $methodTitle) 
			{
				$methods[] = array(
					'value' => $carrierCode.'_'.$methodCode,
					'label' => $carrierTitle.' '.$methodTitle,
				);
			}
		}

        return $methods;
	}
}