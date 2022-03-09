<?php
/**
 * @author      Webjump Develop Team <dev@webjump.com.br>
 * @copyright   2022 Webjump (http://www.webjump.com.br)
 * @license     http://www.webjump.com.br Copyright
 * @link        http://www.webjump.com.br
 */

declare(strict_types=1);

namespace Webjump\PetKind\ViewModel;

use Magento\Customer\Model\CustomerFactory;
use Webjump\PetKind\Model\Config;
use Magento\Customer\Model\SessionFactory;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\View\Element\Block\ArgumentInterface;
use Magento\Store\Model\StoreManagerInterface;

class ShowPetKindAfterLogin implements ArgumentInterface
{
    /**
     * @var Config
     */
    private Config $config;

    /**
     * @var SessionFactory
     */
    private SessionFactory $sessionFactory;

    /**
     * @var StoreManagerInterface
     */
    private StoreManagerInterface $storeManager;

    /**
     * @param SessionFactory $sessionFactory
     * @param Config $config
     * @param StoreManagerInterface $storeManager
     */
    public function __construct(
        SessionFactory $sessionFactory,
        Config $config,
        StoreManagerInterface $storeManager
    ) {
        $this->sessionFactory = $sessionFactory;
        $this->config = $config;
        $this->storeManager = $storeManager;
    }

    /**
     * Method to check if customer is logged in
     *
     * @return bool
     */
    public function isLoggedIn(): bool
    {
        return $this->sessionFactory->create()->isLoggedIn();
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
     */
    public function getPetKindCustomer(): string
    {
        $customer = $this->sessionFactory->create()->getCustomer();

        var_dump($customer->getExtensionAttributes()->getPetName());
        die();
//        return $customer->getExtensionAttribute('pet_name')->getValue();
    }
}
