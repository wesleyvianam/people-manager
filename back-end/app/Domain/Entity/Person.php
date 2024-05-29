<?php

declare(strict_types=1);

namespace App\Domain\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\OneToMany;
use Doctrine\ORM\Mapping\Table;

#[Entity]
#[Table(name: 'people')]
class Person
{
    #[Id, Column, GeneratedValue]
    private int $id;
    #[Column]
    private string $name;
    #[Column]
    private string $cpf;
    #[OneToMany(
        targetEntity: Contact::class,
        mappedBy: "person",
        cascade: ["persist", "remove"]
    )]
    private Collection $contacts;


    public function __construct()
    {
        $this->contacts = new ArrayCollection();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getCpf(): string
    {
        return $this->cpf;
    }

    public function setCpf(string $cpf): void
    {
        $this->cpf = $cpf;
    }

    public function addContact(Contact $contact): void
    {
        $this->contacts->add($contact);
        $contact->setPerson($this);
    }

    /**
     * @return Collection<Contact>
     */
    public function contacts(): Collection
    {
        return $this->contacts;
    }
}