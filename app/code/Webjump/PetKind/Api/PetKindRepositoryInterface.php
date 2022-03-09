<?php
/**
 * @author      Webjump Develop Team <dev@webjump.com.br>
 * @copyright   2022 Webjump (http://www.webjump.com.br)
 * @license     http://www.webjump.com.br Copyright
 * @link        http://www.webjump.com.br
 */

declare(strict_types=1);

namespace Webjump\PetKind\Api;

use Magento\Framework\Api\Search\SearchCriteriaInterface;
use Magento\Framework\Api\SearchResultsInterface;
use Webjump\PetKind\Api\Data\PetKindInterface;
use Webjump\PetKind\Model\ResourceModel\PetKind\CollectionFactory;

interface PetKindRepositoryInterface
{
    /**
     * Save the pet kind entity
     *
     * @param PetKindInterface $pet
     * @param int $id
     * @return int
     */
    public function save(PetKindInterface $pet, int $id = 0): int;

    /**
     * Load a specified pet kind by ID
     *
     * @param int $id
     * @return PetKindInterface
     */
    public function getById(int $id): PetKindInterface;

    /**
     * List Pet Kind that match specified search criteria.
     *
     * @param SearchCriteriaInterface $searchCriteria
     * @return SearchResultsInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria): SearchResultsInterface;

//    /**
//     * Get collection the pet kind
//     *
//     * @return CollectionFactory[]
//     */
//    public function getPetKindData(): array;

    /**
     * Delete a specified pet kind.
     *
     * @param int $id
     * @return bool
     */
    public function deleteById(int $id): bool;
}
