<?php
/**
 * Magento
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magentocommerce.com so we can send you a copy immediately.
 *
 * @category   Quadra
 * @package    Quadra_Atos
 * @name        Quadra_Atos_Model_Config
 * @author      Quadra Team
 */

class Quadra_Atos_Model_Config extends Varien_Object
{
    /**
     * Recupere un tableau des devises autorisees
     *
     * @return array
     */
    public function getCurrencies()
    {
        $currencies = array();
        foreach (Mage::getConfig()->getNode('global/payment/atos_standard/currencies')->asArray() as $data) {
            $currencies[$data['iso']] = $data['code'];
        }

        return $currencies;
    }

    /**
     * Recupere un tableau des langages autorisees
     *
     * @return array
     */
    public function getLanguages()
    {
        $languages = array();
        foreach (Mage::getConfig()->getNode('global/payment/atos_standard/languages')->asArray() as $data) {
            $languages[$data['code']] = $data['name'];
        }

        return $languages;
    }

    /**
     * Recupere un tableau des cartes de credit autorisees
     *
     * @return array
     */
    public function getCreditCardTypes()
    {
        $types = array();

        foreach (Mage::getConfig()->getNode('global/payment/atos_standard/credit_card')->asArray() as $data) {
            $types[$data['code']] = $data['name'];
        }

        return $types;
    }
	
    /**
     * Recupere un tableau des IP des serveurs Atos
     *
     * @return array
     */
    public function getAuthorizedIps()
    {
        $config = Mage::getConfig()->getNode('global/payment/atos_standard/authorized_ip/value')->asArray();
        $authorizedIp = explode(',', $config);

        return $authorizedIp;
    }
    
    /**
     * Recupere un tableau des mots cles du champ data 
     *
     * @return array
     */
    public function getDataFieldKeys()
    {
        $types = array();
        foreach (Mage::getConfig()->getNode('global/payment/atos_standard/data_field')->asArray() as $data) {
            $types[$data['code']] = $data['name'];
        }

        return $types;
    }
}
