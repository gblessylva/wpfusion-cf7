Create a new file called BrandViewModel.php in your custom theme under app/code/[Vendor]/[Theme]/ViewModel/.

Add the following code to the BrandViewModel.php file:

<?php

namespace [Vendor]\[Theme]\ViewModel;

use Magento\Catalog\Model\Product;
use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\View\Element\Block\ArgumentInterface;

class BrandViewModel implements ArgumentInterface
{
    protected $request;
    protected $collectionFactory;

    public function __construct(
        RequestInterface $request,
        CollectionFactory $collectionFactory
    ) {
        $this->request = $request;
        $this->collectionFactory = $collectionFactory;
    }

    public function getBrandCollection()
    {
        $brand = $this->request->getParam('brand');
        $collection = $this->collectionFactory->create();
        $collection->addAttributeToSelect('*');
        $collection->addAttributeToFilter('brand', $brand);
        $collection->setPageSize(9);
        return $collection;
    }

    public function getBrandOptions()
    {
        $collection = $this->collectionFactory->create();
        $collection->addAttributeToSelect('brand');
        $collection->getSelect()->group('brand');
        $options = array();
        foreach ($collection as $product) {
            $option = array(
                'value' => $product->getData('brand'),
                'label' => $product->getAttributeText('brand')
            );
            $options[] = $option;
        }
        return $options;
    }
}


Open the product-list-navigation.phtml file in your custom theme's Magento_Catalog/templates/product/list/ directory.

Add the following code to the file to instantiate the BrandViewModel:

php
Copy code
<?php
/** @var \[Vendor]\[Theme]\ViewModel\BrandViewModel $brandViewModel */
$brandViewModel = $block->getData('brandViewModel');
?>
Add the following code to create the brand select dropdown:
php
Copy code
<div class="brand-select">
    <label for="brand-select"><?php /* @escapeNotVerified */ echo __('Brand') ?></label>
    <select id="brand-select" onchange="location.href = this.value;">
        <option value="<?php /* @escapeNotVerified */ echo $block->getUrl('*/*/*', ['_current' => true]) ?>" <?php if (!$block->getRequest()->getParam('brand')) : ?>selected="selected"<?php endif; ?>><?php /* @escapeNotVerified */ echo __('All Brands') ?></option>
        <?php foreach ($brandViewModel->getBrandOptions() as $option) : ?>
            <option value="<?php /* @escapeNotVerified */ echo $block->getUrl('*/*/*', ['_current' => true, 'brand' => $option['value']]) ?>" <?php if ($block->getRequest()->getParam('brand') == $option['value']) : ?>selected="selected"<?php endif; ?>><?php /* @escapeNotVerified */ echo $option['label'] ?></option>
        <?php endforeach; ?>
    </select>
</div>
Save the product-list-navigation.phtml file.














<?php
    $brandAttribute = $_productCollection->getAttribute('brand');
    if ($brandAttribute && $brandAttribute->usesSource()) {
        $options = $brandAttribute->getSource()->getAllOptions(false);
        array_unshift($options, ['value' => '', 'label' => __('Sort by Brand')]);
?>
    <div class="sort-by-brand">
        <label class="sort-by-brand-label" for="sort-by-brand-select"><?php echo __('Brand') ?></label>
        <select id="sort-by-brand-select" class="sort-by-brand-select"
                onchange="setLocation(jQuery(this).val());">




<?php foreach ($options as $option): ?>
                <option value="<?php echo $this->helper('Magento\Framework\Url')->getSortUrl(
                    $_productCollection,
                    ['brand' => $option['value']]
                ); ?>">
                    <?php echo $option['label']; ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>
<?php } ?>


<select onchange="setLocation(this.value)">
    <option value="" <?php if (!$block->getRequest()->getParam('brand')): ?>selected="selected"<?php endif; ?>><?php echo __('Sort by'); ?></option>
    <?php foreach ($brands as $brand): ?>
        <?php $selected = ($block->getRequest()->getParam('brand') == $brand) ? 'selected="selected"' : ''; ?>
        <option value="<?php echo $block->getSortUrl(['brand' => $brand]) ?>" <?php echo $selected ?>><?php echo $brand ?></option>
    <?php endforeach; ?>
