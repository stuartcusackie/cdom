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
	 * Return an override config.
	 * 
	 * @param $name string
	 * @return array
	 */
	public function getOverideConfig($name) {

        if(is_null($name)) {
        	throw new \Exception('Cannot use NULL for cdom override.');
        }

        if(!is_array(config('cdom.overrides.' . $name))) {
    		throw new \Exception('CDOM element override "' . $override . '" does not exist. Please check your config.');
    	}

        return config('cdom.overrides.' . $name);

	}

	/**
     * Apply classes and attributes to content strings.
     * 
     * @param $markup string (markup)
     * @param $style string
     * @param $overrides array
     * @return string (markup)
     */
    public function transform(string $markup, string $style = null,  array $overrides = []) {

    	$client = new HtmlDocument();
    	$html = $client->load($markup);
    	$styleConfig = $this->getStyleConfig($style);

        $html = $this->addStyleClasses($html, $styleConfig);
        $html = $this->overrideElementClasses($html, $overrides);

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

        return $styleConfig[$el] ?? '';

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
	 * Replace the classes for specific elements
	 * 
	 * @param $html simplehtmldom\HtmlDocument
	 * @param $overrides array
	 * @return simplehtmldom\HtmlDocument
	 */
	private function overrideElementClasses($html, array $overrides) {

		foreach($overrides as $name) {

			$overrideConfig = $this->getOverideConfig($name);

			foreach($overrideConfig as $els => $styles) {

				foreach($html->find($els) as $node) {

					$node->class = $styles;

		    	}
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
