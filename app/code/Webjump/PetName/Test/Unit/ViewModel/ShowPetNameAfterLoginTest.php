<?php
/**
 * @author      Webjump Develop Team <dev@webjump.com.br>
 * @copyright   2022 Webjump (http://www.webjump.com.br)
 * @license     http://www.webjump.com.br Copyright
 * @link        http://www.webjump.com.br
 */

declare(strict_types=1);

namespace Webjump\PetName\Test\Unit\ViewModel;

use Magento\Customer\Api\Data\CustomerInterface;
use Webjump\PetKind\Api\PetKindRepositoryInterface;
use Webjump\PetKind\Model\Config;
use Magento\Customer\Api\CustomerRepositoryInterface;
use Magento\Customer\Model\Session;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Store\Api\Data\StoreInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\View\Element\Block\ArgumentInterface;
use Magento\Framework\Exception\LocalizedException;
use Webjump\PetName\ViewModel\ShowPetNameAfterLogin;
use Magento\Customer\Api\Data\CustomerExtensionInterface;

class ShowPetNameAfterLoginTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @const ATTRIBUTE_CODE
     */
    const ATTRIBUTE_CODE = 'pet_name';

    /**
     * @var Config
     */
    private Config $config;

    /**
     * @var Session
     */
    private Session $session;

    /**
     * @var StoreManagerInterface
     */
    private StoreManagerInterface $storeManager;

    /**
     * @var CustomerRepositoryInterface
     */
    private CustomerRepositoryInterface $customerRepository;

    /**
     * @var PetKindRepositoryInterface
     */
    private PetKindRepositoryInterface $petKindRepository;

    /**
     * @var StoreInterface
     */
    private StoreInterface $store;

    /**
     * @var CustomerInterface
     */
    private CustomerInterface $customer;

    /**
     * @var CustomerExtensionInterface
     */
    private CustomerExtensionInterface $customerExtension;

    /**
     * @return void
     */
    public function setUp(): void
    {
        $this->session = $this->createMock(Session::class);
        $this->config = $this->createMock(Config::class);
        $this->storeManager = $this->createMock(StoreManagerInterface::class);
        $this->store = $this->createMock(StoreInterface::class);
        $this->customerRepository = $this->createMock(CustomerRepositoryInterface::class);
        $this->petKindRepository = $this->createMock(PetKindRepositoryInterface::class);
        $this->customer = $this->createMock(CustomerInterface::class);
        $this->customerExtension = $this->createMock(CustomerExtensionInterface::class);

        $this->testSubject = new ShowPetNameAfterLogin(
            $this->session,
            $this->config,
            $this->storeManager,
            $this->customerRepository,
            $this->petKindRepository
        );
    }

    /**
     * Test method is logged in
     *
     * @return void
     */
    public function testIsLoggedIn()
    {
        $this->session
            ->expects($this->once())
            ->method('isLoggedIn')
            ->willReturn(true);

        $result = $this->testSubject->isLoggedIn();
        $this->assertIsBool($result);
        $this->assertEquals(true, $result);
    }

    /**
     * Test method is not logged in
     *
     * @return void
     */
    public function testIfNotIsLoggedIn()
    {
        $this->session
            ->expects($this->once())
            ->method('isLoggedIn')
            ->willReturn(false);

        $result = $this->testSubject->isLoggedIn();
        $this->assertIsBool($result);
        $this->assertEquals(false, $result);
    }

    /**
     * Test method is module enable
     *
     * @return void
     * @throws NoSuchEntityException
     */
    public function testIsModuleEnable()
    {
        $this->storeManager
            ->expects($this->once())
            ->method('getStore')
            ->willReturn($this->store);

        $this->store
            ->expects($this->once())
            ->method('getCode')
            ->willReturn('1');

        $this->config
            ->expects($this->once())
            ->method('isEnabled')
            ->with('1')
            ->willReturn(true);

        $result = $this->testSubject->isModuleEnable();
        $this->assertIsBool($result);
        $this->assertEquals(true, $result);
    }

    /**
     * Test method module is not enable
     *
     * @return void
     * @throws NoSuchEntityException
     */
    public function testIfNotIsModuleEnable()
    {
        $this->storeManager
            ->expects($this->once())
            ->method('getStore')
            ->willReturn($this->store);

        $this->store
            ->expects($this->once())
            ->method('getCode')
            ->willReturn('1');

        $this->config
            ->expects($this->once())
            ->method('isEnabled')
            ->with('1')
            ->willReturn(false);

        $result = $this->testSubject->isModuleEnable();
        $this->assertIsBool($result);
        $this->assertEquals(false, $result);
    }

    /**
     * @throws NoSuchEntityException
     * @throws LocalizedException
     */
    public function testGetCustomer()
    {
        $this->session
            ->expects($this->once())
            ->method('getCustomerId')
            ->willReturn(1);

        $this->customerRepository
            ->expects($this->once())
            ->method('getById')
            ->with(1)
            ->willReturn($this->customer);

        $result = $this->testSubject->getCustomer();
        $this->assertInstanceOf(CustomerInterface::class, $result);
        $this->assertEquals($this->customer, $result);
    }

//    /**
//     * @throws NoSuchEntityException
//     * @throws LocalizedException
//     */
//    public function testGetPetNameCustomer()
//    {
//        $this->customer
//            ->expects($this->once())
//            ->method('getExtensionAttributes')
//            ->with(self::ATTRIBUTE_CODE)
//            ->willReturn($this->customerExtension);
//
//        $this->customerExtension
//            ->expects($this->once())
//            ->method('getPetName')
//            ->willReturn('Totó');
//
//        $result = $this->testSubject->getPetNameCustomer();
//        $this->assertIsString($result);
//        $this->assertEquals('Totó', $result);
//    }
}
