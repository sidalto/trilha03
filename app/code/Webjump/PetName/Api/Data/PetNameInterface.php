<?php
/**
 * @author      Webjump Develop Team <dev@webjump.com.br>
 * @copyright   2022 Webjump (http://www.webjump.com.br)
 * @license     http://www.webjump.com.br Copyright
 * @link        http://www.webjump.com.br
 */

declare(strict_types=1);

namespace Webjump\PetName\Api\Data;

use Magento\Framework\Api\ExtensibleDataInterface;

interface PetNameInterface
{
    /**
     * @const ENTITY_ID
     */
    const ENTITY_ID = 'entity_id';

    /**
     * @const CUSTOMER_ID
     */
    const CUSTOMER_ID = 'customer_id';

    /**
     * @const NAME
     */
    const NAME = 'name';

    /**
     * Get ID from pet kind entity
     *
     * @return int
     */
    public function getEntityId(): int;

    /**
     * Get ID from customer owner pet
     *
     * @return int
     */
    public function getCustomerId(): int;

    /**
     * Set ID from customer owner pet
     *
     * @param int $customerId
     * @return void
     */
    public function setCustomerId(int $customerId): void;

    /**
     * Get the pet kind
     *
     * @return string
     */
    public function getName(): string;

    /**
     * Set the pet kind name
     *
     * @param string $name
     * @return void
     */
    public function setName(string $name): void;
}
