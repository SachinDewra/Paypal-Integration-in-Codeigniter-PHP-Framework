Paypal Integration in Codeigniter PHP Framework

1.Get started quickly by using the Default Application credentials for testing PayPal REST APIs on the Sandbox environment. (https://developer.paypal.com/developer/applications/)

You need an Client ID and Secret Key.

Installation
------------

[Install Codeigniter 3](https://api.github.com/repos/bcit-ci/CodeIgniter/zipball/3.1.11).


A sample sql file into your database (sample.sql).

[Install paypal /Checkout-PHP-SDK](https://github.com/paypal/Checkout-PHP-SDK).


It is already placed in /application/libraries/vendor/paypal/paypal-checkout-sdk , /application/libraries/GetOrder.php and /application/libraries/PayPalClient.php

In PayPalClient.php you have to set your PayPal environment keys Client ID and Secret Key.

Environment keys have to set in /application/libraries/PayPalClient.php and in /application/views/paypal/index.php



All the payment process is start and end in "paypal" method in Welcome Controller.  

all the response coming from paypal process in /application/libraries/GetOrder.php


Authors
-------

SD.