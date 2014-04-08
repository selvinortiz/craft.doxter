![Doxter](resources/img/doxter.png)

# Doxter 0.6.2
Lovingly crafted by [Selvin Ortiz][developer] for [Craft CMS][craft]

**Doxter** is a markdown plugin designed to improve the way you write documentation.  
It provides a simple textarea **fieldtype** with [editor behavior][behave], a toolbar for [reference tags][refTags], and [live preview][preview] support.  
It also provides a **markdown parser** that supports [github flavor markdown][gfm], [reference tags][parseRefs] with _recursive parsing_ and **linkable headers**.

## Installation
1. Download the [Official Release][release]
2. Extract the archive and place `doxter` inside your `craft/plugins` directory
4. Install **Doxter** from the Control Panel **@** `Settings > Plugins`
5. Adjust plugin settings from the Control Panel **@** `Settings > Plugins > Doxter`
6. FieldType settings can be adjusted when you create your **Doxter Markdown** fields

## Features
* [Live Preview][preview] Support
* [Github Fravored Markdown][gfm] Parsing
* Can add **header anchors** dynamically
* Fast and consistent **parsing** based on [Parsedown][parsedown]
* Minimalist **textarea** with [Editor Behavior][behave] and toolbar for [Reference Tags][refTags]
* Support for multiple fieldtypes within a single [Entry Type][entrytypes]
* Support for multiple fieldtypes within [Matrix Fields][matrix]
* Fully compatible with [Scrawl][scrawl]
* **Unit Tested** with care

## Filter Usage
Doxter adds the `doxter({})` filter that you should use instead of `md` or `markdown` and doing so
will enable features not supported by those filters like [github flavored markdown][gfm], [reference tags][parseRefs], _linkable headers_,
and custom **code block snippet**.

```twig
{% set markdown %}
    # Doxter
    **Doxter** is a markdown plugin designed to improve the way your write documentation.

    You can read more about it on our [latest article]({entry:1:getLink()})
{% endset %}

{{ markdown | doxter }}
```

The output should be something like this...

```html
<h1 id="doxter">Doxter <a class="anchor" href="#doxter" title="Doxter">#</a></h1>

<p><strong>Doxter</strong> is a markdown plugin designed to improve the way your write documentation.</p>

<p>You can read more about it on our <a href="/blog/doxter-markdown">latest post</a><p>
```

### Filter API
The `doxter` filter accepts all parameters for which there are setings.

| Parameter                 | Type          | Default               | Description                                                           |
|-----------------------    |-----------    |--------------------   |----------------------------------------------------------             |
| `parseRecursively`        | `boolean`     | `true`                | Whether markdown within [reference tags][refTags] should be parsed    |
| `parseReferenceTags`      | `boolean`     | `true`                | Whether [reference tags][refTags] should be parsed                    |
| `addHeaderAnchors`        | `boolean`     | `true`                | Whether to add anchors to headers                                     |
| `addHeadersAnchorsTo`     | `string`      | `h1, h2, h3`          | What headers to make linkable/add anchors to                          |
| `codeBlockSnippet`        | `string`      | _see snippet below_   |                                                                      |

#### Default Code Block Snippet
```html
<!-- Default snippet targets RainbowJS -->
<pre><code data-language="language-{languageClass}">{sourceCode}</code></pre>
```

## FieldType Usage
Doxter adds a `Doxter Markdown` fieldtype that you can use to write/store your markdown content.  
The fieldtype is a simple textarea with [editor behavior][behave], a toolbar for [reference tags][refTags], and [live preview][preview] support.  
In addition to that, this simple fieldtype includes settings for _rows, word wrap, tab size, convert to tabs, etc_

_Using this fieldtype is not required to be able to use the filter but future version might implement the ability to preparse and cache content_

## Changes
All noteworthy changes can be found in [CHANGELOG.md][changelog]

## Feedback
If you have any feedback, questions, or concerns, please reach out to me on twitter [@selvinortiz][developer]

## Credits
Doxter was lovingly crafted by [Selvin Ortiz][developer] with the help of these third party libraries.

1. [Parsedown][parsedown] _for lightening fast and consistent markdown parsing_
2. [BehaveJS][behave] _to add editor behavior to the textarea_
3. [Zit][zit] _for dependency management_

_Special thanks to their developer and maintainers!_

## License
Doxter is open source software licensed under the [MIT license][license]

![Open Source Initiative][osilogo]

[craft]:http://buildwithcraft.com "Craft CMS"
[developer]:http://twitter.com/selvinortiz "@selvinortiz"
[release]:https://github.com/selvinortiz/craft.doxter/releases/download/v0.6.2/doxter.v0.6.2.zip "Official Release"
[refTags]:http://buildwithcraft.com/docs/reference-tags "Reference Tags"
[parseRefs]:http://buildwithcraft.com/docs/templating/filters#parseRefs "Reference Tag Filter"
[preview]:http://buildwithcraft.com/features/live-preview "Live Preview"
[matrix]:http://buildwithcraft.com/features/matrix "Matrix"
[entrytypes]:http://buildwithcraft.com/features/entry-types "Entry Types"
[gfm]: https://help.github.com/articles/github-flavored-markdown "Github Flavored Markdown"
[zit]:https://github.com/selvinortiz/zit "Zit"
[behave]:http://jakiestfu.github.io/Behave.js/ "BehaveJS"
[parsedown]:https://github.com/erusev/parsedown "Parsedown"
[scrawl]:https://github.com/builtbysplash/craft-scrawl "Scrawl"
[changelog]:https://github.com/selvinortiz/craft.doxter/blob/master/CHANGELOG.md "The Changelog"
[license]:https://raw.github.com/selvinortiz/craft.doxter/master/LICENSE "MIT License"
[osilogo]:https://github.com/selvinortiz/craft.doxter/raw/master/resources/img/osilogo.png "Open Source Initiative"
