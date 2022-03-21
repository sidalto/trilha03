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
use Magento\Framework\Message\ManagerInterface as MessageManagerInterface;
use Magento\Framework\View\Result\PageFactory;
use PHPUnit\Framework\TestCase;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Controller\Result\RedirectFactory;
use Magento\Framework\Controller\Result\Redirect;
use Magento\Framework\Controller\ResultInterface;
use Magento\Backend\App\Action\Context;
use Webjump\PetKind\Api\Data\PetKindInterface;
use Webjump\PetKind\Api\PetKindRepositoryInterface;
use Webjump\PetKind\Model\Data\PetKindFactory;
use Webjump\PetKindAdminUi\Controller\Adminhtml\PetKind\Delete;

class DeleteTest extends TestCase
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
     * @var PetKindInterface
     */
    private PetKindInterface $petKindInterface;

    /**
     * @var PageFactory
     */
    private PageFactory $resultPageFactory;

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
        $this->resultForwardFactory = $this->createMock(ForwardFactory::class);
        $this->resultPageFactory = $this->createMock(PageFactory::class);
        $this->messageManager = $this->createMock(MessageManagerInterface::class);
        $this->request = $this->createMock(RequestInterface::class);
        $this->dataPersistor = $this->createMock(DataPersistorInterface::class);

        $this->testSubject = new Delete(
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

        $this->redirectFactory
            ->expects($this->once())
            ->method('create')
            ->willReturn($this->redirect);

        $this->request
            ->expects($this->once())
            ->method('getParam')
            ->with('entity_id')
            ->willReturn($id);

        $this->petKindRepository
            ->expects($this->once())
            ->method('getById')
            ->with($id)
            ->willReturn($this->petKindInterface);

        $this->petKindInterface
            ->expects($this->once())
            ->method('getEntityId')
            ->willReturn($id);

        $this->petKindRepository
            ->expects($this->once())
            ->method('deleteById')
            ->with($id)
            ->willReturn(true);

        $this->messageManager
            ->expects($this->once())
            ->method('addSuccessMessage')
            ->with(__('You deleted the Pet Kind.'))
            ->willReturnSelf();

        $this->redirect
            ->expects($this->once())
            ->method('setPath')
            ->with('*/*/')
            ->willReturnSelf();

        $this->assertSame($this->redirect, $this->testSubject->execute());
    }

    public function testPetKindIsNotFound()
    {
        $this->redirectFactory
            ->expects($this->once())
            ->method('create')
            ->willReturn($this->redirect);

        $this->messageManager
            ->expects($this->once())
            ->method('addErrorMessage')
            ->with(__('We can\'t find a Pet Kind to delete.'))
            ->willReturnSelf();

        $this->redirect
            ->expects($this->once())
            ->method('setPath')
            ->with('*/*/')
            ->willReturnSelf();

        $this->assertSame($this->redirect, $this->testSubject->execute());
    }

    public function testExecuteWithLocalizedException()
    {
        $id = 1;
        $exception = new \Exception();

        $this->redirectFactory
            ->expects($this->once())
            ->method('create')
            ->willReturn($this->redirect);

        $this->request
            ->expects($this->once())
            ->method('getParam')
            ->with('entity_id')
            ->willReturn($id);

        $this->petKindRepository
            ->expects($this->once())
            ->method('getById')
            ->with($id)
            ->willReturn($this->petKindInterface);

        $this->petKindInterface
            ->expects($this->once())
            ->method('getEntityId')
            ->willReturn($id);

        $this->petKindRepository
            ->expects($this->once())
            ->method('deleteById')
            ->with($id)
            ->willThrowException($exception);


        $this->messageManager
            ->expects($this->once())
            ->method('addErrorMessage')
            ->with($exception->getMessage())
            ->willReturnSelf();

        $this->redirect
            ->expects($this->once())
            ->method('setPath')
            ->with('*/*/edit', ['entity_id' => $id])
            ->willReturnSelf();

        $this->assertSame($this->redirect, $this->testSubject->execute());
    }
}
