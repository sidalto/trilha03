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
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Exception\LocalizedException;
use Webjump\PetKindAdminUi\Controller\Adminhtml\Base;

class Save extends Base implements HttpPostActionInterface
{
    /**
     * Result method to Save controller
     *
     * @return ResultInterface
     */
    public function execute(): ResultInterface
    {
        $resultRedirect = $this->resultRedirectFactory->create();

        $data = $this->request->getPostValue();

        if (!$data) {
            return $resultRedirect->setPath('*/*/');
        }

        try {
            $model = $this->petKindFactory->create();
            $model->setData($data);
            $this->petKindRepository->save($model);
            $this->messageManager->addSuccessMessage(__('You saved the Pet Kind.'));
            $this->dataPersistor->clear('pets_petkind_form_data_source');

            return $resultRedirect->setPath('*/*/');
        } catch (LocalizedException $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
        } catch (Exception $exception) {
            $this->messageManager->addExceptionMessage($exception, __('Something went wrong while saving the Pet Kind.'));
        }

        $this->dataPersistor->set('pets_petkind_form_data_source', $data);

        return $resultRedirect->setPath('*/*/edit', ['entity_id' => $this->request->getParam('entity_id')]);
    }
}
