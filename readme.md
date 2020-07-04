# docker-mailer
Docker container that allows you do send emails using REST API


## Templates
Define your template in `./www/templates`.It should have a `.php` extention, example `template1.php` You can also pass variables with values to the template.
To desplay them in the template you should use php `<?php echo $value;?>`

## Config

```sh
- TOKEN=123123123
- MAIL_HOST=SMTPHOST
- MAIL_PORT=SMTPPORT
- MAIL_USERNAME=info@example.com
- MAIL_PASSWORD=MYEMAILPASSWORD
- MAIL_FROM_NAME=Team Name
- MAIL_REPLY_ADRESS=no-reply@example.com
```

### SMTP examples hosts
#### Gmail
- smtp.gmail.com  587
#### Outlook
- smtp.office365.com  587
#### Namecheap private e-mail
- mail.privateemail.com  587

## Demo
```sh
$ curl -X POST http://127.0.0.1:8080/api/v1/mail?token=123123123 --data '{"email":"myemail@example.com","title":"Welcome to docker-mailer!","template":"notification_template","options":{"value":"SomeValue","value2":"AnotherValue"}}'
```

