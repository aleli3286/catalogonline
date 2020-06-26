<?php

namespace Botta\CigarCatalog\Api;

interface SubscriptionInterface
{
    const FIELD_FIRSTNAME = 'firstname';
    const FIELD_LASTNAME = 'lastname';
    const FIELD_EMAIL = 'email';

    /**
     * @param string $firstname
     * @return SubscriptionInterface
     */
    public function setFirstname($firstname);

    /**
     * @return string
     */
    public function getFirstname();

    /**
     * @param string $lastname
     * @return SubscriptionInterface
     */
    public function setLastname($lastname);

    /**
     * @return string
     */
    public function getLastname();

    /**
     * @param string $email
     * @return SubscriptionInterface
     */
    public function setEmail($email);

    /**
     * @return string
     */
    public function getEmail();
}