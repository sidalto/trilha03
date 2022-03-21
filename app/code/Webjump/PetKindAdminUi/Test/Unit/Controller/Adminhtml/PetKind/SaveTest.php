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
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Exception\LocalizedException;
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
use Webjump\PetKindAdminUi\Controller\Adminhtml\Base;
use Webjump\PetKindAdminUi\Controller\Adminhtml\PetKind\Save;

class SaveTest extends TestCase
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
     * @var LocalizedException
     */
    private LocalizedException $localizedException;

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
        $this->petKind = $this->createMock(PetKind::class);
        $this->resultForwardFactory = $this->createMock(ForwardFactory::class);
        $this->resultPageFactory = $this->createMock(PageFactory::class);
        $this->page = $this->createMock(Page::class);
        $this->messageManager = $this->createMock(MessageManagerInterface::class);
        $this->dataPersistor = $this->createMock(DataPersistorInterface::class);
        $this->base = $this->createMock(Base::class);
        $this->pageConfig = $this->createMock(Config::class);
        $this->pageTitle = $this->createMock(Title::class);
        $this->localizedException = $this->createMock(LocalizedException::class);
        $this->request = $this->getMockBuilder(RequestInterface::class)
            ->disableOriginalConstructor()
            ->addMethods(['getPostValue'])
            ->getMockForAbstractClass();
        $this->petKindInterface = $this->getMockBuilder(PetKindInterface::class)
            ->disableOriginalConstructor()
            ->addMethods(['setData'])
            ->getMockForAbstractClass();

        $this->testSubject = new Save(
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
        $id = 1;

        $data = [
            'name' => 'Cão',
            'description' => 'Dócil'
        ];

        $this->redirectFactory
            ->expects($this->once())
            ->method('create')
            ->willReturn($this->redirect);

        $this->request
            ->expects($this->once())
            ->method('getPostValue')
            ->willReturn($data);

//        $this->request
//            ->expects($this->once())
//            ->method('getParams')
//            ->willReturn(['entity_id']);

        $this->petKindFactory
            ->expects($this->once())
            ->method('create')
            ->willReturn($this->petKindInterface);

        $this->petKindInterface
            ->expects($this->once())
            ->method('setData')
            ->with($data)
            ->willReturnSelf();

        $this->petKindRepository
            ->expects($this->once())
            ->method('save')
            ->with($this->petKindInterface)
            ->willReturn($id);

        $this->messageManager
            ->expects($this->once())
            ->method('addSuccessMessage')
            ->with(__('You saved the Pet Kind.'))
            ->willReturnSelf();

        $this->dataPersistor
            ->expects($this->once())
            ->method('clear')
            ->with('pets_petkind_form_data_source');

        $this->redirectFactory
            ->expects($this->once())
            ->method('create')
            ->willReturn($this->redirect);

        $this->redirect
            ->expects($this->once())
            ->method('setPath')
            ->with('*/*/')
            ->willReturnSelf();

        $this->assertSame($this->redirect, $this->testSubject->execute());
    }

    /**
     * Test pet kind not data in request for save
     *
     * @return void
     */
    public function testNotDataToSave()
    {
        $this->redirectFactory
            ->expects($this->once())
            ->method('create')
            ->willReturn($this->redirect);

        $this->request
            ->expects($this->once())
            ->method('getPostValue')
            ->willReturn([]);

        $this->redirect
            ->expects($this->once())
            ->method('setPath')
            ->with('*/*/')
            ->willReturnSelf();

        $this->assertSame($this->redirect, $this->testSubject->execute());
    }

    /**
     * Test execute with localized exception
     *
     * @return void
     */
    public function testExecuteWithLocalizedException()
    {
        $id = $this->request->getParam('entity_id');

        $data = [
            'name' => 'Cão',
            'description' => 'Dócil'
        ];

        $this->redirectFactory
            ->expects($this->once())
            ->method('create')
            ->willReturn($this->redirect);

        $this->request
            ->expects($this->once())
            ->method('getPostValue')
            ->willReturn($data);

//        $this->request
//            ->expects($this->once())
//            ->method('getParams')
//            ->willReturn(['entity_id']);

        $this->petKindFactory
            ->expects($this->once())
            ->method('create')
            ->willReturn($this->petKindInterface);

        $this->petKindInterface
            ->expects($this->once())
            ->method('setData')
            ->with($data)
            ->willReturnSelf();

        $this->petKindRepository
            ->expects($this->once())
            ->method('save')
            ->with($this->petKindInterface)
            ->willThrowException($this->localizedException);

        $this->messageManager
            ->expects($this->once())
            ->method('addErrorMessage')
            ->with($this->localizedException->getMessage())
            ->willReturnSelf();

        $this->dataPersistor
            ->expects($this->once())
            ->method('set')
            ->with('pets_petkind_form_data_source', $data)
            ->willReturnSelf();

        $this->redirectFactory
            ->expects($this->once())
            ->method('create')
            ->willReturn($this->redirect);

        $this->redirect
            ->expects($this->once())
            ->method('setPath')
            ->with('*/*/edit', ['entity_id' => $id])
            ->willReturnSelf();

        $this->assertSame($this->redirect, $this->testSubject->execute());
    }

    public function testExecuteWithException()
    {
        $id = $this->request->getParam('entity_id');
        $exception = new \Exception();

        $data = [
            'name' => 'Cão',
            'description' => 'Dócil'
        ];

        $this->redirectFactory
            ->expects($this->once())
            ->method('create')
            ->willReturn($this->redirect);

        $this->request
            ->expects($this->once())
            ->method('getPostValue')
            ->willReturn($data);

//        $this->request
//            ->expects($this->once())
//            ->method('getParams')
//            ->willReturn(['entity_id']);

        $this->petKindFactory
            ->expects($this->once())
            ->method('create')
            ->willReturn($this->petKindInterface);

        $this->petKindInterface
            ->expects($this->once())
            ->method('setData')
            ->with($data)
            ->willReturnSelf();

        $this->petKindRepository
            ->expects($this->once())
            ->method('save')
            ->with($this->petKindInterface)
            ->willThrowException($exception);

        $this->messageManager
            ->expects($this->once())
            ->method('addExceptionMessage')
            ->with($exception, __('Something went wrong while saving the Pet Kind.'))
            ->willReturnSelf();

        $this->dataPersistor
            ->expects($this->once())
            ->method('set')
            ->with('pets_petkind_form_data_source', $data)
            ->willReturnSelf();

        $this->redirectFactory
            ->expects($this->once())
            ->method('create')
            ->willReturn($this->redirect);

        $this->redirect
            ->expects($this->once())
            ->method('setPath')
            ->with('*/*/edit', ['entity_id' => $id])
            ->willReturnSelf();

        $this->assertSame($this->redirect, $this->testSubject->execute());
    }
}
