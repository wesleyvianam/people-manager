<?php

declare(strict_types=1);

namespace App\Repositories;

use Doctrine\ORM\EntityManager;
use App\Domain\Entity\Contact;
use App\Domain\Entity\Person;

class PersonRepository
{
    public function __construct(
        protected EntityManager $entityManager,
    ) {
    }

    public function findAll()
    {
        /** @Person */
        $results = $this->entityManager->getRepository(Person::class)->findAll();

        return $this->hydrateData($results);
    }

    public function findBy(string $name)
    {
        /** @Person */
        $qb = $this->entityManager->getRepository(Person::class)->createQueryBuilder('p')
        ->where('p.name LIKE :name')
        ->setParameter('name', '%' . $name . '%');

        $results = $qb->getQuery()->getResult();

        return $this->hydrateData($results);
    }

    public function findById(int $id): array
    {
        $result = $this->entityManager->getRepository(Person::class)->find($id);

        return $this->hydrateData([$result]);
    }

    public function delete(int $id): void
    {
        $person = $this->entityManager->find(Person::class, $id);

        $this->entityManager->remove($person);
        $this->entityManager->flush();
    }

    public function register(array $data): Person|array
    {
        $person = new Person();

        $person->setName($data["name"]);
        $person->setCpf($data["cpf"]);

        if (!empty($data["contacts"])) {
            foreach ($data["contacts"] as $item) {
                $contact = new Contact();
                $contact->setType($item['type']);
                $contact->setContact($item['contact']);

                $person->addContact($contact);
            }
        }

        $this->entityManager->persist($person);
        $this->entityManager->flush();

        return $this->findById($person->getId());
    }

    public function update(int $id, array $data): array
    {
        $person = $this->entityManager->find(Person::class, $id);

        if (isset($data['name'])) {
            $person->setName($data['name']);
        }

        if (isset($data['cpf'])) {
            $person->setCpf($data['cpf']);
        }

        $this->entityManager->flush();
        $data = $this->findById($person->getId());

        return $this->hydrateData($data);
    }

    private function hydrateData(Person|array $results): array
    {
        foreach ($results as $key => $person) {
            $data[$key]['id'] = $person->getId();
            $data[$key]['name'] = $person->getName();
            $data[$key]['cpf'] = $person->getCpf();

            if ($person->contacts()->count()) {
                foreach ($person->contacts() as $index => $contact) {
                    $data[$key]['contacts'][$index]['id'] = $contact->getId();
                    $data[$key]['contacts'][$index]['type'] = $contact->getType();
                    $data[$key]['contacts'][$index]['contact'] = $contact->getContact();
                }
            }
        }

        return $data ?? [];
    }
}