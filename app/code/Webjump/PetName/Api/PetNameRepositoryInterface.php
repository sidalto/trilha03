<?php
/**
 * @author      Webjump Develop Team <dev@webjump.com.br>
 * @copyright   2022 Webjump (http://www.webjump.com.br)
 * @license     http://www.webjump.com.br Copyright
 * @link        http://www.webjump.com.br
 */

declare(strict_types=1);

namespace Webjump\PetName\Api;

use Magento\Framework\Api\Search\SearchCriteriaInterface;
use Magento\Framework\Api\SearchResultsInterface;
use Webjump\PetName\Api\Data\PetNameInterface;
use Webjump\PetName\Model\ResourceModel\PetName\CollectionFactory;

interface PetNameRepositoryInterface
{
    /**
     * Save the pet name entity
     *
     * @param PetNameInterface $pet
     * @param int $id
     * @return int
     */
    public function save(PetNameInterface $pet, int $id = 0): int;

    /**
     * Load a specified pet name by ID
     *
     * @param int $id
     * @return PetNameInterface
     */
    public function getById(int $id): PetNameInterface;

    /**
     * @param int $customerId
     * @return PetNameInterface
     */
    public function getCustomerId(int $customerId): PetNameInterface;

    /**
     * List Pet Name that match specified search criteria.
     *
     * @param SearchCriteriaInterface $searchCriteria
     * @return SearchResultsInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria): SearchResultsInterface;

    /**
     * Delete a specified pet name.
     *
     * @param int $id
     * @return bool
     */
    public function deleteById(int $id): bool;
}
