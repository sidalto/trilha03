<?php
/**
 * @author      Webjump Develop Team <dev@webjump.com.br>
 * @copyright   2022 Webjump (http://www.webjump.com.br)
 * @license     http://www.webjump.com.br Copyright
 * @link        http://www.webjump.com.br
 */

declare(strict_types=1);

namespace Webjump\PetKind\Test\Unit\Model\Config\Source;

use PHPUnit\Framework\TestCase;
use Webjump\PetKind\Api\Data\PetKindInterface;
use Webjump\PetKind\Model\Config\Source\SelectPetKind;
use Webjump\PetKind\Model\ResourceModel\PetKind\Collection;
use Webjump\PetKind\Model\ResourceModel\PetKind\CollectionFactory;

class SelectPetKindTest extends TestCase
{
    /**
     * @var CollectionFactory
     */
    private CollectionFactory $collectionFactory;

    /**
     * @var Collection
     */
    private Collection $collection;

    /**
     * @var PetKindInterface
     */
    private PetKindInterface $petKind;

    /**
     * @return void
     */
    public function setUp(): void
    {
        $this->collectionFactory = $this->createMock(CollectionFactory::class);
        $this->collection = $this->createMock(Collection::class);
        $this->petKind = $this->createMock(PetKindInterface::class);

        $this->testSubject = new SelectPetKind($this->collectionFactory);
    }

    /**
     * Test toOptionsArray method
     *
     * @return void
     */
    public function testToOptionArray()
    {
        $expected[] = [
            'label' => __('Cão'),
            'value' => 1
        ];

        $this->collectionFactory
            ->expects($this->once())
            ->method('create')
            ->willReturn($this->collection);

        $this->collection
            ->expects($this->once())
            ->method('load')
            ->willReturnSelf();

        $this->collection
            ->expects($this->once())
            ->method('getSize')
            ->willReturn(1);

        $this->collection
            ->expects($this->once())
            ->method('getItems')
            ->willReturn([$this->petKind]);

        $this->petKind
            ->expects($this->once())
            ->method('getName')
            ->willReturn('Cão');

        $this->petKind
            ->expects($this->once())
            ->method('getEntityId')
            ->willReturn(1);

        $result = $this->testSubject->toOptionArray();

        $this->assertIsArray($result);
        $this->assertEquals($expected, $result);
    }

    public function testGetAllOptions()
    {
        $expected[] = [
            'label' => __('Cão'),
            'value' => 1
        ];

        $this->testToOptionArray();
        $result = $this->testSubject->getAllOptions();

        $this->assertIsArray($result);
        $this->assertEquals($result, $expected);
    }
}
