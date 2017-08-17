<?php
    $_helper = $this->helper('catalog/output');
    $store = Mage::app()->getStore();
    $code  = $store->getCode();
?>
<?php if(count($this->getItemCollection()->getItems())): ?>
<div class="box-collateral box-up-sell akordeon-item">
    <div class="akordeon-item-head">
        <div class="akordeon-item-head-container">
            <div class="akordeon-heading">
                <?php echo $this->__('Upselling Product(s)') ?>
            </div>
        </div>
    </div>
    <div class="akordeon-item-body">
        <div class="akordeon-item-content">
            <ul class="products bxslider" id="box_upsell">
                <?php $this->resetItemsIterator() ?>
                <?php for($_i=0;$_i<$this->getRowCount();$_i++): ?>
                    <?php for($_j=0;$_j<$this->getColumnCount();$_j++): ?>
                        <?php if($_product=$this->getIterableItem()): ?>
                <li class="slide item<?php if($_i==0 && $_j==0): ?> first<?php elseif($_i==$this->getRowCount()-1 && $_j==$this->getColumnCount()-1): ?> last<?php endif; ?>">
                    <div class="product-image-area">
                        <a href="<?php echo $_product->getProductUrl() ?>" title="<?php echo $this->htmlEscape($_product->getName()) ?>" class="product-image">
                            <img src="<?php if(Mage::getStoreConfig("trego_settings/category/aspect_ratio",$code)):?><?php echo $this->helper('catalog/image')->init($_product, 'small_image')->constrainOnly(FALSE)->keepAspectRatio(TRUE)->keepFrame(FALSE)->resize(350);?><?php else: ?><?php echo $this->helper('catalog/image')->init($_product, 'small_image')->resize(350, 350 * Mage::getStoreConfig("trego_settings/category/ratio_height",$code) / Mage::getStoreConfig("trego_settings/category/ratio_width",$code)); ?><?php endif; ?>" alt="<?php echo $this->stripTags($this->getImageLabel($_product, 'small_image'), null, true) ?>"/>
                        </a>
                        <?php 
                            $top_position = 10;
                            // Get the Special Price
                            $specialprice = Mage::getModel('catalog/product')->load($_product->getId())->getSpecialPrice(); 
                            // Get the Special Price FROM date
                            $specialPriceFromDate = Mage::getModel('catalog/product')->load($_product->getId())->getSpecialFromDate();
                            // Get the Special Price TO date
                            $specialPriceToDate = Mage::getModel('catalog/product')->load($_product->getId())->getSpecialToDate();
                            // Get Current date
                            $today =  time();
                         
                            if ($specialprice){
                                if($today >= strtotime( $specialPriceFromDate) && $today <= strtotime($specialPriceToDate) || $today >= strtotime( $specialPriceFromDate) && is_null($specialPriceToDate)){
                                    if(Mage::getStoreConfig("trego_settings/product_label/sale", $code)){
                        ?>
                                    <div class="sale-product-icon" style="top: <?php echo $top_position; ?>px"><?php echo $this->__('Sale');?></div>
                        <?php       
                                    $top_position += 20;
                                    }
                                }
                            }
                        ?>
                        <?php
                            $now = date("Y-m-d");
                            $newsFrom= substr($_product->getData('news_from_date'),0,10);
                            $newsTo=  substr($_product->getData('news_to_date'),0,10);
                            if ($newsTo != '' || $newsFrom != ''){
                                if (($newsTo != '' && $newsFrom != '' && $now>=$newsFrom && $now<=$newsTo) || ($newsTo == '' && $now >=$newsFrom) || ($newsFrom == '' && $now<=$newsTo))
                                {
                                    if(Mage::getStoreConfig("trego_settings/product_label/new", $code)){
                            ?> 
                                    <div class="new-product-icon" style="top: <?php echo $top_position; ?>px"><?php echo $this->__('New');?></div>
                            <?php 
                                    $top_position += 20;
                                    }
                                }
                            }
                            if(Mage::getStoreConfig("trego_settings/category_grid/ratings", $code)){
                                if($_product->getRatingSummary()){
                                    echo $this->getReviewsSummaryHtml($_product, 'short');
                                }
                            }
                        ?>
                        <div class="clearer"></div>
                    </div>
                    <?php echo $this->getPriceHtml($_product, true) ?>
                  <H3 class="product-name" >  <a href="<?php echo $_product->getProductUrl() ?>" title="<?php echo $this->stripTags($_product->getName(), null, true) ?>"><?php echo $_helper->productAttribute($_product, $_product->getName(), 'name') ?></a></h3>
                </li>
                <?php endif; ?>
            <?php endfor; ?>
            <?php endfor; ?>
            </ul>
        </div>
    </div>
</div>
<script type="text/javascript">
    jQuery(document).ready(function(){
        var _width = jQuery(window).width();
        var _slidewidth = 150;
        var _slidemargin = 10;
        var _maxslides = 3;
        if(_width > 1024 && _width <=1099){
            _slidewidth = 137;
        }
        if(_width >= 768 && _width <=1024){
            _slidewidth = 128;
            _slidemargin = 8;
        }
        if(_width < 768 && _width >= 640){
            _maxslides = 3;
        }
        if(_width < 640 && _width >=480){
            _maxslides = 2;
        }
        if(_width < 480 && _width >=320){
            _maxslides = 2;
        }
        if(_width < 320){
            _maxslides = 1;
        }

        _width = jQuery('.product-shop').width();
        _slidewidth = (_width-_slidemargin*(_maxslides-1))/_maxslides;
        var upsell_slider = jQuery('#box_upsell').bxSlider({
            minSlides: 1,
            maxSlides: _maxslides,
            pager: false,
            slideWidth: _slidewidth,
            slideMargin: _slidemargin,
            responsive: true
        });
        var stu;
        jQuery(window).resize(function(e){
            e.preventDefault();
            var _width = jQuery(document).width();
            if(stu) clearTimeout(stu);
            stu = setTimeout(function(){
                var _width = jQuery(window).width();
                var _slidewidth = 150;
                var _slidemargin = 10;
                var _maxslides = 3;
                if(_width > 1024 && _width <=1099){
                    _slidewidth = 137;
                }
                if(_width >= 768 && _width <=1024){
                    _slidewidth = 128;
                    _slidemargin = 8;
                }
                if(_width < 768 && _width >= 640){
                    _maxslides = 3;
                }
                if(_width < 640 && _width >=480){
                    _maxslides = 2;
                }
                if(_width < 480 && _width >=320){
                    _maxslides = 2;
                }
                if(_width < 320){
                    _maxslides = 1;
                }
                _width = jQuery('.product-shop').width();
                _slidewidth = (_width-_slidemargin*(_maxslides-1))/_maxslides;
                upsell_slider.reloadSlider({
                    minSlides: 1,
                    maxSlides: _maxslides,
                    pager: false,
                    slideWidth: _slidewidth,
                    slideMargin: _slidemargin,
                    responsive: true
                });
            }, 500);
        });
    })
</script>
<?php endif ?>
