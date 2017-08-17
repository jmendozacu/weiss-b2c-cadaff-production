<?php
class Cienum_Calendriers_CalendriersController extends Mage_Adminhtml_Controller_Action
{
	
	public function indexAction()
	{
		$this->loadLayout();
        $this->renderLayout();
	}
	
	public function saveCalendriersAction()
	{
		if (!$this->_validateFormKey()) {
            $this->_redirect('*/*/');
            return;
        }
		$post = $this->getRequest()->getPost();
		// var_dump($post);die;
		$config['feries'] = array_map(function($n){return implode('-', array_reverse(explode('-', $n)));}, $post['feries']);
		foreach($post['modes'] as $code => $mode)
		{
			$config['modes'][$code]['hlimite'] = $mode['hlimite'];
			$config['modes'][$code]['delai'] = (int)$mode['delai'];
			for($i=0; $i<7; $i++)
			{
				$config['modes'][$code]['ouvres'][$i] = ($mode['ouvres'][$i] == 'on');
			}
			$config['modes'][$code]['exceptionnels'] = array_map(function($n){return implode('-', array_reverse(explode('-', $n)));}, $mode['exceptionnels']);
			$config['modes'][$code]['adresse'] = str_replace("\r\n", '<br/>', $mode['adresse']);
			$config['modes'][$code]['horaires'] = str_replace("\r\n", '<br/>', $mode['horaires']);
		}
		
		// var_dump(json_encode($config));
		// var_dump($config);
		// die;
		
		Mage::getConfig()->saveConfig('calendriers/calendriers', json_encode($config), 'default', 0);
		// die;
		$this->_redirect('*/*/');
	}
}