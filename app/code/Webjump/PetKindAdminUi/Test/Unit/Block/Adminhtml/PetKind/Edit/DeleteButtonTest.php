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

class DeleteButtonTest extends TestCase
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
        $this->deleteButton = $this->createMock(DeleteButton::class);
        $this->context = $this->createMock(Context::class);
        $this->requestInterface = $this->createMock(RequestInterface::class);
        $this->urlInterface = $this->createMock(UrlInterface::class);

        $this->testSubject = new DeleteButton($this->context);
    }

    /**
     * Test get button data method
     *
     * @return void
     */
    public function testGetButtonData()
    {
        $id = '1';
        $expected = [
            'label' => __('Delete Pet Kind'),
            'class' => 'delete',
            'on_click' => 'deleteConfirm(\'' . __(
                    'Are you sure you want to do this?'
                ) . '\', \'' . 'pets/petkind/delete/entity_id/' . $id . '\')',
            'sort_order' => 20,
        ];

        $this->context
            ->expects($this->once())
            ->method('getUrlBuilder')
            ->willReturn($this->urlInterface);

        $this->context
            ->expects($this->exactly(2))
            ->method('getRequest')
            ->willReturn($this->requestInterface);

        $this->requestInterface
            ->expects($this->exactly(2))
            ->method('getParam')
            ->with('entity_id')
            ->willReturn($id);

        $this->urlInterface
            ->expects($this->once())
            ->method('getUrl')
            ->with('*/*/delete', ['entity_id' => $id])
            ->willReturn('pets/petkind/delete/entity_id/' . $id);

        $result = $this->testSubject->getButtonData();
        $this->assertIsArray($result);
        $this->assertEquals($expected, $result);
    }

    /**
     * Test delete url method
     *
     * @return void
     */
    public function testDeleteUrl()
    {
        $id = '1';
        $expected = 'pets/petkind/delete/entity_id/' . $id;

        $this->context
            ->expects($this->once())
            ->method('getUrlBuilder')
            ->willReturn($this->urlInterface);

        $this->context
            ->expects($this->once())
            ->method('getRequest')
            ->willReturn($this->requestInterface);

        $this->requestInterface
            ->expects($this->once())
            ->method('getParam')
            ->with('entity_id')
            ->willReturn($id);

        $this->urlInterface
            ->expects($this->once())
            ->method('getUrl')
            ->with('*/*/delete', ['entity_id' => $id])
            ->willReturn('pets/petkind/delete/entity_id/' . $id);

        $result = $this->testSubject->getDeleteUrl();
        $this->assertIsString($result);
        $this->assertEquals($expected, $result);
    }
}
