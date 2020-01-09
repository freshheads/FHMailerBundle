Full configuration
-------------
Need to know how to use the transport? [take a look here](transport.md).
The 'how to send a email' [can be found here](usage.md).

```
# Don't use this unles you need to, see the transport docs.
framework:
    mailer:
        dsn: 'plainsmtp://127.0.0.1'

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