</select>
goes into phtml
<?
protected function getProductCollection()
{
    if ($this->_productCollection === null) {
        $collection = parent::getProductCollection();
        if ($this->getRequest()->getParam('brand')) {
            $collection->addAttributeToSort('brand', $this->getRequest()->getParam('dir') ? $this->getRequest()->getParam('dir') : 'asc');
        }
        $this->_productCollection = $collection;
    }
    return $this->_productCollection;
}

?>
<?php
namespace Vendor\Module\Block\Product;

use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory;
use Magento\Catalog\Block\Product\ProductList\Toolbar as ToolbarModel;

class ListProduct extends \Magento\Catalog\Block\Product\ListProduct
{
    protected $_productCollectionFactory;
    protected $_catalogLayer;
 
    public function __construct(
        \Magento\Catalog\Block\Product\Context $context,
        \Magento\Framework\Data\Helper\PostHelper $postDataHelper,
        \Magento\Catalog\Model\Layer\Resolver $layerResolver,
        CollectionFactory $productCollectionFactory,
        ToolbarModel $toolbar,
        array $data = []
    ) {
        $this->_productCollectionFactory = $productCollectionFactory;
        $this->_catalogLayer = $layerResolver->get();
        $this->toolbar = $toolbar;
        parent::__construct($context, $postDataHelper, $data);
    }

    protected function _getAvailableOrders()
    {
        $availableOrders = parent::_getAvailableOrders();
        $availableOrders['brand'] = __('Brand');
 
        return $availableOrders;
    }
 
