<?php

namespace App\Repository;
use App\Entity\Customer;
use Doctrine\ORM\EntityManager;

class CustomerRepository
{
    /**
     * @var string
     */
    private $class = 'App\Entity\Customer';
    /**
     * @var EntityManager
     */
    private $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    /**
     * @param String $email
     * @return object|null
     */
    public function emailOfCustomer(string $email)
    {
        return $this->em->getRepository($this->class)->findOneBy([
            'email' => $email
        ]);
    }

    /**
     * @param Customer $customer
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function flushData(Customer $customer) : void
    {
//        var_dump('umabot dito??');
        $this->em->persist($customer);
        $this->em->flush();
    }

    /**
     * create Customer
     * @param Customer $customer
     * @param $data
     * @return Customer
     */
    public function prepareData(Customer $customer,$data) : Customer
    {
        $customer->setFirstName($data['firstName'])
            ->setLastName($data['lastName'])
            ->setEmail($data['email'])
            ->setUsername($data['username'])
            ->setPassword($data['password'])
            ->setGender($data['gender'])
            ->setCountry($data['lastName'])
            ->setCity($data['city'])
            ->setPhone($data['phone']);

        return $customer;
    }

    /**
     * @return array
     */
    public function findAll() : array
    {
        $select = $this->queryBuilder()->select('CONCAT(c.first_name,  \' \', c.last_name) as fullName, 
            c.email, c.country')
            ->from($this->class, 'c');

        return $select->getQuery()->getResult();
    }

    /**
     * @param string $id
     * @return array
     */
    public function customerOfId(string $id) : array
    {
        $select = $this->queryBuilder()->select('CONCAT(c.first_name,  \' \', c.last_name) as fullName, 
            c.email,  c.username, c.gender,  c.country, c.city,  c.phone')
            ->from($this->class, 'c')
            ->where('c.id = :cId')
            ->setParameters(['cId'=> $id]);

        return $select->getQuery()->getResult();
    }

    /**
     * @return \Doctrine\ORM\QueryBuilder
     */
    private function queryBuilder()
    {
        return $this->em->createQueryBuilder();
    }
}
