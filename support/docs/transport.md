Custom transport
------------
The default Symfony SMTP transport is enforcing the use of TLS. If you don't want to use TLS configure our custom 'Plain SMTP Transport'.
Its very simple to do so. Just change the `smtp` in the mailer DSN to `plainsmtp`.  

```
framework:
    mailer:
        dsn: 'plainsmtp://127.0.0.1'
```
