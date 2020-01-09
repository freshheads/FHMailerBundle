Installation
------------

Install with composer:

```bash
composer require freshheads/mailer-bundle
```

### Register the bundle

```php
// config/bundles.php
return [
    // ...
    FH\Bundle\MailerBundle\FHMailerBundle::class => [ 'all' => true ]
];
```

Now the bundle is ready to be [used](usage.md)!
