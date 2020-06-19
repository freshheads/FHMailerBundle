Installation
------------

Install with Composer:

```bash
composer require freshheads/mailer-bundle
```

Register the bundle:

```php
// config/bundles.php
return [
    // ...
    FH\Bundle\MailerBundle\FHMailerBundle::class => [ 'all' => true ]
];
```

Configure your development or debugging environments:
* [disabling delivery](https://symfony.com/doc/current/mailer.html#disabling-delivery)
* [always send to the same address](https://symfony.com/doc/current/mailer.html#always-send-to-the-same-address)

Now the bundle is ready to be [used](usage.md)!
