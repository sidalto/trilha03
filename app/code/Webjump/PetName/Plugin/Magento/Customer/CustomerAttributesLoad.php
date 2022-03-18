<?php
/**
 * @author      Webjump Develop Team <dev@webjump.com.br>
 * @copyright   2022 Webjump (http://www.webjump.com.br)
 * @license     http://www.webjump.com.br Copyright
 * @link        http://www.webjump.com.br
 */

declare(strict_types=1);

namespace Webjump\PetName\Plugin\Magento\Customer;

use Magento\Customer\Api\Data\CustomerExtensionInterface;
use Magento\Customer\Api\Data\CustomerInterface;
use Magento\Customer\Api\Data\CustomerExtensionFactory;

class CustomerAttributesLoad
{
    /**
     * @var CustomerExtensionFactory
     */
    private CustomerExtensionFactory $extensionFactory;

    /**
     * Constructor to CustomerAttributesLoad class
     *
     * @param CustomerExtensionFactory $extensionFactory
     */
    public function __construct(CustomerExtensionFactory $extensionFactory)
    {
        $this->extensionFactory = $extensionFactory;
    }

    /**
     * After plugin that loads customer entity extension attributes
     *
     * @param CustomerInterface $entity
     * @param CustomerExtensionInterface|null $extension
     * @return CustomerExtensionInterface
     */
    public function afterGetExtensionAttributes(
        CustomerInterface $entity,
        CustomerExtensionInterface $extension = null
    ): ?CustomerExtensionInterface {
        if ($extension === null) {
            $extension = $this->extensionFactory->create();
        }

        return $extension;
    }
}
