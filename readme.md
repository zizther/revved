# Expressionengine Asset Rev (Cache Busting)

# Revved
A plugin for Expressionengine that allows you to swap out asset file names with their revved version, as defined in a JSON manifest file.

Manifest files would most likely be generated by Grunt/Gulp modules, such as [grunt-filerev-assets](https://github.com/richardbolt/grunt-filerev-assets) or [gulp-rev](https://github.com/sindresorhus/gulp-rev).

---
## Why
You could append a query string to the asset url (e.g. css/main.css?v=24), but you should [read here](http://www.stevesouders.com/blog/2008/08/23/revving-filenames-dont-use-querystring/) to find out why that's not an ideal solution.

---


## Installation
Copy the revved folder to your system/expressionengine/third_party directory.

You should create your rev-manifest.json file in the DOCUMENT_ROOT or above the public folder if you have EE setup like that.

Note: If the plugin can't find your manifest file, it will throw an error.

## Example:
`{exp:revved file="css/styles.css"}`

or

`{path='assets/js/{exp:revved file="main.js"}'}`


## Parameters:
`file=""`

The file to get the revved version for.
It must match the file path in the rev-manifest file.


## Manifest file:
Add a rev-manifest file in the document root of your project.

Manifest file example.

```
{
    "css/main.css": "css/main-a9961d38.css",
    "js/main.js": "js/main-786087f7.js"
}
```