<?php
/**
 * @author      Webjump Develop Team <dev@webjump.com.br>
 * @copyright   2022 Webjump (http://www.webjump.com.br)
 * @license     http://www.webjump.com.br Copyright
 * @link        http://www.webjump.com.br
 */

declare(strict_types=1);

namespace Webjump\PetKind\Test\Unit\Model\Data;

use Magento\Framework\Model\Context;
use Magento\Framework\DataObject;
use Magento\Framework\Registry;
use PHPUnit\Framework\TestCase;
use Webjump\PetKind\Model\Data\PetKind;
use Webjump\PetKind\Model\ResourceModel\PetKind as ResourceModel;

class PetKindTest extends TestCase
{
    /**
     * Set up method
     *
     * @return void
     */
    public function setUp(): void
    {
        $this->resourceModel = $this->createMock(ResourceModel::class);
        $this->context = $this->createMock(Context::class);
        $this->registry = $this->createMock(Registry::class);
        $this->dataObject = $this->createMock(DataObject::class);

        $this->testSubject = new PetKind($this->context, $this->registry, $this->resourceModel);
    }

    /**
     * Test init method
     *
     * @return void
     */
    public function testInit()
    {
        $this->testSubject->setEntityId(1);

        $this->assertEquals(
            ['entity_id' => 1],
            $this->testSubject->getData()
        );
    }

    /**
     * Test get entity id method
     *
     * @return void
     */
    public function testGetEntityId()
    {
        $this->testSubject->setEntityId(1);

        $this->assertEquals(1, $this->testSubject->getEntityId());
    }

    /**
     * Test get pet name method
     *
     * @return void
     */
    public function testGetName()
    {
        $this->testSubject->setName('Cão');
        $this->assertEquals('Cão', $this->testSubject->getName());
    }

    /**
     * Test set pet name method
     *
     * @return void
     */
    public function testSetName()
    {
        $this->testSubject->setName('Cachorro');
        $this->assertEquals('Cachorro', $this->testSubject->getName());
    }

    /**
     * Test get pet description id method
     *
     * @return void
     */
    public function testGetDescription()
    {
        $this->testSubject->setDescription('Peludo');
        $this->assertEquals('Peludo', $this->testSubject->getDescription());
    }

    /**
     * Test set pet description id method
     *
     * @return void
     */
    public function testSetDescription()
    {
        $this->testSubject->setDescription('Peludo');
        $this->assertEquals('Peludo', $this->testSubject->getDescription());
    }
}
