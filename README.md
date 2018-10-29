# Laravel NIST Password Rules

*Work in progress*

This package provides Laravel validation rules that follow the password related
recommendations found in NIST Special Publication 800-63B sections 5.1.1.*.

It also provides methods to return validation rules arrays for various 
scenarios, such as register, login, and password changes. These arrays can
be passed directly into the Laravel validator. 

## Installation

TODO

## Usage

TODO

```php
$this->validate($request, [
    'email' => 'required',
    'password' => PasswordRules::register(),
]);

PasswordRules::register();
PasswordRules::login();
PasswordRules::changePassword();
```