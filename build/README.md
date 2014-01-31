## Build Script for Craft Plugins
_by_ [Selvin Ortiz](http://twitter.com/selvinortiz)

### Getting Started
1. Make sure you have **Phing** installed or can run it from the **command line**, you may use the **phing.phar** provided.
2. Run a `find/replace` on the **build.xml** to update plugin related properties
3. Make sure to update **css.txt**, **js.txt** and **use.json** to your plugin needs.

### Minification & Concatenation
We use the **YUI2** compressor to achieve this and can be found in the **minify** and **concatenate** targets.

### Build & Release
The **build** target runs all the necessary targets and prepares files for **release**.
The **release** target itself archives all the built files and use exclusion to only include production ready code.

### The Special (use) Target
The **use** target takes the **distro** zip created by the **release** target and unzips in into predetermine locations.
You can add as many _absolute_ `/mypath/to/plugins/` or _relative_ `../../plugins` paths to the **use.json** file provided.

----
### Targets

#### clean
Deletes previously _minified/concatenated_ files

#### minify
Minifies **CSS** and **JS** based on a list provided in `css.txt` and `js.txt`

#### concatenate
Concatenates _minified_ **CSS** and **JS** based on paths properties and the output from the **minify** target

#### build
Just runs **minify** and **concatenate** and their dependencies

#### release
Prepares and archive ready for release with production ready code based on the output from the **build** target

#### use
Takes a production release archive created by the **release** target and extracts it into locations defined in **use.json**
