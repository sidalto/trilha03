<?php
/**
 * @author      Webjump Develop Team <dev@webjump.com.br>
 * @copyright   2022 Webjump (http://www.webjump.com.br)
 * @license     http://www.webjump.com.br Copyright
 * @link        http://www.webjump.com.br
 */

declare(strict_types=1);

namespace Webjump\PetName\ViewModel;

use Magento\Customer\Api\Data\CustomerInterface;
use Webjump\PetKind\Api\PetKindRepositoryInterface;
use Webjump\PetKind\Model\Config;
use Magento\Customer\Api\CustomerRepositoryInterface;
use Magento\Customer\Model\Session;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\View\Element\Block\ArgumentInterface;
use Magento\Framework\Exception\LocalizedException;

class ShowPetNameAfterLogin implements ArgumentInterface
{
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
     * Constructor to ShowPetNameAfterLogin class
     *
     * @param Session $session
     * @param Config $config
     * @param StoreManagerInterface $storeManager
     * @param CustomerRepositoryInterface $customerRepository
     * @param PetKindRepositoryInterface $petKindRepository
     */
    public function __construct(
        Session $session,
        Config $config,
        StoreManagerInterface $storeManager,
        CustomerRepositoryInterface $customerRepository,
        PetKindRepositoryInterface $petKindRepository
    ) {
        $this->session = $session;
        $this->config = $config;
        $this->storeManager = $storeManager;
        $this->customerRepository = $customerRepository;
        $this->petKindRepository = $petKindRepository;
    }

    /**
     * Method to check if customer is logged in
     *
     * @return bool
     */
    public function isLoggedIn(): bool
    {
        return $this->session->isLoggedIn();
    }

    /**
     * Method to return module status
     *
     * @return bool
     * @throws NoSuchEntityException
     */
    public function isModuleEnable(): bool
    {
        $storeCode = $this->storeManager->getStore()->getCode();

        return $this->config->isEnabled($storeCode);
    }

    /**
     * Method to return current customer in session
     *
     * @return CustomerInterface|null
     * @throws LocalizedException
     * @throws NoSuchEntityException
     */
    public function getCustomer(): ?CustomerInterface
    {
        $customerId = $this->session->getCustomerId();

        return $this->customerRepository->getById($customerId);
    }

    /**
     * Method to return the pet name of the customer
     *
     * @return string|null
     * @throws NoSuchEntityException
     * @throws LocalizedException
     */
    public function getPetNameCustomer(): ?string
    {
        return $this
            ->getCustomer()
            ->getExtensionAttributes()
            ->getPetName();
    }

    /**
     * Method to return the pet kind of the customer
     *
     * @return string|null
     * @throws LocalizedException
     * @throws NoSuchEntityException
     */
    public function getPetKindCustomer(): ?string
    {
        $petKindId = $this
            ->getCustomer()
            ->getCustomAttribute('pet_kind')
            ->getValue();

        return $this->petKindRepository
            ->getById((int)$petKindId)
            ->getName();
    }
}
