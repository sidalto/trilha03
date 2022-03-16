<?php
/**
 * @author      Webjump Develop Team <dev@webjump.com.br>
 * @copyright   2022 Webjump (http://www.webjump.com.br)
 * @license     http://www.webjump.com.br Copyright
 * @link        http://www.webjump.com.br
 */

declare(strict_types=1);

namespace Webjump\PetKindAdminUi\Controller\Adminhtml\PetKind;

use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\Controller\ResultInterface;
use Webjump\PetKindAdminUi\Controller\Adminhtml\Base;

class Index extends Base implements HttpGetActionInterface
{
    /**
     * Execute method to Index controller
     *
     * @return ResultInterface
     */
    public function execute(): ResultInterface
    {
        $resultPage = $this->resultPageFactory->create();

        $resultPage->getConfig()
            ->getTitle()
            ->prepend(__('Pet Kinds'));

        return $resultPage;
    }

    /**
     * Verify access method
     *
     * @return bool
     */
    protected function _isAllowed(): bool
    {
        return $this->_authorization->isAllowed('Webjump_PetKindAdminUi::item');
    }
}
