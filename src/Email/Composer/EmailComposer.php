<?php
declare(strict_types=1);

namespace FH\MailerBundle\Email\Composer;

use FH\MailerBundle\Email\MessageOptions;
use Symfony\Component\Mailer\Exception\InvalidArgumentException;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mime\RawMessage;

final class EmailComposer implements ComposerInterface
{
    private $messageOptions;
    private $composer;

    public function __construct(array $messageOptions, ?ComposerInterface $composer)
    {
        $this->messageOptions = MessageOptions::fromArray($messageOptions);
        $this->composer = $composer;
    }

    /**
     * @return Email
     */
    public function compose(array $context, RawMessage $message = null): RawMessage
    {
        $message = $message ?: new Email();

        if ($this->composer instanceof ComposerInterface) {
            $message = $this->composer->compose($context, $message);
        }

        if (!$message instanceof Email) {
            throw new InvalidArgumentException(sprintf('Expected instance of %s, instance of %s given', Email::class, get_class($message)));
        }

        $this->applySubject($message);
        $this->applyParticipants($message);

        return $message;
    }

    private function applySubject(Email $message): void
    {
        if (!$this->messageOptions->hasSubject()) {
            return;
        }

        $message->subject($this->messageOptions->getSubject());
    }

    private function applyParticipants(Email $message): void
    {
        $participants = $this->messageOptions->getParticipants();

        if ($participants->hasSender()) {
            $message->sender($participants->getSender());
        }

        if ($participants->hasFrom()) {
            $message->from($participants->getFrom());
        }

        if ($participants->hasReplyTo()) {
            $message->replyTo($participants->getReplyTo());
        }

        if ($participants->hasTo()) {
            $message->to($participants->getTo());
        }

        if ($participants->hasCc()) {
            $message->cc($participants['cc']);
        }

        if ($participants->hasBcc()) {
            $message->bcc($participants->getBcc());
        }
    }
}
