<?php

declare(strict_types=1);

namespace Recruitment\Test\Applicant\Search\Detailed;

use PHPUnit\Framework\TestCase;
use Recruitment\Applicant\Search\Detailed\ApplicantDTOFactory;

/**
 * @covers \Recruitment\Applicant\Search\Detailed\ApplicantDTOFactory
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
            'tags' => [
                'foo',
            ],
            'notes' => [
                'bar',
                'baz',
            ],
        ];

        $applicant = $this->factory->fromArray($input);

        $this->assertSame('alice.smith@example.com', (string) $applicant->getEmail());
        $this->assertSame('Alice', (string) $applicant->getFirstName());
        $this->assertSame('Smith', (string) $applicant->getLastName());

        $this->assertCount(1, $applicant->getTags());
        $this->assertSame('foo', (string) $applicant->getTags()[0]);

        $this->assertCount(2, $applicant->getNotes());
        $this->assertSame('bar', (string) $applicant->getNotes()[0]);
        $this->assertSame('baz', (string) $applicant->getNotes()[1]);
    }
}
