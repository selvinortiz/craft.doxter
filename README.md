![Doxter](resources/img/doxter.png)

# Doxter 1.0
Lovingly crafted by [Selvin Ortiz][developer] for [Craft CMS][craft]

**Doxter** is a markdown plugin designed to improve the way you write documentation

## Installation
1. Download the [latest release][release] or clone this repo
2. Extract the archive and place `doxter` inside your `craft/plugins` directory
4. Install **Doxter** from the Control Panel **@** `Settings > Plugins`
5. Adjust plugin settings from the Control Panel **@** `Settings > Plugins > Doxter`
6. FieldType settings can be adjusted when you create your **Doxter Markdown** field

## Features
* [Live Preview][preview] Support
* [Github Flavored Markdown][gfm] Parsing
* Creates **Linkable Headers** based on parsing settings
* Fast and consistent **parsing** based on [Parsedown][parsedown]
* Advanced editor powered by [Ace][ace] and a custom toolbar for [Reference Tags][refTags]
* Support for multiple fieldtypes within a single [Entry Type][entrytypes]
* Support for multiple fieldtypes within [Matrix Fields][matrix]
* **Unit Tested** with care

---

## Doxter Markdown

**Doxter Markdown** is a field type that allows you to write and parse markdown content.

## Workflow

1. Create a new **Doxter Markdown** field
2. Add the new field to a **field layout** in your **entry type**
3. Write your _markdown_ and save it along with your **entry**

The content will be saved as _plain text_ and returned as a **DoxterModel** when fetched via `craft.entries`

## Doxter Model

### getText()
Returns the _plain text_ content stored via the field type

```twig
{{ entry.doxterField.getText() }}
```

### getHtml()

Returns properly formatted **HTML** parsed from the the _plain text_ content stored via the **Doxter Markdown** field type.

```twig
{{ entry.doxterField.getHtml() }}
```

### parse()
Alias of `getHtml()`

```twig
{{ entry.doxterField.parse() }}```

## Doxter Filter
The `doxter` filter is still supported and can be used to parse markdown from any source

```twig
{{ "Doxter _markdown_"|doxter }}
```

## Options
The **Doxter Model** `getHtml() | parse()` methods and the **Doxter Filter** accept an array of options to override those you set on the plugin settings screen.

| Option                | Type      | Default            | Description                                                           |
|-----------------------|-----------|--------------------|----------------------------------------------------------             |
| `parseRecursively`    | `boolean` | `true`             | Whether markdown within [reference tags][refTags] should be parsed    |
| `parseReferenceTags`  | `boolean` | `true`             | Whether [reference tags][refTags] should be parsed                    |
| `addHeaderAnchors`    | `boolean` | `true`             | Whether to parse headers and add anchors                              |
| `addHeadersAnchorsTo` | `array`   | `[h1, h2, h3]`     | Which headers to add anchors to if header parsing is enabled          |
| `codeBlockSnippet`    | `string`  | _see snippet below_|                                                                       |

## Default Code Block Snippet
The code block snippet allows you to define how fenced code blocks should be rendered by providing two variables you can use in your snippet.

```html
<!-- Default snippet targets RainbowJS -->
<pre><code data-language="language-{languageClass}">{sourceCode}</code></pre>
```

| Variable      | Description                                                         |
|---------------|---------------------------------------------------------------------|
|`languageClass`| The programming/scripting language added in the fenced code block   |
|`sourceCode`   | The actual code inside the fenced code block                        | 

## Changes
All noteworthy changes can be found in [CHANGELOG.md][changelog]

## Feedback
If you have any feedback, questions, or concerns, please reach out to me on twitter [@selvinortiz][developer]

## Credits
Doxter was lovingly crafted by [Selvin Ortiz][developer] with the help of these third party libraries.

1. [Parsedown][parsedown] _for lightening fast and consistent markdown parsing_
2. [Ace Editor][ace] _for an enjoyable experience writing markdown_

_Special thanks to their developer and maintainers!_

## License
Doxter is open source software licensed under the [MIT license][license]

![Open Source Initiative][osilogo]

[craft]:http://buildwithcraft.com "Craft CMS"
[developer]:http://twitter.com/selvinortiz "@selvinortiz"
[release]:https://github.com/selvinortiz/craft.doxter/releases "Official Release"
[refTags]:http://buildwithcraft.com/docs/reference-tags "Reference Tags"
[parseRefs]:http://buildwithcraft.com/docs/templating/filters#parseRefs "Reference Tag Filter"
[preview]:http://buildwithcraft.com/features/live-preview "Live Preview"
[matrix]:http://buildwithcraft.com/features/matrix "Matrix"
[entrytypes]:http://buildwithcraft.com/features/entry-types "Entry Types"
[gfm]: https://help.github.com/articles/github-flavored-markdown "Github Flavored Markdown"
[parsedown]:https://github.com/erusev/parsedown "Parsedown"
[changelog]:https://github.com/selvinortiz/craft.doxter/blob/master/CHANGELOG.md "The Changelog"
[license]:https://raw.github.com/selvinortiz/craft.doxter/master/LICENSE "MIT License"
[osilogo]:https://github.com/selvinortiz/craft.doxter/raw/master/resources/img/osilogo.png "Open Source Initiative"
[ace]:http://ace.c9.io "Ace Editor"
