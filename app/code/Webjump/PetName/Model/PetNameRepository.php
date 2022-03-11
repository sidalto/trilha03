<?php
/**
 * @author      Webjump Develop Team <dev@webjump.com.br>
 * @copyright   2022 Webjump (http://www.webjump.com.br)
 * @license     http://www.webjump.com.br Copyright
 * @link        http://www.webjump.com.br
 */

declare(strict_types=1);

namespace Webjump\PetName\Model;

use Exception;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Api\SearchResultsInterface;
use Magento\Framework\Api\SearchResultsFactory;
use Magento\Framework\Api\SortOrder;
use Magento\Framework\Api\SortOrderBuilder;
use Webjump\PetName\Api\Data\PetNameInterface;
use Webjump\PetName\Api\Data\PetNameInterfaceFactory;
use Webjump\PetName\Api\PetNameRepositoryInterface;
use Webjump\PetName\Model\ResourceModel\PetName as PetNameResourceModel;
use Webjump\PetName\Model\ResourceModel\PetName\CollectionFactory;

class PetNameRepository implements PetNameRepositoryInterface
{
    /**
     * @var PetNameResourceModel
     */
    private PetNameResourceModel $petNameResourceModel;

    /**
     * @var PetNameInterfaceFactory
     */
    private PetNameInterfaceFactory $petNameInterfaceFactory;

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
     * @var CollectionProcessorInterface
     */
    private CollectionProcessorInterface $collectionProcessorInterface;

    /**
     * @param PetNameInterfaceFactory $petNameInterfaceFactory
     * @param CollectionFactory $collectionFactory
     * @param SearchResultsFactory $searchResultsFactory
     * @param PetNameResourceModel $petNameResourceModel
     * @param CollectionProcessorInterface $collectionProcessor
     * @param SearchCriteriaBuilder $searchCriteriaBuilder
     */
    public function __construct(
        PetNameInterfaceFactory $petNameInterfaceFactory,
        CollectionFactory $collectionFactory,
        SearchResultsFactory $searchResultsFactory,
        PetNameResourceModel $petNameResourceModel,
        CollectionProcessorInterface $collectionProcessor,
        SearchCriteriaBuilder $searchCriteriaBuilder

    ) {
        $this->petNameInterfaceFactory = $petNameInterfaceFactory;
        $this->collectionFactory = $collectionFactory;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->petNameResourceModel = $petNameResourceModel;
        $this->collectionProcessor = $collectionProcessor;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
    }

    /**
     * @param PetNameInterface $pet
     * @param int $id
     * @return int
     * @throws CouldNotSaveException
     */
    public function save(PetNameInterface $pet, int $id = 0): int
    {
        try {
            $existingPet = $this->getById($id);

            if ($existingPet->getEntityId()) {
                $existingPet->setCustomerId($pet->getCustomerId());
                $existingPet->setName($pet->getName());
                $pet = $existingPet;
            }

            $this->petNameResourceModel->save($pet);

            return $pet->getEntityId();
        } catch (Exception $e) {
            throw new CouldNotSaveException(__('Could not save pet name'));
        }
    }

    /**
     * @param int $id
     * @return PetNameInterface
     * @throws NoSuchEntityException
     */
    public function getById(int $id): PetNameInterface
    {
        try {
            $petName = $this->petNameInterfaceFactory->create();
            $this->petNameResourceModel->load($petName, $id);

            return $petName;
        } catch (Exception $e) {
            throw new NoSuchEntityException(__('This pet name don\'t exists'));
        }
    }

    /**
     * @param int $customerId
     * @return PetNameInterface
     * @throws NoSuchEntityException
     */
    public function getCustomerId(int $customerId): PetNameInterface
    {
        try {
            $petName = $this->petNameInterfaceFactory->create();
            $this->petNameResourceModel->load($petName, $customerId, $petName::CUSTOMER_ID);

            return $petName;
        } catch (Exception $e) {
            throw new NoSuchEntityException(__('This pet name don\'t exists'));
        }
    }

    /**
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
     * @param int $id
     * @return bool
     * @throws CouldNotDeleteException
     */
    public function deleteById(int $id): bool
    {
        try {
            $petName = $this->getById($id);
            $this->petNameResourceModel->delete($petName);

            return true;
        } catch (Exception $e) {
            throw new CouldNotDeleteException(__('Could not delete the pet name'));
        }
    }
}
