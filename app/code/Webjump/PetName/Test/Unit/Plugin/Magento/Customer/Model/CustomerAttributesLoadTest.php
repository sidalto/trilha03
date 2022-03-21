<?php
/**
 * @author      Webjump Develop Team <dev@webjump.com.br>
 * @copyright   2022 Webjump (http://www.webjump.com.br)
 * @license     http://www.webjump.com.br Copyright
 * @link        http://www.webjump.com.br
 */

declare(strict_types=1);

namespace Webjump\PetName\Test\Unit\Plugin\Magento\Customer\Model;

use Magento\Customer\Api\Data\CustomerExtensionFactory;
use Magento\Customer\Api\Data\CustomerSearchResultsInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Api\AttributeInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Customer\Api\Data\CustomerInterface;
use Magento\Customer\Api\CustomerRepositoryInterface;
use Magento\Customer\Api\Data\CustomerExtensionInterface;
use Webjump\PetName\Plugin\Magento\Customer\CustomerAttributesLoad;
use Webjump\PetName\Plugin\Magento\Customer\Model\ResourceModel\CustomerRepositoryPlugin;

class CustomerAttributesLoadTest extends \PHPUnit\Framework\TestCase
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
     * @var CustomerExtensionFactory
     */
    private CustomerExtensionFactory $customerExtensionFactory;

    /**
     * @return void
     */
    public function setUp(): void
    {
        $this->customer = $this->createMock(CustomerInterface::class);
        $this->customerRepository = $this->createMock(CustomerRepositoryInterface::class);
        $this->customerExtensionFactory = $this->createMock(CustomerExtensionFactory::class);
        $this->request = $this->createMock(RequestInterface::class);
        $this->attributeInterface = $this->createMock(AttributeInterface::class);
        $this->customerExtension = $this->createMock(CustomerExtensionInterface::class);
        $this->customerRepositoryPlugin = $this->createMock(CustomerRepositoryPlugin::class);
        $this->searchResults = $this->createMock(CustomerSearchResultsInterface::class);
        $this->searchCriteria = $this->createMock(SearchCriteriaInterface::class);

        $this->testSubject = new CustomerAttributesLoad($this->customerExtensionFactory);
    }

    /**
     * Test after get extension attributes
     *
     * @return void
     */
    public function testAfterGetExtensionAttributes()
    {
        $result = $this->testSubject->afterGetExtensionAttributes($this->customer, $this->customerExtension);
        $this->assertInstanceOf(CustomerExtensionInterface::class, $result);
        $this->assertEquals($this->customerExtension, $result);
    }

    /**
     * Test after get extension attributes
     *
     * @return void
     */
    public function testIfNotExtensionAttributes()
    {
        $this->customerExtensionFactory
            ->expects($this->once())
            ->method('create')
            ->willReturn($this->customerExtension);

        $result = $this->testSubject->afterGetExtensionAttributes($this->customer, null);
        $this->assertInstanceOf(CustomerExtensionInterface::class, $result);
        $this->assertEquals($this->customerExtension, $result);
    }
}
