<?php

declare(strict_types=1);

namespace App\Domain\Entity;

use App\Domain\Enum\ContactTypeEnum;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\Table;

#[Entity]
#[Table(name: 'contacts')]
class Contact
{
    #[Id, Column, GeneratedValue]
    private int $id;

    #[Column(length: 100)]
    private string $contact;

    #[Column]
    private int $type;

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

    public function getType(): string|int
    {
        if ($this->type) {
            $contactType = ContactTypeEnum::from($this->type);
            return $contactType->getName();
        }

        return $this->type;
    }

    public function setType(int $type): void
    {
        $this->type = $type;
    }

    /**
     * @return Person
     */
    public function getPerson(): Person
    {
        return $this->person;
    }
}