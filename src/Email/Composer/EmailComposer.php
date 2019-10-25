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
        $participants = $this->configs['participants'];

        dd($participants);

        if (is_string($participants['sender'])) {
            $message->sender($participants['sender']);
        }

        if (is_string($participants['from'])) {
            $message->from($participants['from']);
        }

        if (is_string($participants['reply_to'])) {
            $message->replyTo($participants['reply_to']);
        }

        if (is_string($participants['to'])) {
            $message->to($participants['to']);
        }

        if (is_string($participants['cc'])) {
            $message->cc($participants['cc']);
        }

        if (is_string($participants['bcc'])) {
            $message->bcc($participants['bcc']);
        }
    }
}
