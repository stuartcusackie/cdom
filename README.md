# SCIE CDOM

A helper function that adds classes to elements in html strings. Useful for Tailwind projects. Designed for Laravel.

## Installation

```
composer require stuartcusackie/cdom
```

## Publish

```
php artisan vendor:publish
```

## Config

Set up your config file: config/cdom.php

**Example style config**
```
'style1' => [
	'a' => 'underline',
	'h1' => 'text-5xl mb-12',
	'h2' => 'text-4xl mb-6 mb-3 mt-12 first:mt-0',
	'h3' => 'text-3xl mb-3 mt-12 first:mt-0',
	'h4' => 'text-3xl font-semibold mb-3',
	'h5' => 'text-2xl font-semibold mb-3',
	'ul' => 'pl-5 list-disc',
	'ol' => 'pl-5 list-decimal',
	'li' => 'mb-2 last:mb-0',
	'p, ul, ol, table' => 'mb-4 last:mb-0',
	'blockquote' => 'border-l-8 p-3 mb-5 text-xl border-gray-200',
	'table' => 'w-full border-r text-left border-gray-200',
	'table tbody' => 'border-t border-gray-200',
	'table tr' => 'border-b border-gray-200 odd:bg-gray-100',
	'table td, table th' => 'border-l px-3 py-1 border-gray-200',
	'table th' => 'odd:bg-gray-200'
]
```

## Usage

To transform markup use the `cdom` helper. You can optionally pass a style name from your config or let it fall back to the default:
```
{!! cdom($content) !!}
{!! cdom($content, 'yourconfigstylename') !!}
```

To get the classes for a single HTML element from your style config you can use the `cdomel` helper. You can optionally pass a style name from your config or let it fall back to the default:
```
<h1 class="{{ cdomel('h1') }}">Heading</h1>
<a href="/" class="{{ cdomel('a', 'style1') }}">Link</a>
```