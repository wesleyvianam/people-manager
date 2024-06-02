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

    public function findAll(): array
    {
        /** @Person */
        $results = $this->entityManager->getRepository(Person::class)->findAll();

        if (empty($results)) {
            return ['code' => 200, 'data' => []];
        }

        return $this->hydrateData($results);
    }

    public function findBy(string $filter): Person|array
    {
        $field = 'name';
        if (is_numeric(preg_replace('/[^0-9]/', '', $filter))) {
            $field = 'cpf';
        }

        /** @Person */
        $qb = $this->entityManager->getRepository(Person::class)->createQueryBuilder('p')
        ->where("p.{$field} LIKE :{$field}")
        ->setParameter("{$field}", '%' . $filter . '%');

        $results = $qb->getQuery()->getResult();

        if (empty($results)) {
            return ['code' => 200, 'data' => ['message' => 'Nenhuma pessoa foi encontrada']];
        }

        return $this->hydrateData($results);
    }

    public function findById(int $id): array
    {
        $result = $this->entityManager->getRepository(Person::class)->find($id);

        if (empty($result)) {
            return ['code' => 404, 'data' => ['message' => 'Pessoa não encontrada']];
        }

        return $this->hydrateData([$result]);
    }

    public function delete(int $id): array
    {
        $person = $this->entityManager->find(Person::class, $id);

        if (!$person) {
            return ["code" => 404, 'data' => ["message" => "Pessoa não encontrada"]];
        }

        $this->entityManager->remove($person);
        $this->entityManager->flush();

        return ["code" => 202, 'data' => ["message" => "{$person->getName()} deletado(a) com sucesso"]];
    }

    public function register(array $data): Person|array
    {
        $person = new Person();

        $person->setName($data["name"]);
        $person->setCpf($data["cpf"]);

        $contact = new Contact();
        $contact->setType((int) $data['type']);
        $contact->setContact($data['contact']);

        $person->addContact($contact);

        $this->entityManager->persist($person);
        $this->entityManager->flush();

        return $this->findById($person->getId());
    }

    public function update(int $id, array $data): array
    {
        /** @var Person $person */
        $person = $this->entityManager->find(Person::class, $id);

        if (!$person) {
            return ["code" => 404, 'data' => ["message" => "Pessoa não encontrada"]];
        }

        if (isset($data['name'])) {
            $person->setName($data['name']);
        }

        if (isset($data['cpf'])) {
            $person->setCpf($data['cpf']);
        }

        $this->entityManager->flush();
        return $this->findById($person->getId());
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

        return $data
            ? ['code' => 200, 'data' => $data]
            : ['code' => 500, 'data' => ['message' => 'Ocorreu um erro em tratar dados']];
    }
}