<?php
/**
 * @author      Webjump Develop Team <dev@webjump.com.br>
 * @copyright   2022 Webjump (http://www.webjump.com.br)
 * @license     http://www.webjump.com.br Copyright
 * @link        http://www.webjump.com.br
 */

declare(strict_types=1);

namespace Webjump\PetKind\Model;

use Exception;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Api\SearchResultsInterface;
use Magento\Framework\Api\SearchResultsFactory;
use Webjump\PetKind\Api\Data\PetKindInterface;
use Webjump\PetKind\Api\Data\PetKindInterfaceFactory;
use Webjump\PetKind\Api\PetKindRepositoryInterface;
use Webjump\PetKind\Model\ResourceModel\PetKind as PetKindResourceModel;
use Webjump\PetKind\Model\ResourceModel\PetKind\CollectionFactory;

class PetKindRepository implements PetKindRepositoryInterface
{
    /**
     * @var PetKindResourceModel
     */
    private PetKindResourceModel $petKindResourceModel;

    /**
     * @var PetKindInterfaceFactory
     */
    private PetKindInterfaceFactory $petKindInterfaceFactory;

    /**
     * @var CollectionFactory
     */
    private CollectionFactory $collectionFactory;

    /**
     * @var CollectionProcessorInterface
     */
    private CollectionProcessorInterface $collectionProcessor;

    /**
     * @var SearchResultsFactory
     */
    private SearchResultsFactory $searchResultsFactory;

    /**
     * @var SearchCriteriaBuilder
     */
    private SearchCriteriaBuilder $searchCriteriaBuilder;

    /**
     * Constructor to PetKindRepository class
     *
     * @param PetKindInterfaceFactory $petKindInterfaceFactory
     * @param CollectionFactory $collectionFactory
     * @param SearchResultsFactory $searchResultsFactory
     * @param PetKindResourceModel $petKindResourceModel
     * @param CollectionProcessorInterface $collectionProcessor
     * @param SearchCriteriaBuilder $searchCriteriaBuilder
     */
    public function __construct(
        PetKindInterfaceFactory $petKindInterfaceFactory,
        CollectionFactory $collectionFactory,
        SearchResultsFactory $searchResultsFactory,
        PetKindResourceModel $petKindResourceModel,
        CollectionProcessorInterface $collectionProcessor,
        SearchCriteriaBuilder $searchCriteriaBuilder

    ) {
        $this->petKindInterfaceFactory = $petKindInterfaceFactory;
        $this->collectionFactory = $collectionFactory;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->petKindResourceModel = $petKindResourceModel;
        $this->collectionProcessor = $collectionProcessor;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
    }

    /**
     * Save method to pet kind
     *
     * @param PetKindInterface $pet
     * @param int|null $id
     * @return int
     * @throws CouldNotSaveException
     */
    public function save(PetKindInterface $pet, int $id = null): int
    {
        try {
            if ($id) {
                $existingPet = $this->getById($id);

                if ($existingPet) {
                    $existingPet->setName($pet->getName());
                    $existingPet->setDescription($pet->getDescription());
                    $pet = $existingPet;
                }
            }

            $this->petKindResourceModel->save($pet);

            return $pet->getEntityId();
        } catch (Exception $e) {
            throw new CouldNotSaveException(__('Could not save pet kind'));
        }
    }

    /**
     * Get by id method to pet kind
     *
     * @param int $id
     * @return PetKindInterface|null
     * @throws NoSuchEntityException
     */
    public function getById(int $id): ?PetKindInterface
    {
        try {
            $petKind = $this->petKindInterfaceFactory->create();
            $this->petKindResourceModel->load($petKind, $id);

            return $petKind;
        } catch (Exception $e) {
            throw new NoSuchEntityException(__('This pet kind don\'t exists'));
        }
    }

    /**
     * Get list method to pet kind
     *
     * @param SearchCriteriaInterface|null $searchCriteria
     * @return SearchResultsInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria = null): SearchResultsInterface
    {
        $collection = $this->collectionFactory->create();
        $searchResult = $this->searchResultsFactory->create();

        if (!$searchCriteria) {
            $searchCriteria = $this->searchCriteriaBuilder->create();
        } else {
            $this->collectionProcessor->process($searchCriteria, $collection);
        }

        $searchResult->setItems($collection->getData());
        $searchResult->setTotalCount($collection->getSize());
        $searchResult->setSearchCriteria($searchCriteria);

        return $searchResult;
    }

    /**
     * Delete by id method to pet kind
     *
     * @param int $id
     * @return bool
     * @throws CouldNotDeleteException
     */
    public function deleteById(int $id): bool
    {
        try {
            $petKind = $this->getById($id);
            $this->petKindResourceModel->delete($petKind);

            return true;
        } catch (Exception $e) {
            throw new CouldNotDeleteException(__('Could not delete the pet kind'));
        }
    }
}
