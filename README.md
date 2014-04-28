#Smarty custom plugins

This is Smarty custom plugins.

## Table of Contents
[1. Requirements](#1-requirements)  
[2. Installation](#2-installation)  
[3. Uninstallation](#3-uninstallation)  
[4. Usage](#4-usage)  
[5. Development](#5-development)  
[6. References](#6-references)  
[7. Acknowledgements](#7-acknowledgements)  
[8. Copyright &amp; License](#8-copyright--license)

## 1. Requirements
* Smarty custom plugins 2.x: PHP 5.3+, Smarty 3+
* Smarty custom plugins 1.x: PHP 4 or 5, Smarty 2+

## 2. Installation
1. Download Smarty custom plugins.
2. Copy plugin files to the plugins directory of Smarty.

## 3. Uninstallation
1. Delete plugin files from the plugins directory of Smarty.

## 4. Usage
### add_suffix
Returns the path with specified suffix before extension.  
```php
    {$path|add_suffix:'_s'}
```

### escape_json
Returns the string contain escaped json special characters.  
```php
    {$string|escape_json}
```

### filesize
Returns the size of the file with specified unit conversion.  
```php
    {$path|filesize:'kB':2}
```

### mail2link
Returns HTML string contain automatically linked emails.  
```php
    {$string|mail2link}
```

### nl2br
Returns HTML string contain automatically inserted br tags.  
```php
    {$string|nl2br}
```

### unescape_tag
Returns HTML string contain specified unescape tags.  
```php
    {$string|unescape_tag:'a,b,strong'}
```

### url2link
Returns HTML string contain automatically linked URLs.  
```php
    {$string|url2link}
```

## 5. Development
* Source hosted at [GitHub](https://github.com/kaorinstar/smarty-custom-plugins)
* Report issues, questions, feature requests on [GitHub Issues](https://github.com/kaorinstar/smarty-custom-plugins/issues)

## 6. References
* OHZAKI Hiroki. [Perl memo](http://www.din.or.jp/~ohzaki/perl.htm).

## 7. Acknowledgements
Special thanks to bloggers who inspired.

## 8. Copyright &amp; License
Copyright &copy; 2014 Kaoru Ishikura.  
Released under the [LGPL Version 2.1 license](https://github.com/kaorinstar/smarty-custom-plugins/blob/master/LICENSE).
