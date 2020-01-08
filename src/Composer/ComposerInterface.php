<?php
declare(strict_types=1);

namespace FH\Bundle\MailerBundle\Composer;

use Symfony\Component\Mime\Email;

interface ComposerInterface
{
    public function compose(array $context = [], Email $message = null): Email;
}
