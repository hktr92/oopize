## The OOPize project

This project is about making PHP more OOP-friendly place.

Imagine this: you're developing an enterprise application with Symfony and everything looks fancy and stuff...

...until you have to use `explode()` to split a string by a delimiter. Or to boilerplate your code with checks if a JSON 
is parsed without errors (ante-PHP 7.3). Or to make sure a string is not empty.

PHP by default does not provide OOP support for scalar types, so you won't be able to do `$var = "foo"; $var->empty();` 
to soon (even if there [there is an RFC about this](https://wiki.php.net/rfc/class-like_primitive_types)).

## About stability
Given it's early stage, it's difficult to maintain versions. The initial idea was:
- 0.x.y version is to represent API version. When this lib will be mostly completed, 1.x.y will be released with major 
improvements, stability and more secure.
- x.0.y version is to represent feature class, e.g. 0.1.0 - StringUtil, 0.2.0 - added ClassUtil, etc.
- x.y.0 version is to represent feature class improvements, e.g. 0.1.1 - StringUtil fixes, 0.2.1 - ClassUtil new feature

But this is absurd to have. Sure, latest version should always have latest version from every util class. But the oldest 
will always be the more mature one.

And increasing the version tag after EACH commit is insanely difficult to maintain and manually do.

Given this, I recommend to always use `dev-master`, as it is always the latest version and contains the latest 
features and fixes.
No, I won't BC stuff, `v1.0.0` is happening on another branch and `php-ext-oopize` is happening on another repo. (Yes, I 
started to rewrite these features in [zephir](https://github.com/phalcon/zephir).)

And this happens because of two things:
1. this is how this project came to life (`StringUtil`, `NumberUtil` and `ClassUtil` were written for one of my project)
2. this is how and why I maintain, extend and improve this project.
  

## Structure
Inside `Util` directory, there are defined various functionality. The implementation vary, as it can be either partially 
or fully static methods.

For example, `StringUtil` has fully static, while `ArrayUtil` is 
partially static (as you can use `$foo = new ArrayUtil;`)

Inside `Traits` directory, you'll have traits that is targeted for class usage.

E.g. instead of calling `ClassUtil::callGetter($this, 'foo');` you can call `$this->callGetter('foo');`.

## PHP Extension
As mentioned earlier, I've started to play around with Zephir. This means that this library will be available as 
a PHP extension (in order to better handle memory consumption), but a PHP polyfill will be released too, based on 
generated IDE stubs.
