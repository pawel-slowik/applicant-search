<?php

declare(strict_types=1);

namespace Recruitment\Test\Applicant\Search\Basic;

use PHPUnit\Framework\TestCase;
use Recruitment\Applicant\Search\Basic\ApplicantDTOFactory;

/**
 * @covers \Recruitment\Applicant\Search\Basic\ApplicantDTOFactory
 */
class ApplicantDTOFactoryTest extends TestCase
{
    private ApplicantDTOFactory $factory;

    protected function setUp(): void
    {
        $this->factory = new ApplicantDTOFactory();
    }

    public function testCreatesFromArray(): void
    {
        $input = [
            'email' => 'alice.smith@example.com',
            'first_name' => 'Alice',
            'last_name' => 'Smith',
        ];

        $applicant = $this->factory->fromArray($input);

        $this->assertSame('alice.smith@example.com', (string) $applicant->getEmail());
        $this->assertSame('Alice', (string) $applicant->getFirstName());
        $this->assertSame('Smith', (string) $applicant->getLastName());
    }
}
