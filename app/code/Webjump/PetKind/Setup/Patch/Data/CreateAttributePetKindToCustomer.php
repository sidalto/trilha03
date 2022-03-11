<?php
/**
 * @author      Webjump Develop Team <dev@webjump.com.br>
 * @copyright   2022 Webjump (http://www.webjump.com.br)
 * @license     http://www.webjump.com.br Copyright
 * @link        http://www.webjump.com.br
 */

declare(strict_types=1);

namespace Webjump\PetKind\Setup\Patch\Data;

use Webjump\PetKind\Model\Config\Source\SelectPetKind;
use Magento\Customer\Api\CustomerMetadataInterface;
use Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface;
use Magento\Customer\Model\ResourceModel\Attribute as AttributeResource;
use Magento\Customer\Setup\CustomerSetup;
use Magento\Customer\Setup\CustomerSetupFactory;
use Magento\Framework\Setup\Patch\PatchRevertableInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Exception\LocalizedException;
use Zend_Validate_Exception;

class CreateAttributePetKindToCustomer implements DataPatchInterface, PatchRevertableInterface
{
    /**
     * @var ModuleDataSetupInterface
     */
    private ModuleDataSetupInterface $moduleDataSetup;

    /**
     * @var CustomerSetup
     */
    private CustomerSetup $customerSetup;

    /**
     * @var CustomerSetupFactory
     */
    protected CustomerSetupFactory $customerSetupFactory;

    /**
     * @var AttributeResource
     */
    private AttributeResource $attributeResource;

    /**
     * @const ATTRIBUTE_CODE
     */
    public const ATTRIBUTE_CODE = 'pet_kind';

    /**
     * @param ModuleDataSetupInterface $moduleDataSetup
     * @param CustomerSetupFactory $customerSetupFactory
     * @param AttributeResource $attributeResource
     */
    public function __construct(
        ModuleDataSetupInterface $moduleDataSetup,
        CustomerSetupFactory $customerSetupFactory,
        AttributeResource $attributeResource
    ) {
        $this->moduleDataSetup = $moduleDataSetup;
        $this->customerSetup = $customerSetupFactory->create(['setup' => $moduleDataSetup]);
        $this->attributeResource = $attributeResource;
    }

    /**
     * Method to apply configuration
     *
     * @return void
     * @throws LocalizedException
     * @throws Zend_Validate_Exception
     */
    public function apply(): void
    {
        $this->moduleDataSetup->getConnection()->startSetup();

        $this->customerSetup->addAttribute(
            CustomerMetadataInterface::ENTITY_TYPE_CUSTOMER,
            self::ATTRIBUTE_CODE,
            $this->getFields()
        );

        $this->customerSetup->addAttributeToSet(
            CustomerMetadataInterface::ENTITY_TYPE_CUSTOMER,
            CustomerMetadataInterface::ATTRIBUTE_SET_ID_CUSTOMER,
            null,
            self::ATTRIBUTE_CODE
        );

        $attribute = $this->customerSetup
            ->getEavConfig()
            ->getAttribute(
                CustomerMetadataInterface::ENTITY_TYPE_CUSTOMER,
                self::ATTRIBUTE_CODE
            );

        $attribute->setData('used_in_forms', 'adminhtml_customer');

        $this->attributeResource->save($attribute);

        $this->moduleDataSetup->getConnection()->endSetup();
    }

    /**
     * Get fields method to pet kind attribute
     *
     * @return array
     */
    public function getFields(): array
    {
        return [
            'type' => 'varchar',
            'label' => __('Pet Kind'),
            'input' => 'select',
            'is_global' => false,
            'global' => ScopedAttributeInterface::SCOPE_STORE,
            'backend' => '',
            'source' => SelectPetKind::class,
            'required' => false,
            'user_defined' => true,
            'use_in_filter_options' => true,
            'is_used_in_grid' => true,
            'is_visible_in_grid' => true,
            'is_filterable_in_grid' => true,
            'system' => false
        ];
    }

    /**
     * Method to revert configuration
     *
     * @return void
     */
    public function revert(): void
    {
        $this->moduleDataSetup->getConnection()->startSetup();

        $this->customerSetup->removeAttribute(
            CustomerMetadataInterface::ENTITY_TYPE_CUSTOMER,
            self::ATTRIBUTE_CODE
        );

        $this->moduleDataSetup->getConnection()->endSetup();
    }

    /**
     * Method to get dependencies
     *
     * @return array
     */
    public static function getDependencies(): array
    {
        return [];
    }

    /**
     * Method to get aliases
     *
     * @return array
     */
    public function getAliases(): array
    {
        return [];
    }
}

