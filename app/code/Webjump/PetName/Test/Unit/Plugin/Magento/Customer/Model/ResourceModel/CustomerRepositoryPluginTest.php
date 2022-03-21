<?php
/**
 * @author      Webjump Develop Team <dev@webjump.com.br>
 * @copyright   2022 Webjump (http://www.webjump.com.br)
 * @license     http://www.webjump.com.br Copyright
 * @link        http://www.webjump.com.br
 */

declare(strict_types=1);

namespace Webjump\PetName\Test\Unit\Plugin\Magento\Customer\Model\ResourceModel;

use Magento\Customer\Api\Data\CustomerSearchResultsInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use  Magento\Framework\Api\AttributeInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Customer\Api\Data\CustomerInterface;
use Magento\Customer\Api\CustomerRepositoryInterface;
use Magento\Customer\Api\Data\CustomerExtensionInterface;
use Webjump\PetName\Plugin\Magento\Customer\Model\ResourceModel\CustomerRepositoryPlugin;

class CustomerRepositoryPluginTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @const ATTRIBUTE_CODE
     */
    const ATTRIBUTE_CODE = 'pet_name';

    /**
     * @var CustomerInterface
     */
    private CustomerInterface $customer;

    /**
     * @var CustomerRepositoryInterface
     */
    private CustomerRepositoryInterface $customerRepository;

    /**
     * @var CustomerSearchResultsInterface
     */
    private CustomerSearchResultsInterface $searchResults;

    /**
     * @var SearchCriteriaInterface
     */
    private SearchCriteriaInterface $searchCriteria;

    /**
     * @var RequestInterface
     */
    private RequestInterface $request;

    /**
     * @var AttributeInterface
     */
    private AttributeInterface $attributeInterface;

    /**
     * @var CustomerExtensionInterface
     */
    private CustomerExtensionInterface $customerExtension;

    /**
     * @return void
     */
    public function setUp(): void
    {
        $this->customer = $this->createMock(CustomerInterface::class);
        $this->customerRepository = $this->createMock(CustomerRepositoryInterface::class);
        $this->request = $this->createMock(RequestInterface::class);
        $this->attributeInterface = $this->createMock(AttributeInterface::class);
        $this->customerExtension = $this->createMock(CustomerExtensionInterface::class);
        $this->customerRepositoryPlugin = $this->createMock(CustomerRepositoryPlugin::class);
        $this->searchResults = $this->createMock(CustomerSearchResultsInterface::class);
        $this->searchCriteria = $this->createMock(SearchCriteriaInterface::class);

        $this->testSubject = new CustomerRepositoryPlugin($this->customer, $this->customerRepository, $this->request);
    }

    /**
     * Test set pet name attribute name
     *
     * @return void
     */
    public function testSetPetNameAttributeName()
    {
        $this->customer
            ->expects($this->once())
            ->method('getCustomAttribute')
            ->with(self::ATTRIBUTE_CODE)
            ->willReturn($this->attributeInterface);

        $this->customer
            ->expects($this->once())
            ->method('getExtensionAttributes')
            ->willReturn($this->customerExtension);

        $this->attributeInterface
            ->expects($this->once())
            ->method('getValue')
            ->willReturn('Miau');

        $this->customerExtension
            ->expects($this->once())
            ->method('setPetName')
            ->with('Miau')
            ->willReturnSelf();

        $this->customer
            ->expects($this->once())
            ->method('setExtensionAttributes')
            ->with($this->customerExtension)
            ->willReturnSelf();

        $result = $this->testSubject->setPetNameAttributeName($this->customer);
        $this->assertInstanceOf(CustomerInterface::class, $result);
        $this->assertEquals($this->customer, $result);
    }

    /**
     * Test if not have a custom attribute
     *
     * @return void
     */
    public function testIfNotHaveCustomAttribute()
    {
        $this->customer
            ->expects($this->once())
            ->method('getCustomAttribute')
            ->with(self::ATTRIBUTE_CODE)
            ->willReturn(null);

        $result = $this->testSubject->setPetNameAttributeName($this->customer);
        $this->assertInstanceOf(CustomerInterface::class, $result);
        $this->assertEquals($this->customer, $result);
    }

    /**
     * Test after get method of the plugin
     *
     * @return void
     */
    public function testAfterGet()
    {
        $this->customer = $this->testSubject->setPetNameAttributeName($this->customer);
        $result = $this->testSubject->afterGet($this->customerRepository, $this->customer);
        $this->assertInstanceOf(CustomerInterface::class, $result);
        $this->assertEquals($this->customer, $result);
    }

    /**
     * Test after get by id method of the plugin
     *
     * @return void
     */
    public function testAfterGetById()
    {
        $this->customer = $this->testSubject->setPetNameAttributeName($this->customer);
        $result = $this->testSubject->afterGetById($this->customerRepository,$this->customer, 1);
        $this->assertInstanceOf(CustomerInterface::class, $result);
        $this->assertEquals($this->customer, $result);
    }

    /**
     * Test after get list method of the plugin
     *
     * @return void
     */
    public function testAfterGetList()
    {
        $customers = [
            $this->customer
        ];

        $this->searchResults
            ->expects($this->once())
            ->method('getItems')
            ->willReturn($customers);

        $this->customer = $this->testSubject->setPetNameAttributeName($this->customer);

        $this->searchResults
            ->expects($this->once())
            ->method('setItems')
            ->with($customers)
            ->willReturnSelf();

        $result = $this->testSubject->afterGetList(
            $this->customerRepository,
            $this->searchResults,
            $this->searchCriteria
        );

        $this->assertInstanceOf(CustomerSearchResultsInterface::class, $result);
        $this->assertEquals($this->searchResults, $result);
    }
}
