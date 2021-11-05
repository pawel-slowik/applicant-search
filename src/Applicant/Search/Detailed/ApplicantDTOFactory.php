<?php

declare(strict_types=1);

namespace Recruitment\Applicant\Search\Detailed;

use Recruitment\Applicant\EmailAddress;
use Recruitment\Applicant\Name;
use Recruitment\Applicant\Note;
use Recruitment\Applicant\Tag;

class ApplicantDTOFactory
{
    public function fromArray(array $input): ApplicantDTO
    {
        $tags = [];
        foreach ($input['tags'] as $tag) {
            $tags[] = new Tag($tag);
        }

        $notes = [];
        foreach ($input['notes'] as $note) {
            $notes[] = new Note($note);
        }

        return new ApplicantDTO(
            new EmailAddress($input['email']),
            new Name($input['first_name']),
            new Name($input['last_name']),
            $tags,
            $notes
        );
    }
}
