# Laravel NIST Password Rules

[![Build Status](https://travis-ci.org/langleyfoxall/laravel-nist-password-rules.svg?branch=master)](https://travis-ci.org/langleyfoxall/laravel-nist-password-rules)
[![Coverage Status](https://coveralls.io/repos/github/langleyfoxall/laravel-nist-password-rules/badge.svg?branch=master)](https://coveralls.io/github/langleyfoxall/laravel-nist-password-rules?branch=master)
[![StyleCI](https://github.styleci.io/repos/154853082/shield?branch=master)](https://github.styleci.io/repos/154853082)
[![Packagist](https://img.shields.io/packagist/dt/langleyfoxall/laravel-nist-password-rules.svg)](https://packagist.org/packages/langleyfoxall/laravel-nist-password-rules/stats)

This package provides Laravel validation rules that follow the password related
recommendations found in [NIST Special Publication 800-63B section 5](https://pages.nist.gov/800-63-3/sp800-63b.html#sec5).

It also provides methods to return validation rules arrays for various 
scenarios, such as register, login, and password changes. These arrays can
be passed directly into the Laravel validator. 

## Installation

Laravel NIST Password Rules can be easily installed using Composer. Just run the following 
command from the root of your project.

```bash
composer require langleyfoxall/laravel-nist-password-rules
```

If you have never used the Composer dependency manager before, head to the Composer website 
for more information on how to get started.

## Usage

To use the Laravel NIST Password Rules in your project, first `use` the 
`PasswordRules` class, then call the appropriate static methods to return
an array of appropriate validation rules. There are methods available for 
the following scenerios.

* Register
* Change Password
* Login

See the code below for example usage syntax.

```php
use LangleyFoxall\LaravelNISTPasswordRules\PasswordRules;

// Register
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
