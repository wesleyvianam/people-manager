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

    public function findBy(string $filter): Contact|array
    {
        /** @Contact */
        $qb = $this->entityManager->getRepository(Contact::class)->createQueryBuilder('p')
            ->where("p.contact LIKE :contact")
            ->setParameter('contact', '%' . $filter . '%');

        $results = $qb->getQuery()->getResult();

        if (empty($results)) {
            return ['code' => 200, 'data' => ['message' => 'Nenhuma contato foi encontrado']];
        }

        return $this->hydrateData($results);
    }

    public function findById(int $id): array
    {
        $result = $this->entityManager->getRepository(Contact::class)->find($id);

        return $this->hydrateData([$result]);
    }

    public function delete(int $id): array
    {
        $contact = $this->entityManager->find(Contact::class, $id);

        if (!$contact) {
            return ["code" => 404, 'data' => ["message" => "Contato não encontrado"]];
        }

        $this->entityManager->remove($contact);
        $this->entityManager->flush();

        return ["code" => 200, 'data' => ["message" => "Contato {$contact->getContact()} deletado com sucesso"]];
    }

    public function register(array $data): Contact|array
    {
        $contact = new Contact();

        $contact->setContact($data["contact"]);
        $contact->setType((int) $data["type"]);

        $person = $this->entityManager->getRepository(Person::class)->find($data["person_id"]);
        $contact->setPerson($person);

        $this->entityManager->persist($contact);
        $this->entityManager->flush();

        return $this->findById($contact->getId());
    }

    public function update(int $id, array $data): array
    {
        $contact = $this->entityManager->find(Contact::class, $id);

        if (!$contact) {
            return ["code" => 404, 'data' => ["message" => "Contato não encontrado"]];
        }

        if (isset($data['contact'])) {
            $contact->setContact($data['contact']);
        }

        if (isset($data['type'])) {
            $contact->setType((int) $data["type"]);
        }

        if (isset($data['person_id'])) {
            $person = $this->entityManager->getRepository(Person::class)->find($data["person_id"]);
            $contact->setPerson($person);
        }

        $this->entityManager->flush();
        return $this->findById($contact->getId());
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

        return $data
            ? ['code' => 200, 'data' => $data]
            : ['code' => 500, 'data' => ['message' => 'Ocorreu um erro em tratar dados']];
    }
}