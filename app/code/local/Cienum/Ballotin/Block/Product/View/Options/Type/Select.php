<?php
class Cienum_Ballotin_Block_Product_View_Options_Type_Select extends Mage_Catalog_Block_Product_View_Options_Type_Select
{
	public function getValuesHtml()
    {
	
	
        $_option = $this->getOption();

        if ($_option->getType() == Mage_Catalog_Model_Product_Option::OPTION_TYPE_DROP_DOWN
            || $_option->getType() == Mage_Catalog_Model_Product_Option::OPTION_TYPE_MULTIPLE) {
            $require = ($_option->getIsRequire()) ? ' required-entry' : '';
            $extraParams = '';
            $select = $this->getLayout()->createBlock('core/html_select')
                ->setData(array(
                    'id' => 'select_'.$_option->getId(),
                    'class' => $require.' product-custom-option'
                ));
            if ($_option->getType() == Mage_Catalog_Model_Product_Option::OPTION_TYPE_DROP_DOWN) {
                $select->setName('options['.$_option->getid().']')
                    ->addOption('', $this->__('-- Please Select --'));
            } else {
                $select->setName('options['.$_option->getid().'][]');
                $select->setClass('multiselect'.$require.' product-custom-option');
            }
            foreach ($_option->getValues() as $_value) {
                $priceStr = $this->_formatPrice(array(
                    'is_percent' => ($_value->getPriceType() == 'percent') ? true : false,
                    'pricing_value' => $_value->getPrice(true)
                ), false);
                $select->addOption(
                    $_value->getOptionTypeId(),
                    $_value->getTitle() . ' ' . $priceStr . ''
                );
            }
            if ($_option->getType() == Mage_Catalog_Model_Product_Option::OPTION_TYPE_MULTIPLE) {
                $extraParams = ' multiple="multiple"';
            }
//            $select->setExtraParams('onchange="opConfig.reloadPrice()"'.$extraParams);

            return $select->getHtml();
        }

        if ($_option->getType() == Mage_Catalog_Model_Product_Option::OPTION_TYPE_RADIO
            || $_option->getType() == Mage_Catalog_Model_Product_Option::OPTION_TYPE_CHECKBOX
            ) {


            /* Ballotin Modal Body*/


            $selectHtml = '<ul id="options-'.$_option->getId().'-list" class="options-list">';
            $require = ($_option->getIsRequire()) ? ' validate-one-required-by-name' : '';
            $arraySign = '';
            switch ($_option->getType()) {
                case Mage_Catalog_Model_Product_Option::OPTION_TYPE_RADIO:
                    $type = 'radio';
                    $class = 'radio';
                    if (!$_option->getIsRequire()) {
                        $selectHtml .= '<li><input type="radio" id="options_'.$_option->getId().'" class="'.$class.' product-custom-option" name="options['.$_option->getId().']" onclick="opConfig.reloadPrice()" value="" checked="checked" /><span class="label"><label for="options_'.$_option->getId().'">' . $this->__('None') . '</label></span></li>';
                    }
                    break;
                case Mage_Catalog_Model_Product_Option::OPTION_TYPE_CHECKBOX:
                    $type = 'checkbox';
                    $class = 'checkbox';
                    $arraySign = '[]';
                    break;
            }
            $count = 1;


            foreach ($_option->getValues() as $_value) {
                $count++;
                $priceStr = $this->_formatPrice(array(
                    'is_percent' => ($_value->getPriceType() == 'percent') ? true : false,
                    'pricing_value' => $_value->getPrice(true)
                ));


				$resource = Mage::getSingleton('core/resource');
				$read= $resource->getConnection('core_read');			

				$sSql = "select texte_chocolat, ingr_chocolat, ref_chocolat, logo_chocolat, titre_chocolat from ci_chocolat where ref_chocolat = (SELECT sku FROM catalog_product_option_type_value where option_type_id = '".$_value->getId()."') limit 1";
//				$sSql = "select texte_chocolat, ingr_chocolat, ref_chocolat, logo_chocolat, titre_chocolat from ci_chocolat ";
				$lst_ong = $read->fetchAll($sSql); 	

				$lien_ingr = "";

//                                 var_dump($lst_ong);
                                
//				    echo "<pre>";
//				        print_r($lst_ong[0]["texte_chocolat"]);
//                    echo "</pre>";
				if(count($lst_ong) > 0)
				{
//

					//On fait le lien si on a des donn�es
					if($lst_ong[0]["texte_chocolat"] != "" || $lst_ong[0]["ingr_chocolat"] != "")
					{
						echo "<div id='option_".$lst_ong[0]["ref_chocolat"]."' class='optionextended-narrow-note inactive-ingr' style='display:none;'>";
						
						echo "<table class='tabPopIngr'><tr>";

						if($lst_ong[0]["logo_chocolat"] != "" && file_exists(Mage::getBaseDir('media')."/ballotins/".$lst_ong[0]["logo_chocolat"]))
						{
							echo '<td style="vertical-align:top;"><img src="'.Mage::getBaseUrl('media').'ballotins/'.$lst_ong[0]["logo_chocolat"].'" width="130" border="0" /></td>';
						}
						echo "<td style=\"vertical-align:top;padding-left:5px;padding-top:5px;\"><b>".$lst_ong[0]["titre_chocolat"]."</b><span class='closeIngr' style='float:right;font-weight:bold;cursor:pointer;'>X</span><br /><br />";
						echo ($lst_ong[0]["texte_chocolat"] != "" ? "<div style='color:#9D779F;'>".$lst_ong[0]["texte_chocolat"]."</div><br />" : "");
						echo ($lst_ong[0]["ingr_chocolat"] != "" ? "Ingr&eacute;dients : ".$lst_ong[0]["ingr_chocolat"] : "");

						echo "</td></tr></table>";
						echo "</div>";



						$lien_ingr = "<div><span class='lienIngr' data-opt=".$lst_ong[0]["ref_chocolat"]."><!--<img src='/skin/frontend/default/trego/images/info.png' alt='Information' /> --></span></div>";
					}
				}

				/*  Display pupin  */


				$ballotin_pupin_img =  Mage::getBaseUrl('media').'ballotins/'.$lst_ong[0]["logo_chocolat"];
                $pupin = '<div class="remodal ballotin-pupin" data-remodal-id="modal-'.$_value->getTitle().'">';
                $pupin .= ' <button data-remodal-action="close" class="remodal-close"></button>';
                $pupin .= "<div class='ballotin-pupin-left'>";
                $pupin .= "<img src='".$ballotin_pupin_img."' />";
                $pupin .= "</div>";
                $pupin .= "<div class='ballotin-pupin-right'>";
                $pupin .="<h1>" .$_value->getTitle()."</h1>";
                $pupin .= "<div class='ballotin-pupin-description'>";
                $pupin .= "<div class='ballotin-pupin-text'>";
                $pupin .= $lst_ong[0]["texte_chocolat"];
                $pupin .= "</div>";
                $pupin .= "<div class='ballotin-pupin-ingr'>";
                $pupin .= $lst_ong[0]["ingr_chocolat"] ;
                $pupin .= "</div>";
                $pupin .= "</div>";
                $pupin .= "</div>";




                $pupin .= "</div>";
                echo $pupin;

                /* ballotin-display.png */
                $ballotinQm =  "<div class='ballotin-qm'><a class='pupin-anchor' href='#modal-".$_value->getTitle()."'><img src='/skin/frontend/trego2016/trego/images/ballotin-display.png' alt=''></a></div>";
                $added = 'Ajouter';                

                $selectHtml .= '<li class="ballotin-img-wrappert">'.

                               '<div class="img-wrapper"><input type="'.$type.'" class="'.$class.' '.$require.' product-custom-option" onclick="opConfig.reloadPrice()" name="options['.$_option->getId().']'.$arraySign.'" id="options_'.$_option->getId().'_'.$count.'" value="'.$_value->getOptionTypeId().'" /></div>' .
                                '<span class="label"><label for="options_'.$_option->getId().'_'.$count.'"><nobr>'.$_value->getTitle().' '.$priceStr. '</nobr></label></span>'.$lien_ingr.''.
                                $ballotinQm .
                                '<span class="added">'. $added. '</span>';
                if ($_option->getIsRequire()) {
                    $selectHtml .= '<script type="text/javascript">' .
                                    '$(\'options_'.$_option->getId().'_'.$count.'\').advaiceContainer = \'options-'.$_option->getId().'-container\';' .
                                    '$(\'options_'.$_option->getId().'_'.$count.'\').callbackFunction = \'validateOptionsCallback\';' .
                                   '</script>';
                }
                $selectHtml .= '</li>';
            }
            $selectHtml .= '</ul>';



            return $selectHtml;
        }
    }
}