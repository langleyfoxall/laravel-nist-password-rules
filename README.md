# 🔒 Laravel NIST Password Rules

[![Build Status](https://travis-ci.org/langleyfoxall/laravel-nist-password-rules.svg?branch=master)](https://travis-ci.org/langleyfoxall/laravel-nist-password-rules)
[![Coverage Status](https://coveralls.io/repos/github/langleyfoxall/laravel-nist-password-rules/badge.svg?branch=master)](https://coveralls.io/github/langleyfoxall/laravel-nist-password-rules?branch=master)
[![StyleCI](https://github.styleci.io/repos/154853082/shield?branch=master)](https://github.styleci.io/repos/154853082)
[![Packagist](https://img.shields.io/packagist/dt/langleyfoxall/laravel-nist-password-rules.svg)](https://packagist.org/packages/langleyfoxall/laravel-nist-password-rules/stats)

This package provides Laravel validation rules that follow the password related
recommendations found in [NIST Special Publication 800-63B section 5](https://pages.nist.gov/800-63-3/sp800-63b.html#sec5). 

Laravel NIST Password Rules implements the following recommendations.

| Recommendation  | Implementation  |
|---|---|
| [...] at least 8 characters in length | A standard validation rule in all rule sets to validate against this minimum length of 8 characters. |
| Passwords obtained from previous breach corpuses | The `BreachedPasswords` rule securely checks the password against previous 3rd party data breaches, using the [Have I Been Pwned - Pwned Passwords](https://haveibeenpwned.com/Passwords) API. |  
| Dictionary words | The `DictionaryWords` rule checks the password against a list of over 102k dictionary words. | 
| Context-specific words, such as the name of the service, the username | The `ContextSpecificWords` rule checks the password does not contain the provided username, and any words defined the configured app name or app URL. |
| Context-specific words, [...] and derivatives thereof | The `DerivativesOfContextSpecificWords` rule checks the password is not too similar to the provided username, and any words defined the configured app name or app URL. |
| Repetitive or sequential characters (e.g. ‘aaaaaa’, ‘1234abcd’) | The `RepetitiveCharacters` and `SequentialCharacters` rules checks if the password consists of only repetitive or sequential characters. |

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

Optionally, you may publish the package's translation files with
the following Artisan command.
 
```bash
php artisan vendor:publish --provider="LangleyFoxall\LaravelNISTPasswordRules\ServiceProvider"
```
 

## Usage

To use the Laravel NIST Password Rules in your project, first `use` the 
`PasswordRules` class, then call the appropriate static methods to return
an array of appropriate validation rules. There are methods available for 
the following scenerios.

* Register
* Change password, with old password
* Change password, without old password
* Optionally change password, with old password
* Optionally change password, without old password
* Login

See the code below for example usage syntax.

```php
use LangleyFoxall\LaravelNISTPasswordRules\PasswordRules;

// Register
$this->validate($request, [
    'email' => 'required',
    'password' => PasswordRules::register($request->email),
]);

// Change password, with old password
$this->validate($request, [
    'old_password' => 'required',
    'password' => PasswordRules::changePassword($request->email, 'old_password'),
]);

// Change password, without old password
$this->validate($request, [
    'password' => PasswordRules::changePassword($request->email),
]);

// Optionally change password, with old password
$this->validate($request, [
    'old_password' => 'required',
    'password' => PasswordRules::optionallyChangePassword($request->email, 'old_password'),
]);

// Optionally change password, without old password
$this->validate($request, [
    'password' => PasswordRules::optionallyChangePassword($request->email),
]);

// Login
$this->validate($request, [
    'email' => 'required',
    'password' => PasswordRules::login(),
]);
```

The `optionallyChangePassword` method supplies validation rules that are
appropriate for forms in which the password can be optionally changed if 
filled in.
