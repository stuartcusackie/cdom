<?php

namespace stuartcusackie\cdom;

use simplehtmldom\HtmlDocument;

class cdom {

	protected $client;

	function __construct() {
		$this->client = new HtmlDocument();
	}

	/**
     * Apply classes and attributes to content strings.
     * 
     * @param $markup string (markup)
     * @param $style string
     * @return string (markup)
     */
    public function transform($markup, $style = 'style1') {

    	$client = new HtmlDocument();
    	$html = $client->load($markup);

    	$styleConfig = config('cdom.styles.' . $style);

    	if(!$styleConfig) {
        	throw new \Exception('CDOM config style missing.');
        }
    	
        if(config('dom.options.add_external_links')) {
        	$html = $this->addExternalLinks($html);
        }

        return $this->addStyleClasses($html, $styleConfig);
    }

	/**
	 * Loop each element in the style config and 
	 * add classes to a markup string. 
	 * 
	 * @param $html simplehtmldom\HtmlDocument
	 * @param $style array
	 * @return simplehtmldom\HtmlDocument
	 */
	private function addStyleClasses($html, array $style) {

		foreach($style as $elements => $classes) {

			foreach($html->find($elements) as $node) {
				$node->addClass($classes);
			}

		}

		return $html;
	}

	/**
	 * Add target="_blank" to simpledom nodes when
	 * the url is external or for a pdf.
	 * Useful in content editors.
	 * 
	 * @param array $node
	 * @return simplehtmldom\HtmlDocument
	 */
	private function addExternalLinks($node) {

		foreach($html->find('a') as $node) {

            if($this->is_external_url($node->href) || str_ends_with($node->href, '.pdf')) {
				$node->target = '_blank';
			}

        }

        return $html;

	}
}