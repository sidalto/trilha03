<?php
/**
 * @author      Webjump Develop Team <dev@webjump.com.br>
 * @copyright   2022 Webjump (http://www.webjump.com.br)
 * @license     http://www.webjump.com.br Copyright
 * @link        http://www.webjump.com.br
 */

declare(strict_types=1);

namespace Webjump\PetKindAdminUi\Test\Unit\Controller\Adminhtml;

use Magento\Backend\Model\View\Result\ForwardFactory;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Message\ManagerInterface as MessageManagerInterface;
use Magento\Framework\View\Result\PageFactory;
use PHPUnit\Framework\TestCase;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Controller\Result\RedirectFactory;
use Magento\Framework\Controller\Result\Redirect;
use Magento\Framework\Controller\ResultInterface;
use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\View\Result\Page;
use Webjump\PetKind\Api\Data\PetKindInterface;
use Webjump\PetKind\Model\Data\PetKind;
use Webjump\PetKind\Api\PetKindRepositoryInterface;
use Webjump\PetKind\Model\Data\PetKindFactory;
use Magento\Framework\View\Page\Config;
use Magento\Framework\View\Page\Title;
use Webjump\PetKindAdminUi\Controller\Adminhtml\PetKind\Edit;
use Webjump\PetKindAdminUi\Controller\Adminhtml\Base;

class BaseTest extends TestCase
{
    /**
     * @var ResultFactory
     */
    private ResultFactory $resultFactory;

    /**
     * @var ResultInterface
     */
    private ResultInterface $resultInterface;

    /**
     * @var RedirectFactory
     */
    private RedirectFactory $redirectFactory;

    /**
     * @var Redirect
     */
    private Redirect $redirect;

    /**
     * @var Context
     */
    private Context $context;

    /**
     * @var PetKindRepositoryInterface
     */
    private PetKindRepositoryInterface $petKindRepository;

    /**
     * @var PetKindFactory
     */
    private PetKindFactory $petKindFactory;

    /**
     * @var ForwardFactory
     */
    private ForwardFactory $resultForwardFactory;

    /**
     * @var PetKind
     */
    private PetKind $petKind;

    /**
     * @var PetKindInterface
     */
    private PetKindInterface $petKindInterface;

    /**
     * @var PageFactory
     */
    private PageFactory $resultPageFactory;

    /**
     * @var Page
     */
    private Page $page;

    /**
     * @var Config
     */
    private Config $pageConfig;

    /**
     * @var Title
     */
    private Title $pageTitle;

    /**
     * @var MessageManagerInterface
     */
    private MessageManagerInterface $messageManager;

    /**
     * @var RequestInterface
     */
    private RequestInterface $request;

    /**
     * @var DataPersistorInterface
     */
    private DataPersistorInterface $dataPersistor;

    /**
     * @var Base
     */
    private Base $base;

    /**
     * @return void
     */
    public function setUp(): void
    {
        $this->resultFactory = $this->createMock(ResultFactory::class);
        $this->redirectFactory = $this->createMock(RedirectFactory::class);
        $this->redirect = $this->createMock(Redirect::class);
        $this->resultInterface = $this->createMock(ResultInterface::class);
        $this->context = $this->createMock(Context::class);
        $this->petKindRepository = $this->createMock(PetKindRepositoryInterface::class);
        $this->petKindFactory = $this->createMock(PetKindFactory::class);
        $this->petKindInterface = $this->createMock(PetKindInterface::class);
        $this->petKind = $this->createMock(PetKind::class);
        $this->resultForwardFactory = $this->createMock(ForwardFactory::class);
        $this->resultPageFactory = $this->createMock(PageFactory::class);
        $this->page = $this->createMock(Page::class);
        $this->messageManager = $this->createMock(MessageManagerInterface::class);
        $this->request = $this->createMock(RequestInterface::class);
        $this->dataPersistor = $this->createMock(DataPersistorInterface::class);
        $this->base = $this->createMock(Base::class);
        $this->add = $this->createMock(Base::class);
        $this->pageConfig = $this->createMock(Config::class);
        $this->pageTitle = $this->createMock(Title::class);
    }

    /**
     * Test execute method
     *
     * @return void
     */
    public function testInitPage()
    {
        $result = $this->add->initPage($this->page);
        $this->assertInstanceOf(Page::class, $result);
        $this->assertEquals($this->add->initPage($this->page), $result);
    }
}
