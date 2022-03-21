<?php
/**
 * @author      Webjump Develop Team <dev@webjump.com.br>
 * @copyright   2022 Webjump (http://www.webjump.com.br)
 * @license     http://www.webjump.com.br Copyright
 * @link        http://www.webjump.com.br
 */

declare(strict_types=1);

namespace Webjump\PetKind\Test\Unit\Model;

use PHPUnit\Framework\TestCase;
use Webjump\PetKind\Api\ConfigInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;
use Webjump\PetKind\Model\Config;

class ConfigTest extends TestCase
{
    /**
     * @var ConfigInterface
     */
    private ConfigInterface $config;

    /**
     * @var ScopeConfigInterface
     */
    private ScopeConfigInterface $scopeConfig;

    /**
     * @var ScopeInterface
     */
    private ScopeInterface $scope;

    /**
     * @return void
     */
    public function setUp(): void
    {
        $this->config = $this->createMock(ConfigInterface::class);
        $this->scopeConfig = $this->createMock(ScopeConfigInterface::class);
        $this->scope = $this->createMock(ScopeInterface::class);

        $this->testSubject = new Config($this->scopeConfig);
    }

    /**
     * Test isEnabled method
     *
     * @return void
     */
    public function testIsEnabled()
    {
        $this->scopeConfig
            ->expects($this->once())
            ->method('isSetFlag')
            ->with($this->config::PET_KIND_PATH)
            ->willReturn(true);

        $result = $this->testSubject->isEnabled($this->config::PET_KIND_PATH);

        $this->assertIsBool($result);
    }
}
