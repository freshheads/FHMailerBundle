<?php
declare(strict_types=1);

namespace FH\Bundle\MailerBundle\Tests\Email;

use FH\Bundle\MailerBundle\Email\MessageOptions;
use FH\Bundle\MailerBundle\Email\Participants;
use PHPUnit\Framework\TestCase;

/**
 * @covers \FH\Bundle\MailerBundle\Email\Participants
 */
final class ParticipantsOptionsTest extends TestCase
{
    private $participants;

    protected function setUp(): void
    {
        $this->participants = Participants::fromArray([
            'sender' => [
                'name' => 'Mr. Test',
                'address' => 'noreply@freshheads.com',
            ],
            'from' => [
                [
                    'name' => 'Mr. Test',
                    'address' => 'test@freshheads.com',
                ],
            ],
            'reply_to' => [
                [
                    'name' => 'Mr. Test',
                    'address' => 'mr.test@freshheads.com',
                ],
            ],
            'to' => [
                [
                    'name' => 'Ms. Test',
                    'address' => 'test@freshheads.com',
                ],
                [
                    'name' => 'Test Junior',
                    'address' => 'junior@freshheads.com',
                ],
            ],
            'cc' => [
                [
                    'name' => 'Ms. Test',
                    'address' => 'test1@freshheads.com',
                ],
            ],
            'bcc' => [
                [
                    'name' => 'Ms. Test',
                    'address' => 'test2@freshheads.com',
                ],
            ],
        ]);
    }

    public function testFromArray(): void
    {
        // Sender
        $this->assertTrue($this->participants->hasSender());
        $this->assertSame('Mr. Test', $this->participants->getSender()->getName());
        $this->assertSame('noreply@freshheads.com', $this->participants->getSender()->getAddress());

        // From
        $this->assertTrue($this->participants->hasFrom());
        $this->assertCount(1, $this->participants->getFrom());
        $this->assertSame('Mr. Test', $this->participants->getFrom()[0]->getName());
        $this->assertSame('test@freshheads.com', $this->participants->getFrom()[0]->getAddress());

        // Reply to
        $this->assertTrue($this->participants->hasReplyTo());
        $this->assertCount(1, $this->participants->getReplyTo());
        $this->assertSame('Mr. Test', $this->participants->getReplyTo()[0]->getName());
        $this->assertSame('mr.test@freshheads.com', $this->participants->getReplyTo()[0]->getAddress());

        // To
        $this->assertTrue($this->participants->hasTo());
        $this->assertCount(2, $this->participants->getTo());
        $this->assertSame('Ms. Test', $this->participants->getTo()[0]->getName());
        $this->assertSame('test@freshheads.com', $this->participants->getFrom()[0]->getAddress());
        $this->assertSame('Test Junior', $this->participants->getTo()[1]->getName());
        $this->assertSame('junior@freshheads.com', $this->participants->getTo()[1]->getAddress());

        // Cc
        $this->assertTrue($this->participants->hasCc());
        $this->assertCount(1, $this->participants->getCc());
        $this->assertSame('Ms. Test', $this->participants->getCc()[0]->getName());
        $this->assertSame('test1@freshheads.com', $this->participants->getCc()[0]->getAddress());

        // Bcc
        $this->assertTrue($this->participants->hasBcc());
        $this->assertCount(1, $this->participants->getBcc());
        $this->assertSame('Ms. Test', $this->participants->getBcc()[0]->getName());
        $this->assertSame('test2@freshheads.com', $this->participants->getBcc()[0]->getAddress());
    }
}
