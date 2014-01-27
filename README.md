![Doxter](resources/img/doxter.png)


## Doxter 0.4.0
*by* [Selvin Ortiz](http://twitter.com/selvinortiz)

 ----
### Description
_Doxter_ is a **markdown** plugin designed to improve the workflow for writing _docs_.

### Features
* Extends [PHP Markdown](https://github.com/michelf/php-markdown) _by_ **Michel Fortin**
* Lets you parse **markdown** with the **doxter** filter/function
* Lets you parse **github** style _fenced code blocks_
* Fully compatible with [Scrawl]([Scrawl](https://github.com/builtbysplash/craft-scrawl) and **Plain Text** fields
* Gives you a **Doxter Markdown** fieldtype featuring a simple **textarea** with full editor behaviour
* Gives you full control of parsing output via the **syntaxSnippet** setting/parameter
* Simply use it as a replacement for the `markdown filer` in **twig**

### Minimum Requirements
- PHP 5.3.2
- Craft 1.3

### Installation
1. Download the [latest release](https://github.com/selvinortiz/craft.doxter/releases) with the following name pattern `doxter.v*.*.*.zip`
2. Extract the archive and place `doxter` inside your `craft/plugins` directory
3. Adjust file permissions as necessary
4. Install **Doxter** from the **Control Panel**
5. Set up your **Syntaxt Snippet** via the plugin settings to wrap your code blocks in

----

### Usage
You can use **doxter** to parse _markdown_ from a `string` and/or inside **Doxter Markdown**, **Scrawl**, **Plain Text** fields.

### Notes
**Doxter** is fully compatible with [Scrawl](https://github.com/builtbysplash/craft-scrawl)
so if that's what you use to write your _docs_, adding syntax highlighting to your code blocks via a javascript library like
[RainbowJS](https://github.com/ccampbell/rainbow) will be a piece of cake: )

### Changelog

----
#### 0.4.0
* Adds a **Doxter Markdown** fieldtype
* Adds test suite skeleton to flesh out on **0.5.0**
* Adds uncommitted **build** directory to manage distributions

#### 0.3.0
Initial preview release

* Adds the ability to parse **markdown**
* Adds the ability to parse **github** style _fenced code blocks_

### Help & Feedback
If you have questions, comments, or concerns feel free to reach out to me on twitter [@selvinortiz](http://twitter.com/selvinortiz)

### Licence
**Doxter** is open source software licensed under the [MIT License](http://opensource.org/licenses/MIT)

![Open Source Initiative](resources/img/osilogo.png)
