<?php
declare(strict_types=1);

namespace FH\MailerBundle\Email\Composer;

use FH\MailerBundle\Email\MessageOptions;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\Exception\InvalidArgumentException;
use Symfony\Component\Mime\RawMessage;
use Twig\Environment;

final class TemplatedEmailComposer implements ComposerInterface
{
    private $messageOptions;
    private $composer;
    private $twig;

    public function __construct(array $messageOptions, ?ComposerInterface $composer, Environment $twig)
    {
        $this->messageOptions = MessageOptions::fromArray($messageOptions);
        $this->composer = $composer;
        $this->twig = $twig;
    }

    /**
     * @return TemplatedEmail
     */
    public function compose(array $context, RawMessage $message = null): RawMessage
    {
        $message = $message ?: new TemplatedEmail();

        if ($this->composer instanceof ComposerInterface) {
            $message = $this->composer->compose($context, $message);
        }

        if (!$message instanceof TemplatedEmail) {
            throw new InvalidArgumentException(sprintf('Expected instance of %s, instance of %s given', TemplatedEmail::class, get_class($message)));
        }

        $this->applyHtmlTemplate($context, $message);
        $this->applyTextTemplate($message);

        return $message;
    }

    private function applyHtmlTemplate(array $context, TemplatedEmail $message): void
    {
        if (!$this->messageOptions->hasHtmlTemplate()) {
            return;
        }

        $template = $this->twig->load($this->messageOptions->getHtmlTemplate());

        if ($template->hasBlock('subject')) {
            $subject = $template->renderBlock('subject', $context);
            $subject = strip_tags($subject);

            $message->subject($subject);
        }

        if ($template->hasBlock('body_text')) {
            $message->text($template->renderBlock('body_text', $context));
        }

        if ($template->hasBlock('body_html')) {
            $message->html($template->renderBlock('body_html', $context));
        }
    }

    private function applyTextTemplate(TemplatedEmail $message): void
    {
        if (!$this->messageOptions->hasTextTemplate()) {
            return;
        }

        $message->textTemplate($this->messageOptions->getTextTemplate());
    }
}
