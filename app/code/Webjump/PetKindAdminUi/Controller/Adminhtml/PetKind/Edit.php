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
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultInterface;
use Webjump\PetKindAdminUi\Controller\Adminhtml\Base;

class Edit extends Base implements HttpGetActionInterface
{
    /**
     * @return ResponseInterface|ResultInterface
     */
    public function execute()
    {
        $id = (int)$this->request->getParam('entity_id');

        if ($id) {
            try {
                $model = $this->petKindRepository->getById($id);
                $id = $model->getEntityId();
            } catch (Exception $exception) {
                $this->messageManager->addErrorMessage(__('This Pet Kind no longer exists.'));
                $resultRedirect = $this->resultRedirectFactory->create();

                return $resultRedirect->setPath('*/*/');
            }
        }

        $resultPage = $this->resultPageFactory->create();
        $this->initPage($resultPage)
            ->addBreadcrumb(
                $id ? __('Edit Pet Kind') : __('New Pet Kind'),
                $id ? __('Edit Pet Kind') : __('New Pet Kind')
            );
        $resultPage->getConfig()
            ->getTitle()
            ->prepend(__('Pet Kind'));

        $resultPage->getConfig()
            ->getTitle()
            ->prepend(
                $id ? __('Edit Pet Kind %1', $model->getEntityId()) : __('New Pet Kind')
            );

        return $resultPage;
    }
}
