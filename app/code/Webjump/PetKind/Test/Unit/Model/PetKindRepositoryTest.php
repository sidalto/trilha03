<?php

namespace Webjump\PetKind\Test\Unit\Model;

use PHPUnit\Framework\TestCase;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Api\SearchResultsInterface;
use Magento\Framework\Api\SearchResultsFactory;
use Webjump\PetKind\Api\Data\PetKindInterface;
use Webjump\PetKind\Api\Data\PetKindInterfaceFactory;
use Webjump\PetKind\Api\PetKindRepositoryInterface;
use Webjump\PetKind\Model\Data\PetKind;
use Webjump\PetKind\Model\PetKindRepository;
use Webjump\PetKind\Model\ResourceModel\PetKind as PetKindResourceModel;
use Webjump\PetKind\Model\ResourceModel\PetKind\Collection;
use Webjump\PetKind\Model\ResourceModel\PetKind\CollectionFactory;

class PetKindRepositoryTest extends TestCase
{
    /**
     * @var PetKindResourceModel
     */
    private PetKindResourceModel $petKindResourceModel;

    /**
     * @var PetKindInterfaceFactory
     */
    private PetKindInterfaceFactory $petKindInterfaceFactory;

    /**
     * @var CollectionFactory
     */
    private CollectionFactory $collectionFactory;

    /**
     * @var Collection
     */
    private Collection $collection;

    /**
     * @var CollectionProcessorInterface
     */
    private CollectionProcessorInterface $collectionProcessor;

    /**
     * @var SearchResultsFactory
     */
    private SearchResultsFactory $searchResultsFactory;

    /**
     * @var SearchCriteriaBuilder
     */
    private SearchCriteriaBuilder $searchCriteriaBuilder;

    /**
     * @var PetKindInterface
     */
    private PetKindInterface $petKindInterface;

    /**
     * @return void
     */
    public function setUp(): void
    {
        $this->petKindInterface = $this->createMock(PetKindInterface::class);
        $this->petKindInterfaceFactory = $this->createMock(PetKindInterfaceFactory::class);
        $this->petKind = $this->createMock(PetKind::class);
        $this->petKindResourceModel = $this->createMock(PetKindResourceModel::class);
        $this->petKindRepositoryInterface = $this->createMock(PetKindRepositoryInterface::class);
        $this->collectionFactory = $this->createMock(CollectionFactory::class);
        $this->collection = $this->createMock(Collection::class);
        $this->collectionProcessor = $this->createMock(CollectionProcessorInterface::class);
        $this->searchResultsFactory = $this->createMock(SearchResultsFactory::class);
        $this->searchResultsInterface = $this->createMock(SearchResultsInterface::class);
        $this->searchCriteriaBuilder = $this->createMock(SearchCriteriaBuilder::class);
        $this->searchCriteriaInterface = $this->createMock(SearchCriteriaInterface::class);

        $this->testSubject = new PetKindRepository(
            $this->petKindInterfaceFactory,
            $this->collectionFactory,
            $this->searchResultsFactory,
            $this->petKindResourceModel,
            $this->collectionProcessor,
            $this->searchCriteriaBuilder
        );
    }

    /**
     * Test save method
     *
     * @throws CouldNotSaveException
     */
    public function testSave()
    {
        $id = 1;

        $this->petKind
            ->expects($this->once())
            ->method('getEntityId')
            ->willReturn($id);

        $this->petKindResourceModel
            ->expects($this->once())
            ->method('save')
            ->with($this->petKind)
            ->willReturnSelf();

        $entity_id = $this->testSubject->save($this->petKind);
        $this->assertEquals($id, $entity_id);
    }

    /**
     * Test save method should throw exception
     *
     * @throws CouldNotSaveException
     */
    public function testSaveShouldThrowException()
    {
        $exception = new CouldNotSaveException(__('Could not save pet kind'));

        $this->petKindResourceModel
            ->expects($this->once())
            ->method('save')
            ->with($this->petKind)
            ->willThrowException($exception);

        $this->expectException(CouldNotSaveException::class);
        $this->testSubject->save($this->petKind);
    }

    /**
     * Test get by id method
     *
     * @throws NoSuchEntityException
     */
    public function testGetById()
    {
        $id = 1;

        $this->petKindInterfaceFactory
            ->expects($this->once())
            ->method('create')
            ->willReturn($this->petKind);

        $this->petKindResourceModel
            ->expects($this->once())
            ->method('load')
            ->with($this->petKind, $id)
            ->willReturn($this->petKind);

        $result = $this->testSubject->getById($id);
        $this->assertEquals($this->petKind, $result);
        $this->assertInstanceOf(PetKindInterface::class, $result);
    }

