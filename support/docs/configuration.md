Configuration
-------------
```
framework:
    mailer:
        dsn: 'plainsmtp://127.0.0.1'

fh_mailer:
    templated_email:
        consumer_welcome:
            html_template: 'email/consumer_welcome.html.twig'
            text_template: 'email/consumer_welcome.txt.twig'
            subject: 'Tilburg, je bent er.'
            participants:
                sender: [ address: 'freshheads@example.com', name: 'Freshheads' ]
                from:
                    - [ address: 'kevin@example.com', name: 'Kevin' ]
                reply_to:
                    - [ address: 'freshheads@example.com', name: 'Freshheads' ]
                to:
                    - [ address: 'misha@example.com', name: 'Misha' ]
                cc:
                    - [ address: 'joris@example.com', name: 'Joris' ]
                bcc:
                    - [ address: 'bart@example.com', name: 'Bart' ]          
```

To quote Symfony's documentation:
> Symfony's Mailer & Mime components form a powerful system for creating and sending emails - complete with support for multipart messages, Twig integration, CSS inlining, file attachments and a lot more.

Go have a look at the documentation for information on how to configure any of the mentioned features (and more!): https://symfony.com/doc/current/mailer.html

Now the bundle is ready to be [used](usage.md)!
