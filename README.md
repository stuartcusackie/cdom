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

## Usage

```
{!! cdom($content) !!}
{!! cdom($content, 'yourconfigstylename') !!}
```
