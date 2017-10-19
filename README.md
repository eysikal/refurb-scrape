# refurb-scrape
This script is intended to be run at a recurring interval via a cronjob.

The script takes an array of products (products.php) and checks for an active "add to cart" button on the product page. If an active button is found, an alert with a link to the product is sent to the email address in the email.php file. 

Be sure to run ```composer install``` to install dependencies.

## Notes

```scrape.php``` is the entry point to the script and is the file your cronjob should run. 

```email.php``` is not commited to the repository for privacy's sake. Your email.php should look like the following:
```php
<?php
return 'email@example.com';
```

Depending on the mail setup of your server, you may have issues with email alerts getting caught in spam filters. I get around this problem in Gmail by setting a filter for messages sent from my server and selecting the option to "Never send it to Spam." You also might consider sending the alert to your phone as a text message by forwarding the email to your phone provider's SMS gateway:

AT&T [insert 10-digit number]@mms.att.net
Sprint [insert 10-digit number]@pm.sprint.com
T-Mobile [insert 10-digit number]@tmomail.net
Verizon [insert 10-digit number]@vzwpix.com
