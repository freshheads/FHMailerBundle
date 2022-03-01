<?php

declare(strict_types=1);

namespace FH\Bundle\MailerBundle\Composer;

use FH\Bundle\MailerBundle\Email\MessageOptions;
use FH\Bundle\MailerBundle\Email\Participants;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Email;

final class ApplyEmailMessageOptions
{
    public function apply(Email $email, MessageOptions $messageOptions): void
    {
        $this->applyParticipants($email, $messageOptions->getParticipants());

        if ($messageOptions->hasSubject()) {
            $email->subject((string) $messageOptions->getSubject());
        }
    }

    private function applyParticipants(Email $email, Participants $participants): void
    {
        if (($sender = $participants->getSender()) instanceof Address) {
            $email->sender($sender);
        }

        if ($participants->hasFrom()) {
            $email->from(...$participants->getFrom());
        }

        if ($participants->hasReplyTo()) {
            $email->replyTo(...$participants->getReplyTo());
        }

        if ($participants->hasTo()) {
            $email->to(...$participants->getTo());
        }

        if ($participants->hasCc()) {
            $email->cc(...$participants->getCc());
        }

        if ($participants->hasBcc()) {
            $email->bcc(...$participants->getBcc());
        }
    }
}
