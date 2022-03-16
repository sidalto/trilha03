<?php
/**
 * @author      Webjump Develop Team <dev@webjump.com.br>
 * @copyright   2022 Webjump (http://www.webjump.com.br)
 * @license     http://www.webjump.com.br Copyright
 * @link        http://www.webjump.com.br
 */

declare(strict_types=1);

namespace Webjump\PetKindGraphQL\Model\Resolver;

use Magento\Framework\Api\ExtensibleDataInterface;
use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\Query\ResolverInterface;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;
use Webjump\PetKind\Api\PetKindRepositoryInterface;

class GetAllPetKind implements ResolverInterface
{
    /**
     * @var PetKindRepositoryInterface
     */
    private PetKindRepositoryInterface $petKindRepositoryInterface;

    /**
     * GetAllPetKind constructor
     *
     * @param PetKindRepositoryInterface $petKindRepositoryInterface
     */
    public function __construct(PetKindRepositoryInterface $petKindRepositoryInterface)
    {
        $this->petKindRepositoryInterface = $petKindRepositoryInterface;
    }

    /**
     * Resolve method from GetAllPetKind resolver
     *
     * @param Field $field
     * @param $context
     * @param ResolveInfo $info
     * @param array|null $value
     * @param array|null $args
     * @return ExtensibleDataInterface[]
     */
    public function resolve(
        Field $field,
        $context,
        ResolveInfo $info,
        array $value = null,
        array $args = null
    ): array {
        return $this->petKindRepositoryInterface
            ->getList()
            ->getItems();
    }
}
