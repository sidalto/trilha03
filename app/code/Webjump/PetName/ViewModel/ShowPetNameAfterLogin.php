<?php
/**
 * @author      Webjump Develop Team <dev@webjump.com.br>
 * @copyright   2022 Webjump (http://www.webjump.com.br)
 * @license     http://www.webjump.com.br Copyright
 * @link        http://www.webjump.com.br
 */

declare(strict_types=1);

namespace Webjump\PetName\ViewModel;

use Magento\Framework\Exception\LocalizedException;
use Webjump\PetKind\Model\Config;
use Magento\Customer\Api\CustomerRepositoryInterface;
use Magento\Customer\Api\Data\CustomerExtensionInterface;
use Magento\Customer\Model\Session;
use Magento\Customer\Model\SessionFactory;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\View\Element\Block\ArgumentInterface;
use Magento\Store\Model\StoreManagerInterface;

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
     * @param Session $session
     * @param Config $config
     * @param StoreManagerInterface $storeManager
     * @param CustomerRepositoryInterface $customerRepository
     */
    public function __construct(
        Session $session,
        Config $config,
        StoreManagerInterface $storeManager,
        CustomerRepositoryInterface $customerRepository
    ) {
        $this->session = $session;
        $this->config = $config;
        $this->storeManager = $storeManager;
        $this->customerRepository = $customerRepository;
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
     * @return string
     * @throws NoSuchEntityException
     * @throws LocalizedException
     */
    public function getPetNameCustomer(): string
    {
        $customerId = $this->session->getCustomer()->getEntityId();
        $customer = $this->customerRepository->getById($customerId);

        return $customer
            ->getExtensionAttributes()
            ->getPetName()
            ->getName();
    }
}
