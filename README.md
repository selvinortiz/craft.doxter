![Patrol](doxter/resources/img/doxter.png)

# Doxter 1.1.0
Lovingly crafted by [Selvin Ortiz](https://selv.in) for [Craft CMS][craft]

**Doxter** is a markdown plugin designed to improve the way you write documentation

<a href='https://pledgie.com/campaigns/27296'>
<img alt='Support Craft Plugin Development By Selvin Ortiz' src='https://pledgie.com/campaigns/27296.png?skin_name=chrome' border='0'>
</a>

## Installation
1. Download the [latest release][release] or clone this repo
2. Extract the archive and place `doxter` inside your `craft/plugins` directory
4. Install **Doxter** from the Control Panel **@** `Settings > Plugins`
5. Adjust plugin settings from the Control Panel **@** `Settings > Plugins > Doxter`
6. FieldType settings can be adjusted when you create your **Doxter** field

## Features
* [Live Preview][preview] Support
* Fast and consitent [Github Flavored Markdown][gfm] Parsing
* **Linkable Headers** based on parsing settings
* Advanced [Reference Tags][refTags] parsing
* Minimalist editor with custom toolbar for [Reference Tags][refTags]
* Extensible **Shortcode** parsing support
* Event driven parsing API for developers
* Advanced fenced codeblock parsing
* Support for typography styles for better web typography
* Support for multiple fieldtypes in single [Entry Type][entrytypes] or  [Matrix Field][matrix]
* **Unit Tested** with care

---

## Doxter Field

**Doxter** is a field type that allows you to write and parse markdown content.

## Workflow

1. Create a new **Doxter** field
2. Add the new field to a **field layout** in your **entry type**
3. Write your _markdown_ and save it along with your **entry**

The content will be saved as _plain text_ and returned as a **DoxterModel**

## Doxter Model

### text()
Returns the _plain text_ content stored via the field type

```twig
{{ entry.doxterField.text() }}
```

It is also worth noting that this is the default behavior when you use you the **Doxter** in string context.

```twig
{# __toString() returns the text() equivalent #}
{{ entry.doxterField }}
```

### html()

Returns properly formatted **HTML** parsed from the the _plain text_ content stored via the **Doxter** field type.

```twig
{{ entry.doxterField.html() }}
```

Calling `html()` without any params will use the default parsing option defined in your settings.
Passing an options object `html({})` gives you full control on a per field basis.

## Doxter Filter
The `doxter` filter is still supported and can be used to parse markdown from any source.

```twig
{{ "Doxter _markdown_"|doxter }}
{# or #}
{{ "Doxter _markdown_"|doxter({}) }}
```

## Options
The **Doxter Model** `html()` method and the **Doxter Filter** accept an array of options to override your defaults.

| Option                | Type      | Default            | Description                                                           |
|-----------------------|-----------|--------------------|----------------------------------------------------------             |
| `codeBlockSnippet`    | `string`  | _see snippet below_|                                                                       |
| `addHeaderAnchors`    | `boolean` | `true`             | Whether to parse headers and add anchors for direct linking           |
| `addHeaderAnchorsTo`  | `array`   | `[h1, h2, h3]`     | Which headers to add anchors to if header parsing is enabled          |
| `addTypographyStyles` | `bool`    | `false`            | Whether [typography styles](http://kingdesk.com/projects/php-typography/) should be applied |
| `startingHeaderLevel` | `string`  | `h1`               | Which tag should be use for the initial header discussed on issue #13 |
| `parseReferenceTags`  | `boolean` | `true`             | Whether [reference tags][refTags] should be parsed                    |
| `parseShortcodes`     | `boolean` | `true`             | Whether Doxter supported shortcodes should be parsed                  |


## Default Code Block Snippet
The code block snippet allows you to define how fenced code blocks should be rendered by providing two variables you can use in your snippet.

```html
<!-- Default snippet targets RainbowJS -->
<pre><code data-language="language-{languageClass}">{sourceCode}</code></pre>
```

| Variable      | Description                                                         | Example          |
|---------------|---------------------------------------------------------------------|------------------|
|`languageClass`| The programming/scripting language added in the fenced code block   | `js`, `php`      |
|`sourceCode`   | The actual code inside the fenced code block                        | `echo "Code";`   |

## Changes
All noteworthy changes can be found in [CHANGELOG.md][changelog]

## Feedback
If you have any feedback, questions, or concerns, please reach out to me on twitter [@selvinortiz][developer]

## Credits
Doxter was lovingly crafted by [Selvin Ortiz][developer] with the help of these third party libraries.

1. [Parsedown][parsedown] _for lightening fast and consistent markdown parsing_
2. [Parsedown Extra][parsedown] _for lightening fast and consistent markdown_

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
[parsedown]:https://github.com/erusev/parsedown-extra "Parsedown Extra"
[changelog]:https://github.com/selvinortiz/craft.doxter/blob/master/CHANGELOG.md "The Changelog"
[license]:https://raw.github.com/selvinortiz/craft.doxter/master/LICENSE "MIT License"
[osilogo]:https://github.com/selvinortiz/craft.doxter/raw/master/doxter/resources/img/osilogo.png "Open Source Initiative"
