<?php
/**
 * @author      Webjump Develop Team <dev@webjump.com.br>
 * @copyright   2022 Webjump (http://www.webjump.com.br)
 * @license     http://www.webjump.com.br Copyright
 * @link        http://www.webjump.com.br
 */

declare(strict_types=1);

namespace Webjump\PetName\Plugin\Magento\Customer\Model\ResourceModel;

use Magento\Customer\Api\Data\CustomerSearchResultsInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Webjump\PetName\Api\PetNameRepositoryInterface;
use Magento\Customer\Api\Data\CustomerInterface;
use Magento\Customer\Api\CustomerRepositoryInterface;

class CustomerRepositoryPlugin
{
    /**
     * @var CustomerInterface
     */
    private CustomerInterface $customer;

    /**
     * @var CustomerRepositoryInterface
     */
    private CustomerRepositoryInterface $customerRepository;

    /**
     * @var PetNameRepositoryInterface
     */
    private PetNameRepositoryInterface $petNameRepository;

    /**
     * @param CustomerInterface $customer
     * @param CustomerRepositoryInterface $customerRepository
     * @param PetNameRepositoryInterface $petNameRepository
     */
    public function __construct(
        CustomerInterface $customer,
        CustomerRepositoryInterface $customerRepository,
        PetNameRepositoryInterface $petNameRepository
    ) {
        $this->customer = $customer;
        $this->customerRepository = $customerRepository;
        $this->petNameRepository = $petNameRepository;
    }

    /**
     * @param CustomerRepositoryInterface $subject
     * @param CustomerInterface $result
     * @return CustomerInterface
     */
    public function afterGet(
        CustomerRepositoryInterface $subject,
        CustomerInterface $result
    ): CustomerInterface {
        $petName = $this->petNameRepository->getCustomerId((int)$result->getId());
        $extensionAttributes = $result->getExtensionAttributes();
        $extensionAttributes->setPetName($petName);
        $result->setExtensionAttributes($extensionAttributes);

        return $result;
    }

    /**
     * @param CustomerRepositoryInterface $subject
     * @param CustomerInterface $result
     * @param int $customerId
     * @return CustomerInterface
     */
    public function afterGetById(
        CustomerRepositoryInterface $subject,
        CustomerInterface $result,
        int $customerId
    ): CustomerInterface {
        $petName = $this->petNameRepository->getCustomerId((int)$result->getId());
        $extensionAttributes = $result->getExtensionAttributes();
        $extensionAttributes->setPetName($petName);
        $result->setExtensionAttributes($extensionAttributes);

        return $result;
    }

    /**
     * @param CustomerRepositoryInterface $subject
     * @param CustomerSearchResultsInterface $results
     * @param SearchCriteriaInterface $searchCriteria
     * @return CustomerSearchResultsInterface
     */
    public function afterGetList(
        CustomerRepositoryInterface $subject,
        CustomerSearchResultsInterface $results,
        SearchCriteriaInterface $searchCriteria
    ): CustomerSearchResultsInterface {
        $customers = [];

        foreach ($results->getItems() as $entity) {
            $petName = $this->petNameRepository->getCustomerId((int)$entity->getId());
            $extensionAttributes = $entity->getExtensionAttributes();
            $extensionAttributes->setPetName($petName);
            $entity->setExtensionAttributes($extensionAttributes);

            $customers[] = $entity;
        }

        $results->setItems($customers);

        return $results;
    }

    /**
     * @param CustomerRepositoryInterface $subject
     * @param CustomerInterface $result
     * @return CustomerInterface
     */
    public function afterSave(
        CustomerRepositoryInterface $subject,
        CustomerInterface $result
    ): CustomerInterface {
        $extensionAttributes = $result->getExtensionAttributes();
        $petName = $extensionAttributes->getPetName();
        $this->petNameRepository->save($petName);
        $extensionAttributes->setPetName($petName);
        $result->setExtensionAttributes($extensionAttributes);

        return $result;
    }
}
