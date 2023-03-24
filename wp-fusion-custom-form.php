<div class="count">
    Showing <?php echo $collection->getFirstItemNum() ?> - <?php echo $collection->getLastItemNum() ?> of <?php echo $collection->getSize() ?> products
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
