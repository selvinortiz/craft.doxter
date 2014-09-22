# Doxter

Lovingly crafted by [Selvin Ortiz][developer] for [Craft CMS][craft]

## Changes

### 1.0.3
* Introduces a complete rewrite of the core and updated editor
* Adds support for `ParsedownExtra`
* Adds the powerful Ace Editor

### 0.6.2
* Fixes typos in the settings page
* Updates grammar in settings page

### 0.6.1
* Fixes an issue caused by `iconv()` not being defined in some environments
* Fixes some deprecation issues and spacing
* Improves **header parsing** by generating slugs the _craft way_
* Improves dependency management

### 0.6.0
* Adds the `HeaderParser` class
* Adds the `ReferenceTagParser` class
* Adds the [Zit][zit] dependency container
* Adds [reference tag][refTags] parsing support
* Adds a [reference tag][refTags] toolbar to the **editor**
* Adds **header** parsing support to dynamically add **anchors**
* Adds the ability to choose what headers to add anchors to
* Adds a **test suite** with solid coverage
* Fixes parsing issue with markdown table adjacent to lists
* Fixes settings issue #7 where `enableWordWrap` did not stick
* Improves [GFM][gfm] parsing when processing large amount of data
* Improves documentation available in the [readme][readme]

### 0.5.6
* Adds support for the `parseRefs` filter returned value
* Adds flexibility by allowing empty and non empty string, and objects
* Fixes issue #6 where objects that implement `__toString` were ignored

### 0.5.5
* Adds the ability to handle empty fields safely @see issue #5
* Fixes issue #5 by patching infinite loop triggered by an empty string
* Improves the doxter filter/function by only processing non empty strings

### 0.5.4 RC1
* Adds build automation to aid in distribution
* Removes **Markdown Extra** and adds **Parsedown**
* Removes the use of `devMode` to embed resources
* Improves parsing performance and consistency
* Fixes a few rendering issues related to JS event binding
* Fixes many styling issues related to name collision in CSS

### 0.5.3
Merged with 0.5.4 RC1, see above!

### 0.5.2
* Adds support for **Matrix**
* Fixes a few rendering issues related to JS
* Fixes many styling issues related to CSS

### 0.5.1
* Adds support for multiple instances of **Doxter Markdown** within a single entry type
* Improves button styling for **write/preview** modes

### 0.5.0
* Adds _tabbed_ UI for **write/preview** modes
* Fixes path issues with production resources
* Fixes word wrap, white space, and tab size issues  @ #1
* Improves the speed of `getDevMode()` by avoiding system call
* Improves template rendering speed by removing the form macro

### 0.4.0
* Adds a **Doxter Markdown** fieldtype
* Adds test suite skeleton to flesh out on **1.0.0**
* Adds uncommitted **build** directory to manage distributions

### 0.3.0
Initial preview release

* Adds the ability to parse **markdown**
* Adds the ability to parse **github** style _fenced code blocks_

[craft]:http://buildwithcraft.com "Craft CMS"
[developer]:http://twitter.com/selvinortiz "@selvinortiz"
[readme]:https://github.com/selvinortiz/craft.doxter/blob/master/README.md "The Readme"
[refTags]:http://buildwithcraft.com/docs/reference-tags "Reference Tags"
[gfm]: https://help.github.com/articles/github-flavored-markdown "Github Flavored Markdown"
[zit]:https://github.com/selvinortiz/zit "Zit"
