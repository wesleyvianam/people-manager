<?php

declare(strict_types=1);

namespace Easy\Wallet\Domain\Entity;

use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;

#[Entity]
class Contact
{
    #[Id, Column, GeneratedValue]
    private int $id;

    #[Column]
    private string $contact;

    #[ManyToOne(targetEntity: Person::class, inversedBy: 'contacts')]
    private Person $person;

    public function getId(): int
    {
        return $this->id;
    }

    public function setContact(string $contact): void
    {
        $this->contact = $contact;
    }

    public function getContact(): string
    {
        return $this->contact;
    }

    public function setPerson(Person $person): void
    {
        $this->person = $person;
    }

    /**
     * @return Person
     */
    public function getPerson(): Person
    {
        return $this->person;
    }
}