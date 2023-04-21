<?php
    $category = $block->getCurrentCategory();
    $image = $category->getImageUrl();
    $description = $category->getDescription();
?>
<div class="category-image">
    <img src="<?php echo $image ?>" alt="<?php echo $category->getName() ?>" />
</div>
<div class="category-description">
    <?php echo $description ?>
</div>


<?php
$objectManager = \Magento\Framework\App\ObjectManager::getInstance();
$postCollectionFactory = $objectManager->get('Magefan\Blog\Model\ResourceModel\Post\CollectionFactory');
$collection = $postCollectionFactory->create();
$collection->addFieldToFilter('is_active', 1); // Filter by active status
$collection->setOrder('publish_time', 'desc'); // Order by publish time
$collection->setPageSize(10); // Return 10 posts per page
$collection->setCurPage(1); // Skip the first page (10 posts)

// Skip the first post and return the next 9 posts
$collection->getSelect()->limit(9, 1);

foreach ($collection as $post) {
    echo '<a href="' . $post->getPostUrl() . '">' . $post->getTitle() . '</a><br>'; // Display post title and link
    echo '<img src="' . $post->getFeaturedImage() . '"><br>'; // Display post featured image
    echo $post->getPostContent() . '<br><br>'; // Display post content
}
?>


<?php
$objectManager = \Magento\Framework\App\ObjectManager::getInstance();
$postCollectionFactory = $objectManager->get('Magefan\Blog\Model\ResourceModel\Post\CollectionFactory');
$collection = $postCollectionFactory->create();
$collection->addFieldToFilter('is_active', 1); // Filter by active status
$collection->setOrder('publish_time', 'desc'); // Order by publish time
$collection->setPageSize(10); // Return only the first 10 posts

foreach ($collection as $post) {
    echo '<a href="' . $post->getPostUrl() . '">' . $post->getTitle() . '</a><br>'; // Display post title and link
    echo '<img src="' . $post->getFeaturedImage() . '"><br>'; // Display post featured image
    echo $post->getPostContent() . '<br><br>'; // Display post content
}
?>


<?php
$objectManager = \Magento\Framework\App\ObjectManager::getInstance();
$postCollectionFactory = $objectManager->get('Magefan\Blog\Model\ResourceModel\Post\CollectionFactory');
$collection = $postCollectionFactory->create();
$collection->addFieldToFilter('is_active', 1); // Filter by active status
$collection->setOrder('publish_time', 'desc'); // Order by publish time

foreach ($collection as $post) {
    echo $post->getTitle();
    // Display other post data as needed
}
?>


<referenceContainer name="content">
    <block class="Magefan\Blog\Block\PostList" name="blog.post.list" template="[Vendor]_[Theme]::Magefan_Blog/templates/blog.phtml"/>
</referenceContainer>




$productOptions = $_product->getOptions();
foreach ($productOptions as $options) {
    $optionType = $options->getType();
    $optionTitle = $options->getTitle();
    $optionValues = $options->getValues();
    //Do something with the product options
}



Create a magento 2 module called manufacturer that creates an attribute called manufacturer and is visible on the product edit page. If the attribute is selected, the attribute ID is associated with the product.

As an AI language model, I cannot create a Magento 2 module. However, I can guide you on the steps to create a module that adds a new attribute called "manufacturer" visible on the product edit page in Magento 2.

Here are the steps to create a Magento 2 module that adds a manufacturer attribute:

Create a new directory for the module in the app/code directory. For example, app/code/YourCompany/Manufacturer.
Create a module.xml file in the app/code/YourCompany/Manufacturer/etc directory with the following code:
xml
Copy code
<?xml version="1.0"?>
<config xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:noNamespaceSchemaLocation="urn:magento:framework:Module/etc/module.xsd">
   <module name="YourCompany_Manufacturer" setup_version="1.0.0">
   </module>
