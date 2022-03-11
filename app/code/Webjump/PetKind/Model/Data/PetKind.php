<?php
/**
 * @author      Webjump Develop Team <dev@webjump.com.br>
 * @copyright   2022 Webjump (http://www.webjump.com.br)
 * @license     http://www.webjump.com.br Copyright
 * @link        http://www.webjump.com.br
 */

declare(strict_types=1);

namespace Webjump\PetKind\Model\Data;

use Magento\Framework\Model\AbstractModel;
use Webjump\PetKind\Api\Data\PetKindInterface;
use Webjump\PetKind\Model\ResourceModel\PetKind as ResourceModel;

class PetKind extends AbstractModel implements PetKindInterface
{
    /**
     * Construct method from Pet Model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(ResourceModel::class);
    }

    /**
     * Get the entity ID from a pet kind
     *
     * @return int
     */
    public function getEntityId(): int
    {
        return (int)$this->getData(self::ENTITY_ID);
    }

    /**
     * Get the pet kind name
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->getData(self::NAME);
    }

    /**
     * Set the pet kind name
     *
     * @param string $name
     * @return void
     */
    public function setName(string $name): void
    {
        $this->setData(self::NAME, $name);
    }

    /**
     * Get the pet kind description
     *
     * @return string
     */
    public function getDescription(): string
    {
        return $this->getData(self::DESCRIPTION);
    }

    /**
     * Set the pet kind description
     *
     * @param string $description
     * @return void
     */
    public function setDescription(string $description): void
    {
        $this->setData(self::DESCRIPTION, $description);
    }
}
