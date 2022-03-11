<?php
/**
 * @author      Webjump Develop Team <dev@webjump.com.br>
 * @copyright   2022 Webjump (http://www.webjump.com.br)
 * @license     http://www.webjump.com.br Copyright
 * @link        http://www.webjump.com.br
 */

declare(strict_types=1);

namespace Webjump\PetKind\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class PetKind extends AbstractDb
{
    /**
     * @const MAIN_TABLE
     */
    const MAIN_TABLE = 'pet_kind';

    /**
     * @const ID_FIELD_NAME
     */
    const ID_FIELD_NAME = 'entity_id';

    /**
     * Construct method from Resource Model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(self::MAIN_TABLE, self::ID_FIELD_NAME);
    }
}

