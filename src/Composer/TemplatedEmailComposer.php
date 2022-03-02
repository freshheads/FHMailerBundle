<?php

declare(strict_types=1);

namespace FH\Bundle\MailerBundle\Composer;

use FH\Bundle\MailerBundle\Email\MessageOptions;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\Exception\InvalidArgumentException;
use Symfony\Component\Mime\Email;

final class TemplatedEmailComposer implements ComposerInterface
{
    private MessageOptions $messageOptions;

    public function __construct(MessageOptions $messageOptions)
    {
        $this->messageOptions = $messageOptions;
    }

    /**
     * @return TemplatedEmail
     */
    public function compose(array $context = [], Email $message = null): Email
    {
        $message ??= new TemplatedEmail();
        if (!$message instanceof TemplatedEmail) {
            throw new InvalidArgumentException(sprintf('Expected instance of %s, instance of %s given', TemplatedEmail::class, \get_class($message)));
        }

        (new ApplyEmailMessageOptions())->apply($message, $this->messageOptions);
        $this->applyTemplates($context, $message);

        return $message;
    }

    private function applyTemplates(array $context, TemplatedEmail $message): void
    {
        $message->context($context);

        if ($this->messageOptions->hasHtmlTemplate()) {
            $message->htmlTemplate($this->messageOptions->getHtmlTemplate());
        }

        if ($this->messageOptions->hasTextTemplate()) {
            $message->textTemplate($this->messageOptions->getTextTemplate());
        }
    }
}
