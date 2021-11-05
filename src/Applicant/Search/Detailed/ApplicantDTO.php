<?php

declare(strict_types=1);

namespace Recruitment\Applicant\Search\Detailed;

use Recruitment\Applicant\EmailAddress;
use Recruitment\Applicant\Name;
use Recruitment\Applicant\Note;
use Recruitment\Applicant\Tag;

class ApplicantDTO
{
    private EmailAddress $email;

    private Name $firstName;

    private Name $lastName;

    /**
     * @var Tag[]
     */
    private array $tags;

    /**
     * @var Note[]
     */
    private array $notes;

    public function __construct(
        EmailAddress $email,
        Name $firstName,
        Name $lastName,
        array $tags = [],
        array $notes = []
    ) {
        $this->email = $email;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->tags = $tags;
        $this->notes = $notes;
    }

    public function getEmail(): EmailAddress
    {
        return $this->email;
    }

    public function getFirstName(): Name
    {
        return $this->firstName;
    }

    public function getLastName(): Name
    {
        return $this->lastName;
    }

    /**
     * @return Tag[]
     */
    public function getTags(): array
    {
        return $this->tags;
    }

    /**
     * @return Note[]
     */
    public function getNotes(): array
    {
        return $this->notes;
    }
}