    public function getBrands()
    {
        $attributeCode = 'brand';
        $collection = $this->_productCollectionFactory->create();
        $collection->addAttributeToSelect($attributeCode)
            ->addGroupByAttribute($attributeCode)
            ->addAttributeToSort($attributeCode);
 
        $brands = array();
        foreach ($collection as $product) {
            $brand

		     $brand = $product->getAttributeText('brand');
    if ($brand) {
        $brands[$brand] = $brand;
    }
}
	    
		    
		    

<?php
namespace Vendor\Module\Block\Product;

use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory;
use Magento\Catalog\Block\Product\ProductList\Toolbar as ToolbarModel;

class ListProduct extends \Magento\Catalog\Block\Product\ListProduct
{
    protected $_productCollectionFactory;
    protected $_catalogLayer;
 
    public function __construct(
        \Magento\Catalog\Block\Product\Context $context,
        \Magento\Framework\Data\Helper\PostHelper $postDataHelper,
        \Magento\Catalog\Model\Layer\Resolver $layerResolver,
        CollectionFactory $productCollectionFactory,
        ToolbarModel $toolbar,
        array $data = []
    ) {
        $this->_productCollectionFactory = $productCollectionFactory;
        $this->_catalogLayer = $layerResolver->get();
        $this->toolbar = $toolbar;
        parent::__construct($context, $postDataHelper, $data);
    }

    public function getBrands()
    {
        $attributeCode = 'brand';
        $collection = $this->_productCollectionFactory->create();
        $collection->addAttributeToSelect($attributeCode)
            ->addGroupByAttribute($attributeCode)
            ->addAttributeToSort($attributeCode);
 
        $brands = array();
        foreach ($collection as $product) {
            $brand = $product->getAttributeText($attributeCode);
            if (!in_array($brand, $brands)) {
                $brands[] = $brand;
            }
        }
 
        return $brands;
    }
}


// --------------

<?xml version="1.0"?>
<page layout="2columns-left" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:noNamespaceSchemaLocation="urn:magento:framework:View/Layout/etc/page_configuration.xsd">
  <body>
    <referenceBlock name="category.products.list">
      <arguments>
        <argument name="sort_by" xsi:type="string">brand</argument>
        <argument name="sort_order" xsi:type="string">asc</argument>
      </arguments>
    </referenceBlock>
  </body>
</page>


{{block class="Magento\Framework\View\Element\Template" name="custom.category.template" template="Vendor_Module::custom-category.phtml"}}

<form action="{{store url='catalogform/index/save'}}" method="post">
    <!-- form fields go here -->
    <button type="submit">Submit</button>
</form>

<?xml version="1.0"?>
<config xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:noNamespaceSchemaLocation="urn:magento:framework:App/etc/routes.xsd">
    <router id="standard">
        <route id="catalogform" frontName="catalogform">
            <module name="Vendor_Module" />
        </route>
    </router>
</config>



{{block class="Vendor\Module\Block\Form" template="Vendor_Module::form.phtml"}}



<nav class="nav-menu">
    <ul>
        <?php
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $categoryFactory = $objectManager->get('\Magento\Catalog\Model\CategoryFactory');
        $categories = $categoryFactory->create()->getCollection()->addAttributeToSelect('*')->addIsActiveFilter();

        foreach ($categories as $category) {
            if ($category->getLevel() == 1) {
                // Print main category
                echo '<li><a href="' . $category->getUrl() . '">' . $category->getName() . '</a>';

                // Get subcategories of main category
                $subcategories = $category->getChildrenCategories();
                if ($subcategories->count() > 0) {
                    // Print subcategories
                    echo '<ul class="submenu">';
                    foreach ($subcategories as $subcategory) {
                        echo '<li><a href="' . $subcategory->getUrl() . '">' . $subcategory->getName() . '</a></li>';
                    }
                    echo '</ul>';
                }

                echo '</li>';
            }
        }
        ?>
    </ul>
</nav>


<div class="sort-by">
    <label for="sort-by-select"><?php echo __('Sort By:') ?></label>
    <select id="sort-by-select">
        <option value="price-desc"><?php echo __('Price: High to Low') ?></option>
        <option value="price-asc"><?php echo __('Price: Low to High') ?></option>
        <option value="name-asc"><?php echo __('Name: A to Z') ?></option>
        <option value="name-desc"><?php echo __('Name: Z to A') ?></option>
        <option value="date-desc"><?php echo __('Newest to Oldest') ?></option>
    </select>
</div>

<script type="text/javascript">
    document.getElementById("sort-by-select").onchange = function() {
        var urlParams = new URLSearchParams(window.location.search);
        urlParams.set('product_list_order', this.value);
        window.location.search = urlParams.toString();
    };
</script>

<?php
    $productListOrder = $this->getRequest()->getParam('product_list_order');
    if (!$productListOrder) {
        $productListOrder = 'price-desc';
    }
    $sortType = '';
    $sortDirection = '';
    switch ($productListOrder) {
        case 'price-desc':
            $sortType = 'price';
            $sortDirection = 'desc';
            break;
        case 'price-asc':
            $sortType = 'price';
            $sortDirection = 'asc';
            break;
        case 'name-asc':
            $sortType = 'name';
            $sortDirection = 'asc';
            break;
        case 'name-desc':
            $sortType = 'name';
            $sortDirection = 'desc';
            break;
        case 'date-desc':
            $sortType = 'created_at';
            $sortDirection = 'desc';
            break;
        default:
            $sortType = 'price';
            $sortDirection = 'desc';
            break;
    }
    $collection = $block->getLoadedProductCollection();
    $collection->clear()->getSelect()->reset(\Zend_Db_Select::ORDER);
    $collection->addAttributeToSort($sortType, $sortDirection);
    $collection->load();
?>

<div class="count"><?php echo __('Showing %1 of %2', $collection->getFirstItemNum(), $collection->getLastItemNum()) ?></div>

<div class="products-grid">
    <?php foreach ($collection as $product): ?>
        <!-- Product card HTML here -->
    <?php endforeach; ?>
</div>


<!-- CODE TO SORT -->

<div class="count">
    Showing <?php echo $collection->getCurPage() * $collection->getPageSize() - $collection->getPageSize() + 1 ?> - <?php echo min($collection->getCurPage() * $collection->getPageSize(), $collection->getSize()) ?> of <?php echo $collection->getSize() ?> products
</div>
<!-- Start -->
<?php
    /** @var \Magento\Catalog\Block\Product\ListProduct $block */
    $block = $this->getLayout()->getBlock('category.products.list');
    $toolbar = $block->getToolbarBlock();
    $collection = $block->getLoadedProductCollection();

    if ($collection->getSize()) {
        $pager = $block->getLayout()->createBlock(\Magento\Theme\Block\Html\Pager::class, 'custom.pager')
            ->setAvailableLimit([10 => 10, 20 => 20, 50 => 50])
            ->setShowPerPage(true)
            ->setShowAmounts(true)
            ->setPageVarName('page')
            ->setLimitVarName('limit')
            ->setCollection($collection);
        echo $pager->toHtml();
    }
?>
<div class="products-grid">
    <ol class="products-list" id="products-list">
        <?php foreach ($block->getLoadedProductCollection() as $_product): ?>
            <li class="product-item">
                <strong class="product-item-name">
                    <a href="<?php echo $_product->getProductUrl() ?>"><?php echo $_product->getName() ?></a>
                </strong>
                <?php echo $block->getProductPrice($_product) ?>
                <?php echo $_product->getShortDescription() ?>
            </li>
        <?php endforeach ?>
    </ol>
</div>
<div class="navigation">
    <?php if ($pager->getCurrentPage() > 1) : ?>
        <a href="<?php echo $pager->getPreviousPageUrl() ?>">Prev</a>
    <?php endif; ?>
    <?php for ($i = 1; $i <= $pager->getLastPageNum(); $i++) : ?>
        <?php if ($pager->getCurrentPage() == $i) : ?>
            <strong><?php echo $i ?></strong>
        <?php else: ?>
            <a href="<?php echo $pager->getPageUrl($i) ?>"><?php echo $i ?></a>
        <?php endif; ?>
    <?php endfor; ?>
    <?php if ($pager->getCurrentPage() < $pager->getLastPageNum()) : ?>
        <a href="<?php echo $pager->getNextPageUrl() ?>">Next</a>
    <?php endif; ?>
</div>
<!--  end-->


<?php
    /** @var \Magento\Catalog\Block\Product\ListProduct $block */
    $block = $this->getLayout()->getBlock('category.products.list');
    $toolbar = $block->getToolbarBlock();
    $collection = $block->getLoadedProductCollection();

    if ($collection->getSize()) {
        $pager = $block->getLayout()->createBlock(\Magento\Theme\Block\Html\Pager::class, 'custom.pager')
            ->setAvailableLimit([10 => 10, 20 => 20, 50 => 50])
            ->setShowPerPage(true)
            ->setShowAmounts(true)
            ->setPageVarName('page')
            ->setLimitVarName('limit')
            ->setCollection($collection);
        echo $pager->toHtml();
    }
?>
<div class="products-grid">
    <ol class="products-list" id="products-list">
        <?php foreach ($block->getLoadedProductCollection() as $_product): ?>
            <li class="product-item">
                <strong class="product-item-name">
                    <a href="<?php echo $_product->getProductUrl() ?>"><?php echo $_product->getName() ?></a>
                </strong>
                <?php echo $block->getProductPrice($_product) ?>
                <?php echo $_product->getShortDescription() ?>
            </li>
        <?php endforeach ?>
    </ol>
</div>


<?php
    /** @var \Magento\Catalog\Block\Product\ListProduct $block */
    $block = $this->getLayout()->getBlock('product_list');
    $toolbar = $block->getToolbarBlock();
    $collection = $block->getLoadedProductCollection();

    if ($collection->getSize()) {
        $pager = $block->getLayout()->createBlock(\Magento\Theme\Block\Html\Pager::class, 'custom.pager')
            ->setAvailableLimit([10 => 10, 20 => 20, 50 => 50])
            ->setShowPerPage(true)
            ->setShowAmounts(true)
            ->setPageVarName('page')
            ->setLimitVarName('limit')
            ->setCollection($collection);
        echo $pager->toHtml();
    }
?>


<?php 
    $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
    $productRepository = $objectManager->get('\Magento\Catalog\Api\ProductRepositoryInterface');
    $attributeRepository = $objectManager->get('\Magento\Eav\Api\AttributeRepositoryInterface');
    $brandAttribute = $attributeRepository->get('catalog_product', 'brand');
    $options = $brandAttribute->getOptions();
?>
<select name="brand" onchange="window.location.href = '<?php echo $block->escapeUrl($block->getBaseUrl().'*/*/*') ?>?brand=' + this.value;">
    <option value="">Filter by brand</option>
    <?php foreach ($options as $option): ?>
        <option value="<?php echo $option->getValue() ?>"><?php echo $option->getLabel() ?></option>
    <?php endforeach; ?>
</select>



<?php 
    $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
    $productRepository = $objectManager->get('\Magento\Catalog\Api\ProductRepositoryInterface');
    $attributeRepository = $objectManager->get('\Magento\Eav\Api\AttributeRepositoryInterface');
    $brandAttribute = $attributeRepository->get('catalog_product', 'brand');
    $options = $brandAttribute->getOptions();
?>
<ul>
    <?php foreach ($options as $option): ?>
        <li><a href="<?php echo $block->escapeUrl($block->getBaseUrl().'*/*/*').'?brand='.$option->getValue() ?>"><?php echo $option->getLabel() ?></a></li>
    <?php endforeach; ?>
</ul>


<?php
    $brand = $block->getRequest()->getParam('brand');
    $collection = $block->getLoadedProductCollection();
    if ($brand) {
        $collection->addAttributeToFilter('brand', array('eq' => $brand));
    }
?>



<?php
<?php if ($_productCollection && $_productCollection->getSize()): ?>
    <div class="products-grid">
        <?php foreach ($_productCollection as $_product): ?>
            <div class="product-item">
                <a href="<?php echo $_product->getProductUrl() ?>" title="<?php echo $this->escapeHtml($_product->getName()) ?>">
                    <img src="<?php echo $this->helper('Magento\Catalog\Helper\Image')->init($_product, 'category_page_grid')->resize(240, 300)->getUrl(); ?>" alt="<?php echo $this->escapeHtml($_product->getName()) ?>">
                    <h2 class="product-name"><?php echo $this->escapeHtml($_product->getName()) ?></h2>
                    <span class="price"><?php echo $this->helper('Magento\Framework\Pricing\Helper\Data')->currency($_product->getPrice()) ?></span>
                </a>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>



if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}


class WPF_Contact_Form_7 extends WPF_Integrations_Base {

