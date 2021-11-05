<?php

declare(strict_types=1);

namespace Recruitment\Applicant\Search\Basic;

use Recruitment\Applicant\EmailAddress;
use Recruitment\Applicant\Name;

class ApplicantDTOFactory
{
    public function fromArray(array $input): ApplicantDTO
    {
        return new ApplicantDTO(
            new EmailAddress($input['email']),
            new Name($input['first_name']),
            new Name($input['last_name'])
        );
    }
}
