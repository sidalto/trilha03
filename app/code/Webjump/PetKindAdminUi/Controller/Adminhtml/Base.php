<?php
/**
 * @author      Webjump Develop Team <dev@webjump.com.br>
 * @copyright   2022 Webjump (http://www.webjump.com.br)
 * @license     http://www.webjump.com.br Copyright
 * @link        http://www.webjump.com.br
 */

declare(strict_types=1);

namespace Webjump\PetKindAdminUi\Controller\Adminhtml;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\View\Result\ForwardFactory;
use Magento\Backend\Model\View\Result\Page;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Controller\Result\RedirectFactory;
use Magento\Framework\Message\ManagerInterface as MessageManagerInterface;
use Magento\Framework\View\Result\PageFactory;
use Webjump\PetKind\Api\PetKindRepositoryInterface;
use Webjump\PetKind\Model\Data\PetKindFactory;

abstract class Base extends Action
{
//    const ADMIN_RESOURCE = 'Webjump_PetKindAdminUi::item';

    /**
     * @var PetKindRepositoryInterface
     */
    protected PetKindRepositoryInterface $petKindRepository;

    /**
     * @var PetKindFactory
     */
    protected PetKindFactory $petKindFactory;

    /**
     * @var RequestInterface
     */
    protected RequestInterface $request;

    /**
     * @var MessageManagerInterface
     */
    protected $messageManager;

    /**
     * @var ForwardFactory
     */
    protected $resultForwardFactory;

    /**
     * @var RedirectFactory
     */
    protected $resultRedirectFactory;

    /**
     * @var PageFactory
     */
    protected $resultPageFactory;

    /**
     * @var DataPersistorInterface
     */
    protected DataPersistorInterface $dataPersistor;

    /**
     * Constructor to Base class
     *
     * @param PetKindRepositoryInterface $petKindRepository
     * @param PetKindFactory $petKindFactory
     * @param Context $context
     * @param RedirectFactory $resultRedirectFactory
     * @param ForwardFactory $resultForwardFactory
     * @param PageFactory $resultPageFactory
     * @param MessageManagerInterface $messageManager
     * @param RequestInterface $request
     * @param DataPersistorInterface $dataPersistor
     */
    public function __construct(
        Context $context,
        PetKindRepositoryInterface $petKindRepository,
        PetKindFactory $petKindFactory,
        RedirectFactory $resultRedirectFactory,
        ForwardFactory $resultForwardFactory,
        PageFactory $resultPageFactory,
        MessageManagerInterface $messageManager,
        RequestInterface $request,
        DataPersistorInterface $dataPersistor
    ) {
        parent::__construct($context);
        $this->petKindRepository = $petKindRepository;
        $this->petKindFactory = $petKindFactory;
        $this->resultRedirectFactory = $resultRedirectFactory;
        $this->resultForwardFactory = $resultForwardFactory;
        $this->resultPageFactory = $resultPageFactory;
        $this->messageManager = $messageManager;
        $this->request = $request;
        $this->dataPersistor = $dataPersistor;
    }


    /**
     * Init page
     *
     * @param Page $resultPage
     * @return Page
     */
    public function initPage(Page $resultPage): Page
    {
        return $resultPage;
    }
}
