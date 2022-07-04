<?php

declare(strict_types=1);

namespace FH\Bundle\MailerBundle\Tests\Composer;

use FH\Bundle\MailerBundle\Composer\ApplyEmailMessageOptions;
use FH\Bundle\MailerBundle\Email\MessageOptions;
use FH\Bundle\MailerBundle\Email\Participants;
use PHPUnit\Framework\TestCase;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mime\Address;

/**
 * @covers \FH\Bundle\MailerBundle\Composer\ApplyEmailMessageOptions
 */
final class ApplyEmailMessageOptionsTest extends TestCase
{
    private MessageOptions $messageOptions;
    private ApplyEmailMessageOptions $applyEmailMessageOptions;
    private TemplatedEmail $assertEmail;

    protected function setUp(): void
    {
        $sender = new Address('test@freshheads.com', 'Mr. Test');
        $to = new Address('test@freshheads.com', 'Ms. Test');

        $this->messageOptions = new MessageOptions(
            'Test email',
            'test.html.twig',
            'test.txt.twig',
            new Participants(
                $sender,
                [$sender],
                [$sender],
                [$to],
                [$to],
                [$to]
            )
        );

        $this->assertEmail = new TemplatedEmail();
        $this->assertEmail->subject('Test email');
        $this->assertEmail->sender($sender);
        $this->assertEmail->from($sender);
        $this->assertEmail->replyTo($sender);
        $this->assertEmail->to($to);
        $this->assertEmail->cc($to);
        $this->assertEmail->bcc($to);

        $this->applyEmailMessageOptions = new ApplyEmailMessageOptions();
    }

    public function testOptionsApplied(): void
    {
        $email = new TemplatedEmail();
        $this->applyEmailMessageOptions->apply($email, $this->messageOptions);

        $this->assertSame($this->assertEmail->getSubject(), $email->getSubject());
        $this->assertSame($this->assertEmail->getSender(), $email->getSender());
        $this->assertSame($this->assertEmail->getFrom(), $email->getFrom());
        $this->assertSame($this->assertEmail->getTo(), $email->getTo());
        $this->assertSame($this->assertEmail->getCc(), $email->getCc());
        $this->assertSame($this->assertEmail->getBcc(), $email->getBcc());
    }
}
