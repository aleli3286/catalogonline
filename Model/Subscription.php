<?php

namespace Botta\CigarCatalog\Model;

use Botta\CigarCatalog\Api\SubscriptionInterface;

/**
 * Class Subscription
 * @package Botta\CigarCatalog\Model
 * @method setAddress(string $address)
 * @method getAddress()
 * @method setCity(string $city)
 * @method getCity()
 * @method setState(string $state)
 * @method getState()
 * @method setPostcode(string $postcode)
 * @method getPostcode()
 * @method setComments(string $comments)
 * @method getComments()
 * @method setRequestStatusId(int $statusId)
 * @method getRequestStatusId()
 * @method setCreatedAt(\DateTime $createdAt)
 * @method getCreatedAt()
 * @method setUpdatedAt(\DateTime $updatedAt)
 * @method getUpdatedAt()
 */
class Subscription extends \Magento\Framework\Model\AbstractModel implements SubscriptionInterface
{
    protected function _construct()
    {
        $this->_init(
            \Botta\CigarCatalog\Model\ResourceModel\Subscription::class
        );
    }

    public function setFirstname($firstname)
    {
        return $this->setData(self::FIELD_FIRSTNAME, $firstname);
    }

    public function getFirstname()
    {
        return $this->getData(self::FIELD_FIRSTNAME);
    }

    public function setLastname($lastname)
    {
        return $this->setData(self::FIELD_LASTNAME, $lastname);
    }

    public function getLastname()
    {
        return $this->getData(self::FIELD_LASTNAME);
    }

    public function setEmail($email)
    {
        return $this->setData(self::FIELD_EMAIL, strtolower($email));
    }

    public function getEmail()
    {
        return $this->getData(self::FIELD_EMAIL);
    }
}