</config>
Create a registration.php file in the app/code/YourCompany/Manufacturer directory with the following code:
php
Copy code
<?php
\Magento\Framework\Component\ComponentRegistrar::register(
    \Magento\Framework\Component\ComponentRegistrar::MODULE,
    'YourCompany_Manufacturer',
    __DIR__
);
Create a file called InstallData.php in the app/code/YourCompany/Manufacturer/Setup directory with the following code:
php
Copy code
<?php
namespace YourCompany\Manufacturer\Setup;
use Magento\Catalog\Model\Product;
use Magento\Catalog\Model\ResourceModel\Eav\Attribute;
use Magento\Catalog\Setup\CategorySetupFactory;
use Magento\Eav\Model\Config;
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\UpgradeDataInterface;
use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;

class InstallData implements InstallDataInterface
{
    private $eavSetupFactory;
    private $attributeSetFactory;
    private $categorySetupFactory;
    private $config;

    public function __construct(EavSetupFactory $eavSetupFactory, \Magento\Eav\Model\Entity\Attribute\SetFactory $attributeSetFactory, CategorySetupFactory $categorySetupFactory, Config $config)
    {
        $this->eavSetupFactory = $eavSetupFactory;
        $this->attributeSetFactory = $attributeSetFactory;
        $this->categorySetupFactory = $categorySetupFactory;
        $this->config = $config;
    }

    public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        $eavSetup = $this->eavSetupFactory->create(['setup' => $setup]);
        $attributeSetId = $this->categorySetupFactory->create()->getDefaultAttributeSetId(Product::ENTITY);

        $eavSetup->addAttribute(Product::ENTITY, 'manufacturer', [
            'type' => 'int',
            'label' => 'Manufacturer',
            'input' => 'select',
            'required' => false,
            'global' => \Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface::SCOPE_STORE,
            'source' => 'YourCompany\Manufacturer\Model\Attribute\Source\Manufacturer',
            'group' => 'General Information',
            'attribute_set_id' => $attributeSetId,
            'visible' => true,
            'searchable' => false,
            'filterable' => true,
            'comparable' => false,
            'user_defined' => true,
            'visible_on_front' => true,
            'used_in_product_listing' => true,
            'unique' => false,
        ]);
    }
}
Create a file called Manufacturer.php in the



Gbless Sylva
continue
Create a file called Manufacturer.php in the app/code/YourCompany/Manufacturer/Model/Attribute/Source directory with the following code:
php
Copy code
<?php
namespace YourCompany\Manufacturer\Model\Attribute\Source;

use Magento\Eav\Model\Entity\Attribute\Source\AbstractSource;
use Magento\Framework\Data\OptionSourceInterface;
use YourCompany\Manufacturer\Model\ResourceModel\Manufacturer\CollectionFactory;

class Manufacturer extends AbstractSource implements OptionSourceInterface
{
    protected $collectionFactory;

    public function __construct(CollectionFactory $collectionFactory)
    {
        $this->collectionFactory = $collectionFactory;
    }

    public function getAllOptions()
    {
        $options = [];

        $collection = $this->collectionFactory->create();
        $collection->addFieldToSelect('*');
        $collection->addFieldToFilter('status', 1);
        $collection->setOrder('name', 'ASC');

        foreach ($collection as $manufacturer) {
            $options[] = [
                'value' => $manufacturer->getId(),
                'label' => $manufacturer->getName(),
            ];
        }

        return $options;
    }
}
Create a file called di.xml in the app/code/YourCompany/Manufacturer/etc directory with the following code:
xml
Copy code
<?xml version="1.0"?>
<config xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:noNamespaceSchemaLocation="urn:magento:framework:ObjectManager/etc/config.xsd">
   <preference for="YourCompany\Manufacturer\Model\ResourceModel\Manufacturer\Collection" type="YourCompany\Manufacturer\Model\ResourceModel\Manufacturer\Collection" />
   <preference for="YourCompany\Manufacturer\Model\Attribute\Source\Manufacturer" type="YourCompany\Manufacturer\Model\Attribute\Source\Manufacturer" />
