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
use Webjump\PetKindAdminUi\Block\Adminhtml\PetKind\Edit\SaveButton;

class SaveButtonTest extends TestCase
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

        $this->testSubject = new SaveButton($this->context);
    }

    /**
     * Test get button data method
     *
     * @return void
     */
    public function testGetButtonData()
    {
        $expected = [
            'label' => __('Save Pet Kind'),
            'class' => 'save primary',
            'data_attribute' => [
                'mage-init' => ['button' => ['event' => 'save']],
                'form-role' => 'save',
            ],
            'sort_order' => 90,
        ];

        $result = $this->testSubject->getButtonData();
        $this->assertEquals($expected, $result);
    }
}
