Usage
------------
Just like the Symfony mailer component we both support (twig) templated emails en plain email.

# Templated emails
For templated emails you use the `TemplatedEmailComposer`.

```
fh_mailer:
    templated_email:
        consumer_welcome:
            html_template: 'email/consumer_welcome.html.twig'
            subject: 'Tilburg, je bent er.'

services:
    App\Email\WelcomeEmail:
        $composer: '@fh_mailer.composer.templated_email.consumer_welcome'
```

```
namespace App\Email\WelcomeEmail;

use FH\Bundle\MailerBundle\Composer\TemplatedEmailComposer;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;

final class WelcomeEmail
{
    private $composer;
    private $mailer;

    public function __construct(TemplatedEmailComposer $composer, MailerInterface $mailer)
    {
        $this->composer = $composer;
        $this->mailer = $mailer;
    }

    public function send(Consumer $consumer): void
    {
        /** @var TemplatedEmail $templatedEmail */
        $templatedEmail = $this->composer->compose([
            'consumer' => $consumer
        ]);
        $this->mailer->send($templatedEmail);
    }
}
```

# Email without a template
For this we use the regular `EmailComposer`.

```
fh_mailer:
    email:
        consumer_welcome:
            subject: 'Tilburg, je bent er.'

services:
    App\Email\WelcomeEmail:
        $composer: '@fh_mailer.composer.email.consumer_welcome'
```

```
namespace App\Email\WelcomeEmail;

use FH\Bundle\MailerBundle\Composer\EmailComposer;
use Symfony\Component\Mailer\MailerInterface;

final class WelcomeEmail
{
    private $composer;
    private $mailer;

    public function __construct(EmailComposer $composer, MailerInterface $mailer)
    {
        $this->composer = $composer;
        $this->mailer = $mailer;
    }

    public function send(Consumer $consumer): void
    {
        $email = $this->templatedComposer->compose([
            'consumer' => $consumer
        ]);
        $this->mailer->send($email);
    }
}
```

All available configuration options can found [here](configuration.md).