</config>
Run the following commands in the Magento 2 root directory:
bash
Copy code
bin/magento module:enable YourCompany_Manufacturer
bin/magento setup:upgrade
bin/magento cache:clean
After following these steps, you should be able to see the manufacturer attribute in the product edit page. When you select a manufacturer from the dropdown, the attribute ID will be associated with the product.




Gbless Sylva
Add admin interface such that the admin can add a manufacturer with the following fields Id, name.
To add an admin interface for adding manufacturers, follow these steps:

Create a new file called Manufacturer.php in the app/code/YourCompany/Manufacturer/Controller/Adminhtml directory with the following code:
php
Copy code
<?php
namespace YourCompany\Manufacturer\Controller\Adminhtml;

use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use Magento\Backend\App\Action;

class Manufacturer extends Action
{
    protected $resultPageFactory;

    public function __construct(Context $context, PageFactory $resultPageFactory)
    {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
    }

    public function execute()
    {
        $resultPage = $this->resultPageFactory->create();
        $resultPage->getConfig()->getTitle()->prepend(__('Add Manufacturer'));

        return $resultPage;
    }
}
Create a new file called Add.php in the app/code/YourCompany/Manufacturer/Controller/Adminhtml/Manufacturer directory with the following code:
php
Copy code
<?php
namespace YourCompany\Manufacturer\Controller\Adminhtml\Manufacturer;

use Magento\Backend\App\Action;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultFactory;

class Add extends Action
{
    public function execute()
    {
        $resultPage = $this->resultFactory->create(ResultFactory::TYPE_PAGE);
        $resultPage->getConfig()->getTitle()->prepend(__('Add Manufacturer'));

        return $resultPage;
    }
}
Create a new file called Form.php in the app/code/YourCompany/Manufacturer/Block/Adminhtml/Manufacturer/Edit directory with the following code:
php
Copy code
<?php
namespace YourCompany\Manufacturer\Block\Adminhtml\Manufacturer\Edit;

use Magento\Backend\Block\Widget\Form\Generic;
use Magento\Framework\Data\Form as DataForm;
use Magento\Framework\Data\FormFactory;
use Magento\Framework\Registry;
use Magento\Backend\Block\Template\Context;

class Form extends Generic
{
    protected $_systemStore;

    public function __construct(
        Context $context,
        Registry $registry,
        FormFactory $formFactory,
        array $data = []
    ) {
        parent::__construct($context, $registry, $formFactory, $data);
    }

    protected function _construct()
    {
        parent::_construct();
        $this->setId('manufacturer_form');
        $this->setTitle(__('Manufacturer Information'));
    }

    protected function _prepareForm()
    {
        $model = $this->_coreRegistry->registry('manufacturer');
        $form = $this->_formFactory->create(
            ['data' => [
                'id' => 'edit_form',
                'action' => $this->getData('action'),
                'method' => 'post',
                'enctype' => 'multipart/form-data'
            ]
            ]
        );

        $form->setUseContainer(true);
        $this->setForm($form);

        $fieldset = $form->addFieldset(
            'base_fieldset',
            ['legend' => __('Manufacturer Information'), 'class' => 'fieldset-wide']
        );

        if ($model->getId()) {
            $fieldset->addField('manufacturer_id', 'hidden', ['name' => 'manufacturer_id']);
        }

        $fieldset->addField(
            'name',
            'text',
            [
                'name' => 'name',
                'label' => __('Name'),
                'title' => __('Name'),
                'required' => true
            ]
        );

        $form->setValues($model->getData());
        $this->setForm($form);

        return parent::_prepareForm();
    }
}
Create a new file called Edit.php in the app/code/YourCompany/Manufacturer/Block/Adminhtml/Manufacturer directory with the following code:
``




Gbless Sylva
continue
php
Copy code
<?php
namespace YourCompany\Manufacturer\Block\Adminhtml\Manufacturer;

use Magento\Backend\Block\Widget\Form\Container;
use Magento\Framework\Registry;
use Magento\Backend\Block\Widget\Context;

class Edit extends Container
{
    protected $_coreRegistry;

