![Doxter](resources/img/doxter.png)

## Doxter 0.5.2
*by* [Selvin Ortiz](http://twitter.com/selvinortiz)

----
### Description
_Doxter_ is a **markdown** plugin designed to improve your workflow for writing _docs_.

### Features
* Extends [PHP Markdown](https://github.com/michelf/php-markdown) _by_ **Michel Fortin**
* Parses _extended_ **markdown** with `"markdown" | doxter ` and `doxter("markdown", params)`
* Parses **github** style _fenced code blocks_ with language class assignment
* Gives you full control over the parsing output via the **syntaxSnippet** _setting/parameter_
* Enables a **Doxter Markdown** fieldtype which is a simple **textarea** with full editor behaviour and preview mode
* Supports multiple **Doxter Markdown** instances within sections and **Matrix Fields**
* Uses a _tabbed_ UI to toggle **Write/Preview** modes
* Fully compatible with [Scrawl](https://github.com/builtbysplash/craft-scrawl) and **Plain Text** fields

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
You can use the **Doxter Markdown** fieldtype in the same way you use [Scrawl](https://github.com/builtbysplash/craft-scrawl)
though you don't have to because **Doxter** will parse pretty much any **markdown** with the `doxter` filter/function.

That means that you can use **Scrawl Markdown** or a **Plain Text** field to write/store your markdown and **doxter** will parse it.

### Example

```twig
{{ "My **markdown** is well written!" | doxter }}
```

### Notes
**Doxter** is fully compatible with [Scrawl](https://github.com/builtbysplash/craft-scrawl)
so if that's what you use to write your _docs_, adding syntax highlighting to your code blocks via a javascript library like
[RainbowJS](https://github.com/ccampbell/rainbow) will be a piece of cake: )

### Changelog

----
#### 0.5.2
* Adds support for **Matrix**
* Fixes a few rendering issues related to JS
* Fixes many styling issues related to CSS

#### 0.5.1
* Adds support for multiple instances of **Doxter Markdown** within a single entry type
* Improves button styling for **write/preview** modes

#### 0.5.0
* Adds _tabbed_ UI for **write/preview** modes
* Fixes path issues with production resources
* Fixes word wrap, white space, and tab size issues  @ #1
* Improves the speed of `getDevMode()` by avoiding system call
* Improves template rendering speed by removing the form macro

#### 0.4.0
* Adds a **Doxter Markdown** fieldtype
* Adds test suite skeleton to flesh out on **1.0.0**
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
