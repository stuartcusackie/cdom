<?php

/*
|--------------------------------------------------------------------------
| Content DOM Config
|--------------------------------------------------------------------------
|
| This is a handy way to add classes to unformatted content provided
| by text editors and advanced fields. Remember, the order of
| elements may be important.
|
| Note to self: I got rid of variables but we could reintroduce them.
|
*/

return [

	'options' => [
		'default_style' => 'style1',
		'add_external_links' => true
	],

	/**
	 * Keep targets simple for more flexibility on the cdomel helper
	 */
	'styles' => [

		'style1' => [
			'a' => 'underline text-blue-500 hover:text-blue-900 visited:text-blue-900',
			'h1' => 'text-5xl 2xl:text-6xl font-condensed font-bold mb-12 text-highlight-primary',
			'h2' => 'text-4xl 2xl:text-5xl font-condensed font-medium mb-8 mt-12 first:mt-0',
			'h3' => 'text-3xl 2xl:text-4xl font-condensed font-medium mb-6 mt-12 first:mt-0',
			'h4' => 'text-2xl 2xl:text-3xl font-condensed font-medium mb-6',
			'h5' => 'text-xl 2xl:text-2xl font-condensed font-medium mb-4',
			'ul' => 'pl-5 list-disc',
			'ol' => 'pl-5 list-decimal',
			'li' => 'mb-2 last:mb-0',
			'p, ul, ol' => 'mb-4 last:mb-0',
			'blockquote' => 'border-l-8 p-3 mb-5 text-xl border-gray-200',
			'table' => 'w-full table-auto border-r border-gray-200 mb-12 last:mb-0',
			'tbody' => 'border-t border-gray-200',
			'tr' => 'border-b border-gray-200 even:bg-gray-100',
			'td, th' => 'border-l px-3 py-1 border-gray-200 text-left'
		],

	],

	/**
	 * Wrap elements in other elements
	'wrappers' => [
		'table' => '<div class="overflow-x-scroll whitespace-nowrap mb-12 last:mb-0">$el</div>'
	]
	*/
	
];