    public function __construct(
        Context $context,
        Registry $registry,
        array $data = []
    ) {
        $this->_coreRegistry = $registry;
        parent::__construct($context, $data);
    }

    protected function _construct()
    {
        $this->_objectId = 'manufacturer_id';
        $this->_blockGroup = 'YourCompany_Manufacturer';
        $this->_controller = 'adminhtml_manufacturer';

        parent::_construct();

        if ($this->_isAllowedAction('YourCompany_Manufacturer::save')) {
            $this->buttonList->update('save', 'label', __('Save Manufacturer'));
            $this->buttonList->add(
                'saveandcontinue',
                [
                    'label' => __('Save and Continue Edit'),
                    'class' => 'save',
                    'data_attribute' => [
                        'mage-init' => [
                            'button' => ['event' => 'saveAndContinueEdit', 'target' => '#edit_form'],
                        ],
                    ],
                ],
                -100
            );
        } else {
            $this->buttonList->remove('save');
        }

        if ($this->_isAllowedAction('YourCompany_Manufacturer::delete')) {
            $this->buttonList->update('delete', 'label', __('Delete Manufacturer'));
        } else {
            $this->buttonList->remove('delete');
        }
    }

    public function getHeaderText()
    {
        $manufacturer = $this->_coreRegistry->registry('manufacturer');
        if ($manufacturer->getId()) {
            return __("Edit Manufacturer '%1'", $this->escapeHtml($manufacturer->getName()));
        } else {
            return __('Add Manufacturer');
        }
    }

    protected function _isAllowedAction($resourceId)
    {
        return $this->_authorization->isAllowed($resourceId);
    }
}
Create a new file called Save.php in the app/code/YourCompany/Manufacturer/Controller/Adminhtml/Manufacturer directory with the following code:
php
Copy code
<?php
namespace YourCompany\Manufacturer\Controller\Adminhtml\Manufacturer;

use Magento\Backend\App\Action;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultFactory;

class Save extends Action
{
    public function execute()
    {
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        $resultRedirect->setPath('*/manufacturer/index');

        $data = $this->getRequest()->getPostValue();

        if (!$data) {
            return $resultRedirect;
        }

        try {
            $model = $this->_objectManager->create('YourCompany\Manufacturer\Model\Manufacturer');

            if (isset($data['manufacturer_id'])) {
                $model->load($data['manufacturer_id']);
            }

            $model->setData($data);
            $model->save();

            $this->messageManager->addSuccess(__('Manufacturer has been saved.'));
            $resultRedirect->setPath('*/manufacturer/edit', ['manufacturer_id' => $model->getId(), '_current' => true]);

            return $resultRedirect;
        } catch (\Exception $e) {
            $this->messageManager->addError($e->getMessage());
            $this->_objectManager->get('Psr\Log\LoggerInterface')->critical($e);

            return $resultRedirect;
        }
    }
}
Create a new file called Index.php in the app/code/YourCompany/Manufacturer/Controller/Adminhtml/Manufacturer directory with the following code:
php
Copy code
<?php
namespace YourCompany



Gbless Sylva
continue
\Manufacturer\Controller\Adminhtml\Manufacturer;

use Magento\Backend\App\Action\Context;
use Magento\Backend\App\Action;
use Magento\Framework\View\Result\PageFactory;

class Index extends Action
{
protected $resultPageFactory;

php
Copy code
public function __construct(Context $context, PageFactory $resultPageFactory)
{
    parent::__construct($context);
    $this->resultPageFactory = $resultPageFactory;
}

public function execute()
{
    $resultPage = $this->resultPageFactory->create();
    $resultPage->getConfig()->getTitle()->prepend(__('Manufacturer'));

    return $resultPage;
}
}

sql
Copy code

7. Create a new file called Delete.php in the app/code/YourCompany/Manufacturer/Controller/Adminhtml/Manufacturer directory with the following code:

<?php
namespace YourCompany\Manufacturer\Controller\Adminhtml\Manufacturer;

use Magento\Backend\App\Action;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Exception\LocalizedException;

