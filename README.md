# musti

There is currently a live demo available at : http://musti.keepthis4.me

## Database

Make sure you replace the credentials in `init.php` with yours, so queries can work.

```php
$link = mysqli_connect('host', 'username', 'passsword', 'database');
```
or
```php
$host = 'host';
$username = 'username';
$password = 'password';
$database = 'database';
$link = mysqli_connect($host, $username, $password, $database);
```

## Users
New users will have their directory named after their username in the directory `users`.

```
users/
├── .htaccess
└── johndoe
    ├── corgi.jpg
    └── Sujet_Filer.pdf
```

To try the platform, you can log in with the following credentials :

username : `johndoe`

password : `corgibutt`


Otherwise, you can simply create a new account by registering.

## Directories access
in the directory `users/` there is a `.htaccess` (Apache) that will prevent any user, logged in or not to download or display in the browser any file that doesn't belong to him. It will return a 403 Forbiden error instead.

## Password resetting with mail
Passwords can be reset thanks to the library Phpmailer. You shouldn't have to install it, as I inserted everything required in this repository. However, if you need to install it, do it at the root of the repository by using the command `composer require phpmailer/phpmailer`

Edit your credentials in the lostpassword.php file to put yours, so it will work with your email address. Otherwise, it should work with mine for the moment.