    /**
     * Test get method should throw exception
     *
     * @throws NoSuchEntityException
     */
    public function testGetByIdShouldThrowException()
    {
        $id = 1;

        $exception = new NoSuchEntityException(__('This pet kind don\'t exists'));

        $this->petKindInterfaceFactory
            ->expects($this->once())
            ->method('create')
            ->willReturn($this->petKind);

        $this->petKindResourceModel
            ->expects($this->once())
            ->method('load')
            ->with($this->petKind, $id)
            ->willThrowException($exception);

        $this->expectException(NoSuchEntityException::class);
        $this->testSubject->getById($id);
    }

    /**
     * Test Get List method
     *
     * @return void
     */
    public function testGetList()
    {
        $this->collectionFactory
            ->expects($this->once())
            ->method('create')
            ->willReturn($this->collection);

        $this->searchResultsFactory
            ->expects($this->once())
            ->method('create')
            ->willReturn($this->searchResultsInterface);

        $this->collectionProcessor
            ->expects($this->once())
            ->method('process')
            ->with($this->searchCriteriaInterface, $this->collection)
            ->willReturnSelf();

        $this->collection
            ->expects($this->once())
            ->method('getData')
            ->willReturn([]);

        $this->searchResultsInterface
            ->expects($this->once())
            ->method('setItems')
            ->with([])
            ->willReturnSelf();

        $this->collection
            ->expects($this->once())
            ->method('getSize')
            ->willReturn(1);

        $this->searchResultsInterface
            ->expects($this->once())
            ->method('setTotalCount')
            ->with(1)
            ->willReturnSelf();

        $this->searchResultsInterface
            ->expects($this->once())
            ->method('setSearchCriteria')
            ->with($this->searchCriteriaInterface)
            ->willReturnSelf();

        $result = $this->testSubject->getList($this->searchCriteriaInterface);
        $this->assertEquals($this->searchResultsInterface, $result);
        $this->assertInstanceOf(SearchResultsInterface::class, $result);
    }

    /**
     * Test Get List method if SearchCriteria param is null
     *
     * @return void
     */
    public function testGetListIfSearchCriteriaIsNull()
    {
        $this->collectionFactory
            ->expects($this->once())
            ->method('create')
            ->willReturn($this->collection);

        $this->searchResultsFactory
            ->expects($this->once())
            ->method('create')
            ->willReturn($this->searchResultsInterface);

        $this->searchCriteriaBuilder
            ->expects($this->once())
            ->method('create')
            ->willReturn($this->searchCriteriaInterface);

        $this->collection
            ->expects($this->once())
            ->method('getData')
            ->willReturn([]);

        $this->searchResultsInterface
            ->expects($this->once())
            ->method('setItems')
            ->with([])
            ->willReturnSelf();

        $this->collection
            ->expects($this->once())
            ->method('getSize')
            ->willReturn(1);

        $this->searchResultsInterface
            ->expects($this->once())
            ->method('setTotalCount')
            ->with(1)
            ->willReturnSelf();

        $this->searchResultsInterface
            ->expects($this->once())
            ->method('setSearchCriteria')
            ->with($this->searchCriteriaInterface)
            ->willReturnSelf();

        $result = $this->testSubject->getList();
        $this->assertEquals($this->searchResultsInterface, $result);
        $this->assertInstanceOf(SearchResultsInterface::class, $result);
    }

    /**
     * Test delete by id method
     *
     * @throws CouldNotDeleteException
     */
    public function testDeleteById()
    {
        $id = 1;

        $this->petKindInterfaceFactory
            ->expects($this->once())
            ->method('create')
            ->willReturn($this->petKind);

        $this->petKindResourceModel
            ->expects($this->once())
            ->method('load')
            ->with($this->petKind, $id)
            ->willReturn($this->petKind);

        $this->petKindResourceModel
            ->expects($this->once())
            ->method('delete')
            ->with($this->petKind)
            ->willReturnSelf();

        $result = $this->testSubject->deleteById($id);
        $this->assertEquals(true, $result);
    }

    /**
     * Test delete by id should throw exception
     *
     * @throws CouldNotDeleteException
     */
    public function testDeleteByIdShouldThrowException()
    {
        $id = 1;

        $exception = new CouldNotSaveException(__('Could not delete the pet kind'));

        $this->petKindInterfaceFactory
            ->expects($this->once())
            ->method('create')
            ->willReturn($this->petKind);

        $this->petKindResourceModel
            ->expects($this->once())
            ->method('load')
            ->with($this->petKind, $id)
            ->willReturn($this->petKind);

        $this->petKindResourceModel
            ->expects($this->once())
            ->method('delete')
            ->with($this->petKind)
            ->willThrowException($exception);

        $this->expectException(CouldNotDeleteException::class);
        $this->testSubject->deleteById($id);
    }

}