class Delete extends Action
{
    public function execute()
    {
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        $resultRedirect->setPath('*/manufacturer/index');

        $id = $this->getRequest()->getParam('manufacturer_id');
        if (!$id) {
            $this->messageManager->addError(__('Manufacturer ID not provided.'));
            return $resultRedirect;
        }

        try {
            $model = $this->_objectManager->create('YourCompany\Manufacturer\Model\Manufacturer');
            $model->load($id);
            $model->delete();

            $this->messageManager->addSuccess(__('Manufacturer has been deleted.'));
            $resultRedirect->setPath('*/manufacturer/index');

            return $resultRedirect;
        } catch (LocalizedException $e) {
            $this->messageManager->addError($e->getMessage());
            return $resultRedirect;
        } catch (\Exception $e) {
            $this->messageManager->addError(__('An error occurred while deleting the manufacturer.'));
            return $resultRedirect;
        }
    }
}
```

8. Create a new file called Grid.php in the app/code/YourCompany/Manufacturer/Block/Adminhtml/Manufacturer directory with the following code:

```
<?php
namespace YourCompany\Manufacturer\Block\Adminhtml\Manufacturer;

use Magento\Backend\Block\Widget\Grid\Container;

class Grid extends Container
{
    protected function _construct()
    {
        $this->_controller = 'adminhtml_manufacturer';
        $this->_blockGroup = 'YourCompany_Manufacturer';
        $this->_headerText = __('Manufacturer');
        $this->_addButtonLabel = __('Add New Manufacturer');
        parent::_construct();
    }
}
```

9. Create a new file called Actions.php in the app/code/YourCompany/Manufacturer/Controller/Adminhtml/Manufacturer directory with the following code:

```
<?php
namespace YourCompany\Manufacturer\Controller\Adminhtml\Manufacturer;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;

class Actions extends Action
{
    protected $resultPageFactory;

    public function __construct(Context $context, PageFactory $resultPageFactory)
    {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
    }

    public function execute()
    {
        $resultPage = $this->resultPageFactory->create();
        $resultPage->getConfig()->getTitle()->prepend(__('Manufacturer'));

        return $resultPage;
    }
}
```

10. Finally, create a new file called routes.xml in the app/code/YourCompany/Manufacturer/etc/adminhtml directory with the following code:

```
<?xml version="1.0"?>
<config xmlns:xsi="http://www




Gbless Sylva
continue
Create a new file called edit.php in the app/code/YourCompany/Manufacturer/Controller/Adminhtml/Manufacturer directory with the following code:
php
Copy code
<?php
namespace YourCompany\Manufacturer\Controller\Adminhtml\Manufacturer;

use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;

class Edit extends \Magento\Backend\App\Action
{
    protected $_coreRegistry;
    protected $resultPageFactory;

    public function __construct(
        Context $context,
        \Magento\Framework\Registry $coreRegistry,
        PageFactory $resultPageFactory
    ) {
        $this->_coreRegistry = $coreRegistry;
        $this->resultPageFactory = $resultPageFactory;
        parent::__construct($context);
    }

    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('YourCompany_Manufacturer::manufacturer');
    }

    public function execute()
    {
        $id = $this->getRequest()->getParam('manufacturer_id');
        $model = $this->_objectManager->create('YourCompany\Manufacturer\Model\Manufacturer');

        if ($id) {
            $model->load($id);
            if (!$model->getId()) {
                $this->messageManager->addError(__('This manufacturer no longer exists.'));
                $resultRedirect = $this->resultRedirectFactory->create();
                $resultRedirect->setPath('*/*/');
                return $resultRedirect;
            }
        }

        $data = $this->_objectManager->get('Magento\Backend\Model\Session')->getFormData(true);
        if (!empty($data)) {
            $model->setData($data);
        }

        $this->_coreRegistry->register('manufacturer', $model);

        $resultPage = $this->resultPageFactory->create();
        $resultPage->getConfig()->getTitle()->prepend(__('Manufacturer'));

        return $resultPage;
    }
}
Create a new file called save.php in the app/code/YourCompany/Manufacturer/Controller/Adminhtml/Manufacturer directory with the following code:
php
Copy code
<?php
namespace YourCompany\Manufacturer\Controller\Adminhtml\Manufacturer;

