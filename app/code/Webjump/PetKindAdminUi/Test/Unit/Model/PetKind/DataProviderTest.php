<?php
/**
 * @author      Webjump Develop Team <dev@webjump.com.br>
 * @copyright   2022 Webjump (http://www.webjump.com.br)
 * @license     http://www.webjump.com.br Copyright
 * @link        http://www.webjump.com.br
 */

declare(strict_types=1);

namespace Webjump\PetKindAdminUi\Test\Unit\Model\PetKind;

use PHPUnit\Framework\TestCase;
use Magento\Framework\App\Request\DataPersistorInterface;
use Webjump\PetKind\Api\Data\PetKindInterface;
use Webjump\PetKind\Model\ResourceModel\PetKind\Collection;
use Webjump\PetKind\Model\ResourceModel\PetKind\CollectionFactory;
use Webjump\PetKindAdminUi\Model\PetKind\DataProvider;
use Magento\Framework\DataObject;

class DataProviderTest extends TestCase
{
    /**
     * @var array
     */
    protected array $loadedData;

    /**
     * @var Collection
     */
    protected Collection $collection;

    /**
     * @var DataPersistorInterface
     */
    protected DataPersistorInterface $dataPersistor;

    /**
     * @var CollectionFactory
     */
    private CollectionFactory $collectionFactory;

    private string $name;

    private string $primaryFieldName;

    private string $requestFieldName;

    private array $meta = [];

    private array $data = [];

    /**
     * @var PetKindInterface
     */
    private PetKindInterface $petKindInterface;

    /**
     * @var DataProvider
     */
    private DataProvider $dataProvider;

    /**
     * @var DataObject
     */
    private DataObject $dataObject;

    /**
     * @return void
     */
    public function setUp(): void
    {
        $this->collection = $this->createMock(Collection::class);
        $this->collectionFactory = $this->createMock(CollectionFactory::class);
        $this->dataPersistor = $this->createMock(DataPersistorInterface::class);
        $this->dataObject = $this->getMockBuilder(DataObject::class)
            ->disableOriginalConstructor()
            ->addMethods(['getId'])
            ->onlyMethods(['getData'])
            ->getMockForAbstractClass();
        $this->dataProvider = $this->createMock(DataProvider::class);

        $this->testSubject = new DataProvider(
            $this->name= '',
            $this->primaryFieldName = '',
            $this->requestFieldName = '',
            $this->collectionFactory,
            $this->dataPersistor,
            $meta = [],
            $data = []
        );
    }

    public function testGetData()
    {
        $data = [
            'entity_id' => 1,
            'name' => 'Cão',
            'description' => 'Dócil',
            'created_at' => '2022-03-13 18:00:00'
        ];

        $this->loadedData = [
            1 => [
                'entity_id' => 1,
                'name' => 'Cão',
                'description' => 'Dócil',
                'created_at' => '2022-03-13 18:00:00'
            ]
        ];

        $this->collectionFactory
            ->expects($this->once())
            ->method('create')
            ->willReturn($this->collection);

        $this->collection
            ->expects($this->once())
            ->method('getItems')
            ->willReturn([$this->dataObject]);

        $this->dataObject
            ->expects($this->any())
            ->method('getData')
            ->willReturn([$data]);

        $this->dataObject
            ->expects($this->once())
            ->method('getId')
            ->willReturn(1);

        $this->dataPersistor
            ->expects($this->once())
            ->method('get')
            ->with('pets_petkind')
            ->willReturn($data);

//        $this->collection
//            ->expects($this->once())
//            ->method('getNewEmptyItem')
//            ->willReturn($this->petKindInterface);
//
//        $this->petKindInterface
//            ->expects($this->once())
//            ->method('setData')
//            ->with($data)
//            ->willReturnSelf();

        $result = $this->testSubject->getData();

        $this->assertIsArray($data);
        $this->assertEquals($this->loadedData, $result);

    }
}
