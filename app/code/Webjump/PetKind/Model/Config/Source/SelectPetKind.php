<?php
/**
 * @author      Webjump Develop Team <dev@webjump.com.br>
 * @copyright   2022 Webjump (http://www.webjump.com.br)
 * @license     http://www.webjump.com.br Copyright
 * @link        http://www.webjump.com.br
 */

declare(strict_types=1);

namespace Webjump\PetKind\Model\Config\Source;

use Magento\Eav\Model\Entity\Attribute\Source\AbstractSource;
use Magento\Framework\Data\OptionSourceInterface;
use Webjump\PetKind\Model\ResourceModel\PetKind\CollectionFactory;

class SelectPetKind extends AbstractSource implements OptionSourceInterface
{
    /**
     * @var CollectionFactory
     */
    private CollectionFactory $collectionFactory;

    /**
     * @var array
     */
    protected $_options = [];

    /**
     * Constructor class to select PetKind class
     *
     * @param CollectionFactory $collectionFactory
     */
    public function __construct(CollectionFactory $collectionFactory)
    {
        $this->collectionFactory = $collectionFactory;
    }

    /**
     * Convert from Option Array
     *
     * @return array
     */
    public function toOptionArray(): array
    {
        if (!$this->_options) {
            $petKindCollection = $this->collectionFactory->create()->load();

            if ($petKindCollection->getSize()) {
                foreach ($petKindCollection->getItems() as $petKind) {
                    $this->_options[] = [
                        'label' => $petKind->getName(),
                        'value' => $petKind->getEntityId()
                    ];
                }
            }
        }

        return $this->_options;
    }

    /**
     * Get all options to pet kind
     *
     * @inheritDoc
     * @return array
     */
    public function getAllOptions(): array
    {
        return $this->toOptionArray();
    }
}
