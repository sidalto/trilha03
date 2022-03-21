<?php
/**
 * @author      Webjump Develop Team <dev@webjump.com.br>
 * @copyright   2022 Webjump (http://www.webjump.com.br)
 * @license     http://www.webjump.com.br Copyright
 * @link        http://www.webjump.com.br
 */

declare(strict_types=1);

namespace Webjump\PetKindGraphQL\Test\Unit\Model\Resolver;

use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\Query\ResolverInterface;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;
use Webjump\PetKind\Api\Data\PetKindInterface;
use Webjump\PetKind\Api\Data\PetKindInterfaceFactory;
use Webjump\PetKind\Api\PetKindRepositoryInterface;
use Webjump\PetKind\Model\Data\PetKind;
use Webjump\PetKindGraphQL\Model\Resolver\CreatePetKind;
use Magento\Framework\GraphQl\Query\Resolver\ContextInterface;
use Webjump\PetKindGraphQL\Model\Resolver\DeletePetKind;
use Webjump\PetKindGraphQL\Model\Resolver\GetAllPetKind;
use Magento\Framework\Api\Search\SearchCriteriaInterface;
use Magento\Framework\Api\SearchResultsInterface;

class GetAllPetKindTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @var PetKindInterface
     */
    private PetKindInterface $petKindInterface;

    /**
     * @var PetKindInterfaceFactory
     */
    private PetKindInterfaceFactory $petKindFactory;

    /**
     * @var PetKindRepositoryInterface
     */
    private PetKindRepositoryInterface $petKindRepository;

    /**
     * @var SearchCriteriaInterface
     */
    private SearchCriteriaInterface $searchCriteria;

    /**
     * @var SearchResultsInterface
     */
    private SearchResultsInterface $searchResults;

    /**
     * @var Field
     */
    private Field $field;

    /**
     * @var ContextInterface
     */
    private ContextInterface $context;

    /**
     * @var ResolveInfo
     */
    private ResolveInfo $info;

    /**
     * @return void
     */
    public function setUp(): void
    {
        $this->petKindInterface = $this->createMock(PetKindInterface::class);
        $this->petKind = $this->createMock(PetKind::class);
        $this->petKindFactory = $this->createMock(PetKindInterfaceFactory::class);
        $this->petKindRepository = $this->createMock(PetKindRepositoryInterface::class);
        $this->field = $this->createMock(Field::class);
        $this->context = $this->createMock(ContextInterface::class);
        $this->info = $this->createMock(ResolveInfo::class);
        $this->searchCriteria = $this->createMock(SearchCriteriaInterface::class);
        $this->searchResults = $this->createMock(SearchResultsInterface::class);

        $this->testSubject = new GetAllPetKind($this->petKindRepository);
    }

    public function testResolve()
    {
        $this->petKindRepository
            ->expects($this->once())
            ->method('getList')
            ->willReturn($this->searchResults);

        $this->searchResults
            ->expects($this->once())
            ->method('getItems')
            ->willReturn([$this->petKindInterface]);

        $result = $this->testSubject->resolve($this->field, $this->context, $this->info);
        $this->assertIsArray($result);
    }
}
