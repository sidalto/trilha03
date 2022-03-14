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
use Magento\Framework\App\RequestInterface;
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
     * @var RequestInterface
     */
    private RequestInterface $request;

    /**
     * @param CustomerInterface $customer
     * @param CustomerRepositoryInterface $customerRepository
     * @param RequestInterface $request
     */
    public function __construct(
        CustomerInterface $customer,
        CustomerRepositoryInterface $customerRepository,
        RequestInterface $request
    ) {
        $this->customer = $customer;
        $this->customerRepository = $customerRepository;
        $this->request = $request;
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
        $petName = $result->getCustomAttribute('pet_name')->getValue();
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
        $petName = $result->getCustomAttribute('pet_name')->getValue();
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
            $petName = $entity->getCustomAttribute('pet_name')->getValue();
            $extensionAttributes = $entity->getExtensionAttributes();
            $extensionAttributes->setPetName($petName);
            $entity->setExtensionAttributes($extensionAttributes);

            $customers[] = $entity;
        }

        $results->setItems($customers);

        return $results;
    }
}
