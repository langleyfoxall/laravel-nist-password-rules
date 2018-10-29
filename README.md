# Laravel NIST Password Rules

[![StyleCI](https://github.styleci.io/repos/154853082/shield?branch=master)](https://github.styleci.io/repos/154853082)

*Work in progress*

This package provides Laravel validation rules that follow the password related
recommendations found in [NIST Special Publication 800-63B sections 5.1.1.*](https://pages.nist.gov/800-63-3/sp800-63b.html#sec5).

It also provides methods to return validation rules arrays for various 
scenarios, such as register, login, and password changes. These arrays can
be passed directly into the Laravel validator. 

## Installation

TODO

## Usage

TODO

```php
// Registration
$this->validate($request, [
    'email' => 'required',
    'password' => PasswordRules::register($request->email),
]);

// Change Password
$this->validate($request, [
    'old_password' => 'required',
    'password' => PasswordRules::changePassword($request->email, $request->old_password),
]);

// Login
$this->validate($request, [
    'email' => 'required',
    'password' => PasswordRules::login(),
]);
```
