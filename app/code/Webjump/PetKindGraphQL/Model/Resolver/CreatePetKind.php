<?php
/**
 * @author      Webjump Develop Team <dev@webjump.com.br>
 * @copyright   2022 Webjump (http://www.webjump.com.br)
 * @license     http://www.webjump.com.br Copyright
 * @link        http://www.webjump.com.br
 */

declare(strict_types=1);

namespace Webjump\PetKindGraphQL\Model\Resolver;

use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\Query\ResolverInterface;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;
use Webjump\PetKind\Api\Data\PetKindInterface;
use Webjump\PetKind\Api\PetKindRepositoryInterface;

class CreatePetKind implements ResolverInterface
{
    /**
     * @var PetKindInterface
     */
    private PetKindInterface $petKindInterface;

    /**
     * @var PetKindRepositoryInterface
     */
    private PetKindRepositoryInterface $petKindRepositoryInterface;

    /**
     * CreatePetKind constructor
     *
     * @param PetKindInterface $petKindInterface
     * @param PetKindRepositoryInterface $petKindRepositoryInterface
     */
    public function __construct(
        PetKindInterface $petKindInterface,
        PetKindRepositoryInterface $petKindRepositoryInterface
    ) {
        $this->petKindInterface = $petKindInterface;
        $this->petKindRepositoryInterface = $petKindRepositoryInterface;
    }

    /**
     * Resolve method from CreatePetKind resolver
     *
     * @param Field $field
     * @param $context
     * @param ResolveInfo $info
     * @param array|null $value
     * @param array|null $args
     * @return int
     */
    public function resolve(
        Field $field,
        $context,
        ResolveInfo $info,
        array $value = null,
        array $args = null
    ): int {
        $this->petKindInterface->setName($args['petKind']['name']);
        $this->petKindInterface->setDescription($args['petKind']['description']);

        return $this->petKindRepositoryInterface->save($this->petKindInterface);
    }
}