	/**
	 * Gets things started
	 *
	 * @access  public
	 * @return  void
	 */

	public function init() {

		$this->slug = 'cf7';

		add_filter( 'wpcf7_editor_panels', array( $this, 'add_panel' ) );
		add_action( 'wpcf7_after_save', array( $this, 'save_form' ) );
		add_action( 'wpcf7_mail_sent', array( $this, 'send_data' ), 5 );

	}

	/**
	 * Adds panel to CF7 settings page
	 *
	 * @access  public
	 * @return  array Panels
	 */

	public function add_panel( $panels ) {

		$panels['wp-fusion-tab'] = array(
			'title'    => 'WP Fusion',
			'callback' => array( $this, 'add_form' )
		);

		return $panels;

	}


	/**
	 * Adds form content to panel
	 *
	 * @access  public
	 * @return  mixed Panel content
	 */

	public function add_form( $info ) {

		wp_nonce_field( 'cf7_wpf_nonce', 'cf7_wpf_nonce' );

		$post_id = $info->id();
		$content = $info->prop( 'form' );
		$inputs  = array();

		// Get inputs from saved form config
		preg_match_all( "/\[.*\]/", $content, $matches );

		foreach ( $matches[0] as $input ) {
			$input    = substr( $input, 1, - 1 );
			$input    = str_replace( '*', '', $input );
			$elements = explode( ' ', $input );

			if ( ! ( $elements[1] == '"Send"' ) ) {
				$inputs[ $elements[1] ] = $elements[0];
			}
		}

		$settings = get_post_meta( $post_id, 'cf7_wpf_settings', true );

		if( empty( $settings ) ) {
			$settings = array();
		}

		echo '<h2>' . wp_fusion()->crm->name . ' Settings</h2>';

		echo '<fieldset><legend>For each field in the form, select a field to sync with in ' . wp_fusion()->crm->name . '</legend>';

		echo '<table id="wpf-cf7-table">';
		echo '<tbody id="wp-fusion-inputs">';
		foreach ( $inputs as $name => $type ) {

			$capital_name = str_replace( '-', '  ', $name );

			if( ! isset( $settings[ $name ] ) ) {
				$settings[ $name ] = array( 'crm_field' => '' );
			}

			if ( ! isset( $settings[ $name ]['crm_field'] ) ) {
				$settings[ $name ]['crm_field'] = '';
			}

			echo '<tr id="input-row">';
			echo '<td><label> ' . ucwords( $capital_name ) . ' <label></td>';
			echo '<td><label for ="cf7_wpf_settings"> ' . $type . ' <label></td>';
			echo '<td class="crm-field">';
			wpf_render_crm_field_select( $settings[ $name ]['crm_field'], 'cf7_wpf_settings', $name );
			echo '</td>';
			echo '</tr>';
		}
		echo '</tbody>';
		echo '</table>';

		$multiselect = $name;
		if ( isset( $settings['tags'] ) ) {
			$multiselect = $settings['tags'];
		}


		echo '<p class="description"><label for="tags">Apply the following tags when the form is submitted:</label><br />';

		wpf_render_tag_multiselect( array( 'setting' => $multiselect, 'meta_name' => 'cf7_wpf_settings', 'field_id' => 'tags' ) );

		echo '</p>';

		echo '</fieldset>';

	}

