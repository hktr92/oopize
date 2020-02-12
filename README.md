## The OOPize project

This project is about making PHP more OOP-friendly place.

Imagine this: you're developing an enterprise application with Symfony and everything looks fancy and stuff...

...until you have to use `explode()` to split a string by a delimiter. Or to boilerplate your code with checks if a JSON is parsed without errors (ante-PHP 7.3). Or to make sure a string is not empty.

PHP by default does not provide OOP support for scalar types, so you won't be able to do `$var = "foo"; $var->empty();` to soon (even if there [there is an RFC about this](https://wiki.php.net/rfc/class-like_primitive_types)).

## Structure
Inside `Util` directory, there are defined various functionality. The implementation vary, as it can be either partially or fully static methods.

For example, `StringUtil` has fully static, while `ArrayUtil` is partially static (as you can use `$foo = new ArrayUtil;`)

Inside `Traits` directory, you'll have traits that is targeted for class usage.

E.g. instead of calling `ClassUtil::callGetter($this, 'foo');` you can call `$this->callGetter('foo');`.

