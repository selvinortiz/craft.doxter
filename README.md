![Doxter](resources/img/doxter.png)

## Doxter 0.5.6
*by* [Selvin Ortiz](http://twitter.com/selvinortiz)

----
### Download Notes
You must download the [latest release](https://github.com/selvinortiz/craft.doxter/releases) with the following name pattern `doxter.v*.*.*.zip`

The official release is the only distribution meant for production and it is required when requesting support or reporting a bug.

----
### Description
_Doxter_ is a **markdown** plugin designed to improve your workflow for writing _docs_.

### Features
* Built on top of [Parsedown](https://github.com/erusev/parsedown) _by_ **Emanuil Rusev**
* Enables you to **write markdown** in a simple text area with **editor behavior** enabled
* Parses your **fenced code blocks** in a very intelligent way and sets them up for proper highlighting
* Lets you focus on writing markdown and see it using **Live Preview**
* Lets you parse markdown intelligently with the **doxter** filter and the **doxter(source, params)** function
* You can have as many _doxter markdown_ **field type instances** as you want within a single entry type
* You can event have multiple _doxter markdown_ field types within a **Matrix** field type
* Gives you full control over the parsing output via the **syntaxSnippet** setting and parameter
* Fully compatible with [Scrawl](https://github.com/builtbysplash/craft-scrawl) and **Plain Text** field types

### Minimum Requirements
- PHP 5.3.2
- Craft 1.3

### Installation
1. Download the [latest release](https://github.com/selvinortiz/craft.doxter/releases) with the following name pattern `doxter.v*.*.*.zip`
2. Extract the archive and place `doxter` inside your `craft/plugins` directory
3. Adjust file permissions as necessary
4. Install **Doxter** from the **Control Panel**
5. Set up your **Syntaxt Snippet** via the plugin settings to wrap your code blocks

----
### Usage
You can use the **Doxter Markdown** field type in the same way you would use a **Rich Text** field type or [Scrawl](https://github.com/builtbysplash/craft-scrawl)

Using the **Doxter Markdown** field type is not required because the **doxter** filter/function doesn't care where it comes from as long as it is valid markdown;)
That means that you can use **Scrawl Markdown** or a **Plain Text** field type to write/store your markdown and **doxter** will parse it.

### Changelog

----
#### 0.5.6
* Adds support for the `parseRefs` filter returned value
* Adds flexibility by allowing empty and non empty string, and objects
* Fixes issue #6 where objects that implement `__toString` were ignored

----
#### 0.5.5
* Adds the ability to handle empty fields safely @see issue #5
* Fixes issue #5 by patching infinite loop triggered by an empty string
* Improves the doxter filter/function by only processing non empty strings

----
#### 0.5.4 RC1
* Adds build automation to aid in distribution
* Removes **Markdown Extra** and adds **Parsedown**
* Removes the use of `devMode` to embed resources
* Improves parsing performance and consistency
* Fixes a few rendering issues related to JS event binding
* Fixes many styling issues related to name collision in CSS

#### 0.5.3
Merged with 0.5.4 RC1, see above!

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

### Credits
_Doxter_ was lovingly **crafted** using these third party tools, special thanks to their developers and maintainers.

- [Parsedown](http://parsedown.org "The Better Markdown Parser in PHP") for fast and consistent markdown parsing
- [Behave JS](http://jakiestfu.github.io/Behave.js "Editor Behavior") to add editor behavior features in our simple textbox

A special thanks goes to my loyal followers and crafters that have helped me test and improve **Doxter** and provided me with useful feedback!

### Licence
**Doxter** is open source software licensed under the [MIT License](http://opensource.org/licenses/MIT)

![Open Source Initiative](resources/img/osilogo.png)
