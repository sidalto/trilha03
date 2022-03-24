<?php
/**
 * @author      Webjump Develop Team <dev@webjump.com.br>
 * @copyright   2022 Webjump (http://www.webjump.com.br)
 * @license     http://www.webjump.com.br Copyright
 * @link        http://www.webjump.com.br
 */

declare(strict_types=1);

namespace Webjump\PetKind\Api\Data;

use Magento\Framework\Api\ExtensibleDataInterface;

interface PetKindInterface
{
    /**
     * @const ENTITY_ID
     */
    const ENTITY_ID = 'entity_id';

    /**
     * @const NAME
     */
    const NAME = 'name';

    /**
     * @const DESCRIPTION
     */
    const DESCRIPTION = 'description';

    /**
     * Get ID from pet kind entity
     *
     * @return int
     */
    public function getEntityId(): int;

    /**
     * Get the pet kind
     *
     * @return string|null
     */
    public function getName(): ?string;

    /**
     * Set the pet kind name
     *
     * @param string $name
     * @return void
     */
    public function setName(string $name): void;

    /**
     * Get the pet kind description
     *
     * @return string|null
     */
    public function getDescription(): ?string;

    /**
     * Set the pet kind description
     *
     * @param string $description
     * @return void
     */
    public function setDescription(string $description): void;
}
