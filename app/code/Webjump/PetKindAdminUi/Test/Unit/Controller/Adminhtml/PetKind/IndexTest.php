<?php
/**
 * @author      Webjump Develop Team <dev@webjump.com.br>
 * @copyright   2022 Webjump (http://www.webjump.com.br)
 * @license     http://www.webjump.com.br Copyright
 * @link        http://www.webjump.com.br
 */

declare(strict_types=1);

namespace Webjump\PetKindAdminUi\Test\Unit\Controller\Adminhtml\PetKind;

use Magento\Backend\Model\View\Result\ForwardFactory;
use Magento\Backend\Model\View\Result\Page;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Message\ManagerInterface as MessageManagerInterface;
use Magento\Framework\View\Page\Config;
use Magento\Framework\View\Page\Title;
use Magento\Framework\View\Result\PageFactory;
use PHPUnit\Framework\TestCase;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Controller\Result\RedirectFactory;
use Magento\Framework\Controller\Result\Redirect;
use Magento\Framework\Controller\ResultInterface;
use Magento\Backend\App\Action\Context;
use Webjump\PetKind\Api\PetKindRepositoryInterface;
use Webjump\PetKind\Model\Data\PetKindFactory;
use Webjump\PetKindAdminUi\Controller\Adminhtml\PetKind\Add;
use Webjump\PetKindAdminUi\Controller\Adminhtml\PetKind\Index;

class IndexTest extends TestCase
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
     * @var PageFactory
     */
    private PageFactory $resultPageFactory;

    /**
     * @var Page
     */
    private Page $page;

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
     * @var Config
     */
    private Config $pageConfig;

    /**
     * @var Title
     */
    private Title $pageTitle;

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
        $this->resultForwardFactory = $this->createMock(ForwardFactory::class);
        $this->resultPageFactory = $this->createMock(PageFactory::class);
        $this->messageManager = $this->createMock(MessageManagerInterface::class);
        $this->request = $this->createMock(RequestInterface::class);
        $this->dataPersistor = $this->createMock(DataPersistorInterface::class);
        $this->page = $this->createMock(Page::class);
        $this->pageConfig = $this->createMock(Config::class);
        $this->pageTitle = $this->createMock(Title::class);

        $this->testSubject = new Index(
            $this->context,
            $this->petKindRepository,
            $this->petKindFactory,
            $this->redirectFactory,
            $this->resultForwardFactory,
            $this->resultPageFactory,
            $this->messageManager,
            $this->request,
            $this->dataPersistor
        );
    }

    /**
     * Test execute method
     *
     * @return void
     */
    public function testExecute()
    {
        $this->resultPageFactory
            ->expects($this->once())
            ->method('create')
            ->willReturn($this->page);

        $this->page
            ->expects($this->once())
            ->method('getConfig')
            ->willReturn($this->pageConfig);

        $this->pageConfig
            ->expects($this->once())
            ->method('getTitle')
            ->willReturn($this->pageTitle);

        $this->pageTitle
            ->expects($this->once())
            ->method('prepend')
            ->with(__('Pet Kinds'));

        $this->assertSame($this->page, $this->testSubject->execute());
    }
}
