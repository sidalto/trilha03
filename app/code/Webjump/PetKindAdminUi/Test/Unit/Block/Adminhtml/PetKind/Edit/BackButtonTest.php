<?php
/**
 * @author      Webjump Develop Team <dev@webjump.com.br>
 * @copyright   2022 Webjump (http://www.webjump.com.br)
 * @license     http://www.webjump.com.br Copyright
 * @link        http://www.webjump.com.br
 */

namespace Webjump\PetKindAdminUi\Test\Unit\Block\Adminhtml\PetKind\Edit;

use Magento\Framework\UrlInterface;
use PHPUnit\Framework\TestCase;
use Webjump\PetKindAdminUi\Block\Adminhtml\PetKind\Edit\BackButton;
use Webjump\PetKindAdminUi\Block\Adminhtml\PetKind\Edit\GenericButton;
use Magento\Backend\Block\Widget\Context;

class BackButtonTest extends TestCase
{
    /**
     * @var GenericButton
     */
    private GenericButton $genericButton;

    /**
     * @var Context
     */
    private Context $context;

    /**
     * @return void
     */
    public function setUp(): void
    {
        $this->genericButton = $this->createMock(GenericButton::class);
        $this->backButton = $this->createMock(BackButton::class);
        $this->context = $this->createMock(Context::class);
        $this->urlInterface = $this->createMock(UrlInterface::class);

        $this->testSubject = new BackButton($this->context);
    }

    /**
     * Test get button data method
     *
     * @return void
     */
    public function testGetButtonData()
    {
        $expected = [
            'label' => __('Back'),
            'on_click' => sprintf("location.href = '%s';", 'pets/petkind/index'),
            'class' => 'back',
            'sort_order' => 10
        ];

        $this->context
            ->expects($this->once())
            ->method('getUrlBuilder')
            ->willReturn($this->urlInterface);

        $this->urlInterface
            ->expects($this->once())
            ->method('getUrl')
            ->with('*/*/')
            ->willReturn('pets/petkind/index');

        $result = $this->testSubject->getButtonData();
        $this->assertIsArray($result);
        $this->assertEquals($expected, $result);
    }

    public function testGetBackUrl()
    {
        $expected = 'pets/petkind/index';

        $this->context
            ->expects($this->once())
            ->method('getUrlBuilder')
            ->willReturn($this->urlInterface);

        $this->urlInterface
            ->expects($this->once())
            ->method('getUrl')
            ->with('*/*/')
            ->willReturn('pets/petkind/index');

        $result = $this->testSubject->getBackUrl();
        $this->assertIsString($result);
        $this->assertEquals($expected, $result);
    }
}
