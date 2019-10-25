<?php
declare(strict_types=1);

namespace FH\MailerBundle\Email\Composer;

use Symfony\Component\Mailer\Exception\InvalidArgumentException;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mime\RawMessage;

final class EmailComposer implements ComposerInterface
{
    private $configs;
    private $composer;

    public function __construct(array $configs, ?ComposerInterface $composer)
    {
        $this->configs = $configs;
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
        if (!is_string($this->configs['subject'])) {
            return;
        }

        $message->subject($this->configs['subject']);
    }

    private function applyParticipants(Email $message): void
    {
        if (is_string($this->configs['sender'])) {
            $message->sender($this->configs['sender']);
        }

        if (is_string($this->configs['from'])) {
            $message->from($this->configs['from']);
        }

        if (is_string($this->configs['reply_to'])) {
            $message->replyTo($this->configs['reply_to']);
        }

        if (is_string($this->configs['to'])) {
            $message->to($this->configs['to']);
        }

        if (is_string($this->configs['cc'])) {
            $message->cc($this->configs['cc']);
        }

        if (is_string($this->configs['bcc'])) {
            $message->bcc($this->configs['bcc']);
        }
    }
}
