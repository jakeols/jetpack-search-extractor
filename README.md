# Jetpack Search Extractor

Jetpack Search Extractor lets you select custom post meta from your pages, and add it to your managed Jetpack index.

It works by copying your page's post meta into [a new field that is already setup to be searchable by Jetpack ](https://github.com/Automattic/jetpack/blob/99e9223fad2e2fc97850c6ab6819c9ddedd7bca8/packages/sync/src/modules/class-search.php#L48). 

:warning: in development :warning: 


## Installation

Clone the repo

```bash
git clone https://github.com/jakeols/jetpack-search-extractor
```
Install admin dependencies in `admin/js`

```bash
cd admin/js && yarn install
```

Assets in `admin/js` can be built with
```bash
yarn build
```

For development usage, `yarn dev` will create a development server at `http://localhost:8080`


## Usage
To allow for hot reloading of admin assets during development, replace the following IP address with yours
```php
  if ($_SERVER['REMOTE_ADDR'] == '192.168.50.1') {
    $js_to_load = 'http://localhost:8080/bundle.js';
  }
```

## About
This plugin is built with [Preact](https://preactjs.com/), and thus very small. It's JS is only loaded and injected onto the set admin page. 
