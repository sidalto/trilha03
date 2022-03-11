<?php
/**
 * @author      Webjump Develop Team <dev@webjump.com.br>
 * @copyright   2022 Webjump (http://www.webjump.com.br)
 * @license     http://www.webjump.com.br Copyright
 * @link        http://www.webjump.com.br
 */

declare(strict_types=1);

namespace Webjump\PetKindAdminUi\Controller\Adminhtml\PetKind;

use Exception;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\View\Result\PageFactory;
use Webjump\PetKindAdminUi\Controller\Adminhtml\Base;

class Delete extends Base implements HttpGetActionInterface
{
    /**
     * Delete action
     *
     * @return ResultInterface
     */
    public function execute(): ResultInterface
    {
        $resultRedirect = $this->resultRedirectFactory->create();

        $id = (int)$this->request->getParam('entity_id');

        if ($id) {
            try {
                $model = $this->petKindRepository->getById($id);
                $this->petKindRepository->deleteById($model->getEntityId());
                $this->messageManager->addSuccessMessage(__('You deleted the Pet Kind.'));

                return $resultRedirect->setPath('*/*/');
            } catch (Exception $e) {
                $this->messageManager->addErrorMessage($e->getMessage());

                return $resultRedirect->setPath('*/*/edit', ['entity_id' => $id]);
            }
        }

        $this->messageManager->addErrorMessage(__('We can\'t find a Pet Kind to delete.'));

        return $resultRedirect->setPath('*/*/');
    }
}
