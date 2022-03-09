<?php
/**
 * @author      Webjump Develop Team <dev@webjump.com.br>
 * @copyright   2022 Webjump (http://www.webjump.com.br)
 * @license     http://www.webjump.com.br Copyright
 * @link        http://www.webjump.com.br
 */

declare(strict_types=1);

namespace Webjump\PetKind\Model;

use Webjump\PetKind\Api\ConfigInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;

class Config implements ConfigInterface
{
    /**
     * @var ScopeConfigInterface
     */
    private ScopeConfigInterface $scopeConfig;

    /**
     * @var ConfigInterface
     */
    private ConfigInterface $config;

    /**
     * Config constructor
     *
     * @param ScopeConfigInterface $scopeConfig
     */
    public function __construct(ScopeConfigInterface $scopeConfig)
    {
        $this->scopeConfig = $scopeConfig;
    }

    /**
     *  This method will verify if this pet kind is enabled
     *
     * @param string|null $scopeCode
     * @return bool
     */
    public function isEnabled(?string $scopeCode): bool
    {
        if (empty($scopeCode)) {
            return $this->scopeConfig->isSetFlag(self::PET_KIND_PATH);
        }

        return $this->scopeConfig->isSetFlag(
            self::PET_KIND_PATH,
            ScopeInterface::SCOPE_STORE,
            $scopeCode
        );
    }
}