	/**
	 * Save WPF settings fields
	 * @access public
	 *
	 * @param unknown $contact_form
	 */

	public function save_form( $contact_form ) {

		if ( empty( $_POST ) || ! isset( $_POST['cf7_wpf_nonce'] ) ) {
			return;
		}

		$post_id = $contact_form->id();

		update_post_meta( $post_id, 'cf7_wpf_settings', $_POST['cf7_wpf_settings'] );

	}

	/**
	 * Send data to CRM on form submission
	 *
	 * @access  public
	 * @return  array Classes
	 */

	public function send_data( $contact_form ) {

		$contact_form_id = $contact_form->id();
		$submission      = WPCF7_Submission::get_instance();
		$posted_data     = $submission->get_posted_data();

		$wpf_settings = get_post_meta( $contact_form_id, 'cf7_wpf_settings', true );

		if ( empty( $wpf_settings ) ) {
			return;
		}

		$email_address = false;
		$update_data = array();

		foreach ( $posted_data as $key => $value ) {

			if ( ! isset( $wpf_settings[ $key ] ) || empty( $wpf_settings[ $key ]['crm_field'] ) || empty( $value ) ) {
				continue;
			}

			$type = 'text';

			if ( is_array( $value ) ) {
				$value = implode( ', ', $value );
				$type = 'multiselect';
			}

			if ( is_email( $value ) ) {
				$email_address = $value;
			}

			$value = apply_filters( 'wpf_format_field_value', $value, $type, $wpf_settings[ $key ]['crm_field'] );

			$update_data[ $wpf_settings[ $key ]['crm_field'] ] = $value;

		}

		if ( ! isset( $wpf_settings['tags'] ) ) {
			$wpf_settings['tags'] = array();
		}

		$args = array(
			'email_address'		=> $email_address,
			'update_data'		=> $update_data,
			'apply_tags'		=> $wpf_settings['tags'],
			'integration_slug'	=> 'cf7',
			'integration_name'	=> 'Contact Form 7',
			'form_id'			=> $contact_form_id,
			'form_title'		=> get_the_title( $contact_form_id ),
			'form_edit_link'	=> admin_url( 'admin.php?page=wpcf7&post=' . $contact_form_id . '&action=edit' )
		);

		require_once WPF_DIR_PATH . 'includes/integrations/class-forms-helper.php';

		$contact_id = WPF_Forms_Helper::process_form_data( $args );

	}

}

new WPF_Contact_Form_7;
