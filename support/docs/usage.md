Usage
------------

```
// WelcomeEmail.php

namespace App\Email\WelcomeEmail;

use FH\Bundle\MailerBundle\Composer\TemplatedEmailComposer;
use FH\Bundle\MailerBundle\Composer\EmailComposer;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;

final class WelcomeEmail
{
    private $templatedComposer;
    private $composer;
    private $mailer;

    public function __construct(TemplatedEmailComposer $templatedComposer, EmailComposer $composer, MailerInterface $mailer)
    {
        $this->templatedComposer = $templatedComposer;
        $this->composer = $composer;
        $this->mailer = $mailer;
    }

    public function send(Consumer $consumer): void
    {
        /** @var TemplatedEmail $templatedEmail */
        $templatedEmail = $this->templatedComposer->compose([
            'consumer' => $consumer
        ]);
        $this->mailer->send($templatedEmail);

        /** @var Email $email */
        $email = $this->templatedComposer->compose([
            'consumer' => $consumer
        ]);
        $this->mailer->send($email);
    }
}
```

```
// config/services.yaml

services:
    App\Email\WelcomeEmail:
        $templatedComposer: '@fh_mailer.composer.templated_email.consumer_welcome'
        $composer: '@fh_mailer.composer.email.consumer_welcome'
```
