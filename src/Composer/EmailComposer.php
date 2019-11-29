<?php
declare(strict_types=1);

namespace FH\Bundle\MailerBundle\Composer;

use FH\Bundle\MailerBundle\Email\MessageOptions;
use Symfony\Component\Mime\Email;

/**
 * @TODO to implement (or delete)
 */
final class EmailComposer implements ComposerInterface
{
    private $messageOptions;

    public function __construct(MessageOptions $messageOptions)
    {
        $this->messageOptions = $messageOptions;
    }

    /**
     * @return Email
     */
    public function compose(array $context, Email $message = null): Email
    {
        $message = $message ?: new Email();

        (new ApplyEmailMessageOptions())->apply($message, $this->messageOptions);

        return $message;
    }
}
