# musti

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
└── johndoe
    └── corgi.jpg
```

To try the platform, you can log in with the following credentials :

username : `johndoe`

password : `corgibutt`


Otherwise, you can simply create a new account by registering.
