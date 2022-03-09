<?php
/**
 * @author      Webjump Develop Team <dev@webjump.com.br>
 * @copyright   2022 Webjump (http://www.webjump.com.br)
 * @license     http://www.webjump.com.br Copyright
 * @link        http://www.webjump.com.br
 */

declare(strict_types=1);

namespace Webjump\PetKind\Model\ResourceModel\PetKind;

use Webjump\PetKind\Model\Data\PetKind as Model;
use Webjump\PetKind\Model\ResourceModel\PetKind as ResourceModel;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    /**
     * Construct method from Collection
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(Model::class,ResourceModel::class);
    }
}
