<?php

namespace stuartcusackie\cdom;

use simplehtmldom\HtmlDocument;

class cdom {

	protected $client;

	function __construct() {

		$this->client = new HtmlDocument();

		if(!file_exists(base_path('config/cdom.php'))) {
        	throw new \Exception('CDOM config file missing. Please publish it.');
        }

        if(!is_array(config('cdom.styles'))) {
    		throw new \Exception('Invalid CDOM config file. Please republish it.');
    	}

	}

	/**
	 * Return the style config array.
	 * 
	 * @param $style string
	 * @return array
	 */
	public function getStyleConfig($style) {

        if(is_null($style)) {
        	return $this->getDefaultStyleConfig();
        }

        if(!is_array(config('cdom.styles.' . $style))) {
    		throw new \Exception('CDOM style "' . $style . '" does not exist. Please check your config.');
    	}

        return config('cdom.styles.' . $style);

	}

	/**
	 * Return the wrappers config array.
	 * 
	 * @return array
	 */
	public function getWrappersConfig() {

        if(!is_array(config('cdom.wrappers'))) {
    		return [];
    	}

        return config('cdom.wrappers');

	}

	/**
	 * Return the default style config.
	 * 
	 * @param $style string
	 * @return array
	 */
	public function getDefaultStyleConfig() {

		$default = config('cdom.options.default_style');

		if(!is_array(config('cdom.styles.' . $default))) {
    		throw new \Exception('CDOM default style does not exist. Please check your config.');
    	}

        return config('cdom.styles.' . $default);

	}

	/**
     * Apply classes and attributes to content strings.
     * 
     * @param $markup string (markup)
     * @param $style string
     * @param $overrides array
     * @return string (markup)
     */
    public function transform($markup = '', string $style = null, $overrides = []) {

    	$html = $this->client->load($markup);

    	if(config('cdom.options.remove_list_nesting')) {
    		$html = $this->removeListParagraphs($html);
    	}
    	
    	$html = $this->addWrapperElements($html);
        $html = $this->addStyleClasses($html, $style);

        return $html;

    }

    /**
     * Get the classes for a single element in a
     * style config
     * 
     * @param $el string
     * @param $style string
     * @return string (markup)
     */
    public function elClasses(string $el, string $style = null) {

    	$styleConfig = $this->getStyleConfig($style);
    	$classString = '';

    	// Find multiple matches
		foreach($styleConfig as $targets => $classes)
		{
			foreach(explode(', ', $targets) as $target)
			{
				if($target == $el) {
					$classString .= ' ' . $classes;
				}
			}
		}

        return trim($classString);

    }

    /**
	 * Find and remove paragraphs that are nested
	 * withing list items (prose mirror problem)
	 * 
	 * @param $html simplehtmldom\HtmlDocument
	 * @return simplehtmldom\HtmlDocument
	 */
    private function removeListParagraphs($html) {

		foreach($html->find('li p') as $node) {
			$node->outertext = $node->innertext;
		}

		$html->save();
		return $this->client->load($html);

	}
		

    /**
	 * Loop each element in the wrappers config
	 * and wrap the appropriate elements
	 * 
	 * @param $html simplehtmldom\HtmlDocument
	 * @return simplehtmldom\HtmlDocument
	 */
    private function addWrapperElements($html) {

		$wrappersConfig = $this->getWrappersConfig();

		foreach($wrappersConfig as $elements => $wrapper) {

			foreach($html->find($elements) as $node) {
				$node->outertext = str_replace('$el', $node->outertext, $wrapper);
			}

		}

		$html->save();
		return $this->client->load($html);
	}

	/**
	 * Loop each element in the style config and 
	 * add classes to a markup string. 
	 * 
	 * @param $html simplehtmldom\HtmlDocument
	 * @param $style string
	 * @return simplehtmldom\HtmlDocument
	 */
	private function addStyleClasses($html, string $style = null) {

		$styleConfig = $this->getStyleConfig($style);

		foreach($styleConfig as $elements => $classes) {

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
