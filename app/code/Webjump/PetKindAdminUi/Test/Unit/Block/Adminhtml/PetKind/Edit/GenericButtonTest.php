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
use Webjump\PetKindAdminUi\Block\Adminhtml\PetKind\Edit\DeleteButton;
use Webjump\PetKindAdminUi\Block\Adminhtml\PetKind\Edit\GenericButton;
use Magento\Framework\App\RequestInterface;
use Magento\Backend\Block\Widget\Context;

class GenericButtonTest extends TestCase
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
     * @var RequestInterface
     */
    private RequestInterface $request;

    /**
     * @return void
     */
    public function setUp(): void
    {
        $this->genericButton = $this->createMock(GenericButton::class);
        $this->context = $this->createMock(Context::class);
        $this->requestInterface = $this->createMock(RequestInterface::class);
        $this->urlInterface = $this->createMock(UrlInterface::class);

        $this->testSubject = new DeleteButton($this->context);
    }

    public function testGetModelId()
    {
        $id = '1';

        $this->context
            ->expects($this->once())
            ->method('getRequest')
            ->willReturn($this->requestInterface);

        $this->requestInterface
            ->expects($this->once())
            ->method('getParam')
            ->with('entity_id')
            ->willReturn($id);

        $result = $this->testSubject->getModelId();
        $this->assertEquals($id, $result);
    }

    public function testGetUrl()
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

        $result = $this->testSubject->getUrl('*/*/');
        $this->assertIsString($result);
        $this->assertEquals($expected, $result);
    }
}
