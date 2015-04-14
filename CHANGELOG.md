# Doxter

Lovingly crafted by [Selvin Ortiz][developer] for [Craft CMS][craft]

## Changes

### 1.1.0
Public release with updated license and docs

* Adds the `updates` shortcode for elegant styling of update notes
* Adds responsive `image` and fluid video `vimeo|youtube` shortcodes
* Adds the ability to place the toolbar at the top, bottom or both #15
* Improves default shortcodes with the ability to provide custom templates
* Improves parsing by triggering events before each parsing routine
* Removes all traces of ace editor which proved inconsistent
* Updates license, docs, and changelog

### 1.0.9
Lots of refactoring but remains backwards compatible.

* Adds a dedicated DoxterMarkdownParser for further abstraction
* Adds support for a raw parameter for all shortcodes to use if verbatim
* Adds a new addTypographyStyles setting to let Doxter typogrify content
* Updates to the latest stable version of Parsedown and ParsedownExtra
* Updates the fitvids.js lib for vimeo|youtube shortcode
* Updates DoxterModel::__toString() to return the source markdown/text
* Updates field type name/lable from Doxter Markdown to Doxter
* Updates tests to target the recent updates

### 1.0.8
* Adds support for defining a custom starting header level #13
* Adds a new startingHeaderLevel setting
* Adds a new parseShortcodes setting
* Updates settings UI with cleaner field definitions
* Fixes version number behind in plugin class
* Removes the need for the parseReferenceTagsRecursively setting

### 1.0.7
* Adds shortcodes via `doxter.beforeShortcodeParsing` event for optimal loading
* Adds better return type hinting on DoxterBaseParser::instance()
* Adds doxter()->registerShortcode() and doxter()->registerShortcodes()
* Adds support for attributes w/o values in shortcode definition
* Adds the ability to modify or skip all parsing via event.performAction
* Adds a complete set of events to allow hooking into before parsing
* Improves the way shortcodes are registered with Doxter
* Improves video shortcode by allowing title and byline to be used for vimeo
* Improves the doxter filter by returning RichTextData if necessary
* Remove DoxterShortcodeParser::init() when made unnecessary

### 1.0.6
* Adds DoxterShortcodeParser
* Adds DoxterShortcodeModel
* Adds the ability to use and register shortcodes
* Adds initial implementation of custom shortcodes
* Adds the ability to render plugin templates if site request
* Updates version number in plugin to 1.0.6
* Updates developer URL to user the HTTPS version
* Updates import statements to avoid wildcard slowness

### 1.0.5
* Fixes asset selector modal
* Updates DoxterModel to return html from its __toString method

### 1.0.4
* Adds support for parsing globals by handle
* Improves recursive parsing of md with reftags

### 1.0.3
* Fixes issue where editor undo/redo behavior was unstable
* Improves doxter with a complete rewrite of the core
* Improves the editor by replacing the simple field with Ace Editor
* Adds support for `ParsedownExtra`

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
