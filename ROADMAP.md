## Roadmap

v0.x:
- oopize everything that is most used

v1.x:
- improve `StringUtil` to behave like `ArrayUtil`
- break classes into traits e.g. `CtypeUtil` -> `CtypeUtilTrait`; `CtypeUtil::isDigit('text')` -> `(new StringUtil('text'))->isDigit();`
