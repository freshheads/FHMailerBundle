<?php
declare(strict_types=1);

namespace FH\Bundle\MailerBundle\Tests\Composer;

use FH\Bundle\MailerBundle\Composer\EmailComposer;
use FH\Bundle\MailerBundle\Email\MessageOptions;
use FH\Bundle\MailerBundle\Email\Participants;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Email;

/**
 * @covers \FH\Bundle\MailerBundle\Composer\EmailComposer
 */
final class EmailComposerTest extends TestCase
{
    private $sender;
    private $to;
    private $messageOptions;
    private $emailComposer;

    protected function setUp(): void
    {
        $this->sender = new Address('test@freshheads.com', 'Mr. Test');
        $this->to = new Address('test@freshheads.com', 'Ms. Test');

        $this->messageOptions = new MessageOptions(
            'Test email',
            null,
            null,
            new Participants(
                $this->sender,
                [$this->sender],
                [$this->sender],
                [$this->to],
                [$this->to],
                [$this->to]
            )
        );

        $this->emailComposer = new EmailComposer($this->messageOptions);
    }

    public function testReturnedMessageType(): void
    {
        $email = $this->emailComposer->compose();

        $this->assertInstanceOf(Email::class, $email);
    }
}