use Magento\Backend\App\Action\Context;
use YourCompany\Manufacturer\Model\Manufacturer;

class Save extends \Magento\Backend\App\Action
{
    protected $_coreRegistry;

    public function __construct(
        Context $context,
        \Magento\Framework\Registry $coreRegistry
    ) {
        $this->_coreRegistry = $coreRegistry;
        parent::__construct($context);
    }

    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('YourCompany_Manufacturer::manufacturer');
    }

    public function execute()
    {
        $data = $this->getRequest()->getPostValue();
        $resultRedirect = $this->resultRedirectFactory->create();
        $id = isset($data['manufacturer_id']) ? $data['manufacturer_id'] : null;

        if ($id) {
            $model = $this->_objectManager->create('YourCompany\Manufacturer\Model\Manufacturer')->load($id);
            if (!$model->getId()) {
                $this->messageManager->addError(__('This manufacturer no longer exists.'));
                return $resultRedirect->setPath('*/*/');
            }
        } else {
            $model = $this->_objectManager->create('YourCompany\Manufacturer\Model\Manufacturer');
        }

        $model->setData($data);

        try {
            $model->save();
            $this->messageManager->addSuccess(__('Manufacturer has been saved.'));
            $this->_objectManager->get('Magento\Backend\Model\Session')->setFormData(false);
            if ($this->getRequest()->getParam('back')) {
                return $resultRedirect->setPath('*/*/edit', ['manufacturer_id' => $model->getId()]);
            }
            return $resultRedirect->setPath('*



Gbless Sylva
continue
Create a new file called delete.php in the app/code/YourCompany/Manufacturer/Controller/Adminhtml/Manufacturer directory with the following code:
php
Copy code
<?php
namespace YourCompany\Manufacturer\Controller\Adminhtml\Manufacturer;

use Magento\Backend\App\Action\Context;
use YourCompany\Manufacturer\Model\Manufacturer;

class Delete extends \Magento\Backend\App\Action
{
    protected $_coreRegistry;

    public function __construct(
        Context $context,
        \Magento\Framework\Registry $coreRegistry
    ) {
        $this->_coreRegistry = $coreRegistry;
        parent::__construct($context);
    }

    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('YourCompany_Manufacturer::manufacturer');
    }

    public function execute()
    {
        $id = $this->getRequest()->getParam('manufacturer_id');
        if ($id) {
            try {
                $model = $this->_objectManager->create('YourCompany\Manufacturer\Model\Manufacturer')->load($id);
                $model->delete();
                $this->messageManager->addSuccess(__('Manufacturer has been deleted.'));
            } catch (\Exception $e) {
                $this->messageManager->addError(__('Error while trying to delete manufacturer: %1', $e->getMessage()));
            }
        }
        $resultRedirect = $this->resultRedirectFactory->create();
        return $resultRedirect->setPath('*/*/');
    }
}
Create a new file called newmanufacturer.xml in the app/code/YourCompany/Manufacturer/view/adminhtml/layout directory with the following code:
xml
Copy code
<?xml version="1.0"?>
<page xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:noNamespaceSchemaLocation="urn:magento:framework:View/Layout/etc/page_configuration.xsd">
    <body>
        <referenceContainer name="content">
            <block class="YourCompany\Manufacturer\Block\Adminhtml\Manufacturer\Edit" name="yourcompany.manufacturer.edit"/>
        </referenceContainer>
    </body>
</page>
Create a new file called editmanufacturer.xml in the app/code/YourCompany/Manufacturer/view/adminhtml/layout directory with the following code:
xml
Copy code
<?xml version="1.0"?>
<page xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:noNamespaceSchemaLocation="urn:magento:framework:View/Layout/etc/page_configuration.xsd">
    <body>
        <referenceContainer name="content">
            <block class="YourCompany\Manufacturer\Block\Adminhtml\Manufacturer\Edit" name="yourcompany.manufacturer.edit"/>
        </referenceContainer>
    </body>
</page>
Create a new file called index.xml in the app/code/YourCompany/Manufacturer/view/adminhtml/layout directory with the following code:
xml
Copy code
<?xml version="1.0"?>
<page xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:noNamespaceSchemaLocation="urn:magento:framework:View/Layout/etc/page_configuration.xsd">
    <body>
        <referenceContainer name="content">
            <block class="YourCompany\Manufacturer\Block\Adminhtml\Manufacturer" name="yourcompany.manufacturer"/>
        </referenceContainer>
    </body>
</page>
Finally, clear the cache by running the following command in the command prompt/terminal:
bash
Copy code
php bin/magento cache:clean
You should now have a fully functional Magento 2 module called Manufacturer that creates an attribute called Manufacturer, is visible on the product edit page, and has an admin interface for adding, editing, and deleting manufacturers.


Here are the steps to create a Magento 2 module that adds a manufacturer attribute:

Create a new directory for the module in the app/code directory. For example, app/code/YourCompany/Manufacturer.
Create a module.xml file in the app/code/YourCompany/Manufacturer/etc directory with the following code:
xml
Copy code
<?xml version="1.0"?>
<config xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:noNamespaceSchemaLocation="urn:magento:framework:Module/etc/module.xsd">
   <module name="YourCompany_Manufacturer" setup_version="1.0.0">
   </module>
</config>
Create a registration.php file in the app/code/YourCompany/Manufacturer directory with the following code:
php
Copy code
<?php
\Magento\Framework\Component\ComponentRegistrar::register(
    \Magento\Framework\Component\ComponentRegistrar::MODULE,
    'YourCompany_Manufacturer',
    __DIR__
);
Create a file called InstallData.php in the app/code/YourCompany/Manufacturer/Setup directory with the following code:
php
Copy code
<?php
namespace YourCompany\Manufacturer\Setup;
use Magento\Catalog\Model\Product;
use Magento\Catalog\Model\ResourceModel\Eav\Attribute;
use Magento\Catalog\Setup\CategorySetupFactory;
use Magento\Eav\Model\Config;
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\UpgradeDataInterface;
use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;

class InstallData implements InstallDataInterface
{
    private $eavSetupFactory;
    private $attributeSetFactory;
    private $categorySetupFactory;
    private $config;

    public function __construct(EavSetupFactory $eavSetupFactory, \Magento\Eav\Model\Entity\Attribute\SetFactory $attributeSetFactory, CategorySetupFactory $categorySetupFactory, Config $config)
    {
        $this->eavSetupFactory = $eavSetupFactory;
        $this->attributeSetFactory = $attributeSetFactory;
        $this->categorySetupFactory = $categorySetupFactory;
        $this->config = $config;
    }

    public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        $eavSetup = $this->eavSetupFactory->create(['setup' => $setup]);
        $attributeSetId = $this->categorySetupFactory->create()->getDefaultAttributeSetId(Product::ENTITY);

        $eavSetup->addAttribute(Product::ENTITY, 'manufacturer', [
            'type' => 'int',
            'label' => 'Manufacturer',
            'input' => 'select',
            'required' => false,
            'global' => \Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface::SCOPE_STORE,
            'source' => 'YourCompany\Manufacturer\Model\Attribute\Source\Manufacturer',
            'group' => 'General Information',
            'attribute_set_id' => $attributeSetId,
            'visible' => true,
            'searchable' => false,
            'filterable' => true,
            'comparable' => false,
            'user_defined' => true,
            'visible_on_front' => true,
            'used_in_product_listing' => true,
            'unique' => false,
        ]);
    }
}
Create a file called Manufacturer.php in the



Gbless Sylva
continue
Create a file called Manufacturer.php in the app/code/YourCompany/Manufacturer/Model/Attribute/Source directory with the following code:
php
Copy code
<?php
namespace YourCompany\Manufacturer\Model\Attribute\Source;

use Magento\Eav\Model\Entity\Attribute\Source\AbstractSource;
use Magento\Framework\Data\OptionSourceInterface;
use YourCompany\Manufacturer\Model\ResourceModel\Manufacturer\CollectionFactory;

class Manufacturer extends AbstractSource implements OptionSourceInterface
{
    protected $collectionFactory;

    public function __construct(CollectionFactory $collectionFactory)
    {
        $this->collectionFactory = $collectionFactory;
    }

    public function getAllOptions()
    {
        $options = [];

        $collection = $this->collectionFactory->create();
        $collection->addFieldToSelect('*');
        $collection->addFieldToFilter('status', 1);
        $collection->setOrder('name', 'ASC');

        foreach ($collection as $manufacturer) {
            $options[] = [
                'value' => $manufacturer->getId(),
                'label' => $manufacturer->getName(),
            ];
        }

        return $options;
    }
}
Create a file called di.xml in the app/code/YourCompany/Manufacturer/etc directory with the following code:
xml
Copy code
<?xml version="1.0"?>
<config xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:noNamespaceSchemaLocation="urn:magento:framework:ObjectManager/etc/config.xsd">
   <preference for="YourCompany\Manufacturer\Model\ResourceModel\Manufacturer\Collection" type="YourCompany\Manufacturer\Model\ResourceModel\Manufacturer\Collection" />
   <preference for="YourCompany\Manufacturer\Model\Attribute\Source\Manufacturer" type="YourCompany\Manufacturer\Model\Attribute\Source\Manufacturer" />
</config>
Run the following commands in the Magento 2 root directory:
bash
Copy code
bin/magento module:enable YourCompany_Manufacturer
bin/magento setup:upgrade
bin/magento cache:clean
After following these steps, you should be able to see the manufacturer attribute in the product edit page. When you select a manufacturer from the dropdown, the attribute ID will be associated with the product.









if ($parentCategory->getId() === \Magento\Catalog\Model\Category::TREE_ROOT_ID) {

<?php
$breadcrumbs = $block->getLayout()->getBlock('breadcrumbs');
$category = $block->getCurrentCategory();

if ($breadcrumbs && $category) {
    $breadcrumbs->addCrumb(
        'home',
        [
            'label' => __('Home'),
            'title' => __('Go to Home Page'),
            'link' => $this->getUrl('')
        ]
    );

    $parentCategories = $category->getParentCategories();
    $categoryPath = [];
    foreach ($parentCategories as $parent) {
        if (!$parent->getIsActive()) {
            continue;
        }
        $categoryPath[] = [
            'label' => $parent->getName(),
            'link' => $parent->getUrl()
        ];
    }

    $categoryPath[] = [
        'label' => $category->getName(),
        'link' => ''
    ];

    foreach ($categoryPath as $key => $value) {
        $breadcrumbs->addCrumb('category' . $key, $value);
    }
}
?>



<?php
    $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
    $category = $objectManager->create('Magento\Catalog\Model\Category')->load($categoryId);
    $breadcrumbCategories = $category->getParentCategories();
    $breadcrumbs = array();
    foreach ($breadcrumbCategories as $category) {
        if($category->getId() != 1) { // Exclude Root Category
            $breadcrumbs[] = [
                'label' => $category->getName(),
                'url' => $category->getUrl()
            ];
        }
    }
    // Add Current Category
    $breadcrumbs[] = ['label' => $category->getName(), 'title' => $category->getName()];
?>

<div class="breadcrumbs">
    <?php foreach ($breadcrumbs as $breadcrumb) : ?>
        <?php if (!$loop->last) : ?>
            <a href="<?php echo $breadcrumb['url']; ?>"><?php echo $breadcrumb['label']; ?></a> &nbsp;&gt;&nbsp;
        <?php else : ?>
            <strong><?php echo $breadcrumb['label']; ?></strong>
        <?php endif; ?>
    <?php endforeach; ?>
</div>





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
