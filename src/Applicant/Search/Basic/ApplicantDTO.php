<?php

declare(strict_types=1);

namespace Recruitment\Applicant\Search\Basic;

use Recruitment\Applicant\EmailAddress;
use Recruitment\Applicant\Name;

class ApplicantDTO
{
    private EmailAddress $email;

    private Name $firstName;

    private Name $lastName;

    public function __construct(
        EmailAddress $email,
        Name $firstName,
        Name $lastName
    ) {
        $this->email = $email;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
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
}
