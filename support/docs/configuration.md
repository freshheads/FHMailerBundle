Full configuration
-------------
This bundle contains a plain SMTP transport factory for the Symfony Mailer component, [take a look at the transport documentation](transport.md).
For the 'how to send a email' [go to the usage documentation](usage.md).

```
fh_mailer:
    # All available options for templated emails
    templated_email:
        consumer_welcome:
            html_template: 'email/consumer_welcome.html.twig'
            text_template: 'email/consumer_welcome.txt.twig'
            subject: 'Tilburg, je bent er.'
            participants:
                sender: { address: 'freshheads@example.com', name: 'Freshheads' }
                from:
                    - { address: 'kevin@example.com', name: 'Kevin' }
                reply_to:
                    - { address: 'freshheads@example.com', name: 'Freshheads' }
                to:
                    - { address: 'misha@example.com', name: 'Misha' }
                cc:
                    - { address: 'joris@example.com', name: 'Joris' }
                bcc:
                    - { address: 'bart@example.com', name: 'Bart' }
    
    # All available options for regular emails
    email:
        consumer_welcome:
            subject: 'Tilburg, je bent er.'
            participants:
                sender: { address: 'freshheads@example.com', name: 'Freshheads' }
                from:
                    - { address: 'kevin@example.com', name: 'Kevin' }
                reply_to:
                    - { address: 'freshheads@example.com', name: 'Freshheads' }
                to:
                    - { address: 'misha@example.com', name: 'Misha' }
                cc:
                    - { address: 'joris@example.com', name: 'Joris' }
                bcc:
                    - { address: 'bart@example.com', name: 'Bart' }
```
