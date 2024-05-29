<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Domain\Entity\Person;
use Doctrine\ORM\EntityManager;
use App\Domain\Entity\Contact;

class ContactRepository
{
    public function __construct(
        protected EntityManager $entityManager,
    ) {
    }

    public function findAll()
    {
        /** @Contact */
        $results = $this->entityManager->getRepository(Contact::class)->findAll();

        return $this->hydrateData($results);
    }

    public function findById(int $id): array
    {
        $result = $this->entityManager->getRepository(Contact::class)->find($id);

        return $this->hydrateData([$result]);
    }

    public function delete(int $id): void
    {
        $person = $this->entityManager->find(Contact::class, $id);

        $this->entityManager->remove($person);
        $this->entityManager->flush();
    }

    public function register(array $data): Contact|array
    {
        $contact = new Contact();

        $contact->setContact($data["contact"]);
        $contact->setType($data["type"]);

        $person = $this->entityManager->getRepository(Person::class)->find($data["person_id"]);
        $contact->setPerson($person);

        $this->entityManager->persist($contact);
        $this->entityManager->flush();

        return $this->findById($contact->getId());
    }

    public function update(int $id, array $data): array
    {
        $person = $this->entityManager->find(Contact::class, $id);

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

    private function hydrateData(Contact|array $results): array
    {
        foreach ($results as $key => $contact) {
            $data[$key]['id'] = $contact->getId();
            $data[$key]['contact'] = $contact->getContact();
            $data[$key]['type'] = $contact->getType();

            if ($contact->getPerson()) {
                $data[$key]['person']['id'] = $contact->getPerson()->getId();
                $data[$key]['person']['name'] = $contact->getPerson()->getName();
                $data[$key]['person']['cpf'] = $contact->getPerson()->getCpf();
            }
        }

        return $data ?? [];
    }
}