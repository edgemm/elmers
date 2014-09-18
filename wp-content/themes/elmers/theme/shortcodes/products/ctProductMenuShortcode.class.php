<?php
/**
 * Product Menu shortcode
 */
class ctProductMenuShortcode extends ctShortcodeQueryable {

	/**
	 * products grouped by categories and tags
	 * @var array
	 */
	protected $groupedProds = array();

	/**
	 * group by tags?
	 * @var bool
	 */
	protected $groupByTags = true;

	/**
	 * no tags array index
	 * @var string
	 */
	const NO_TAGS_IDX = 'no_tags_idx';

	/**
	 * Returns name
	 * @return string|void
	 */
	public function getName() {
		return 'Product Menu';
	}

	/**
	 * Shortcode name
	 * @return string
	 */
	public function getShortcodeName() {
		return 'prod_menu';
	}


	/**
	 * Handles shortcode
	 * @param $atts
	 * @param null $content
	 * @return string
	 */

	public function handle($atts, $content = null) {
		$attributes = shortcode_atts($this->extractShortcodeAttributes($atts), $atts);
		extract($attributes);
		$counter = 1;
		$id = rand(100, 1000);

		//categories
		$cat_name = explode(",", $cat_name);
		$usedTerms = get_terms('product_category', 'hide_empty=1');
		$terms = $this->getTermsInOrder($usedTerms, $cat_name);

		//products
		$args = array('showposts' => '-1', 'post_type' => 'product');
		$products = $this->getCollection($attributes, $args);
		$this->buildGroupedProds($products, $attributes);

		//build html
		$filtersHtml= '<div class="filter"><ul id="menucard-tabs' . $id . '">';
		$tabsHtml = '<div class="tab-content">';
		foreach($terms as $term){
			//filters
			$filtersHtml .= '<li' . ($counter == 1 ? ' class="active"' : '') . '><a href="#' . $this->getCatTabName($term) . '" data-slider-id="' . $term->slug . '">' . $term->name . '</a></li>';

			//tabs
			$prodsInCat = $this->getProductsInCatHtml($term, $attributes);
			$tabsHtml .= '<div class="tab-pane fade in ' . ($counter == 1 ? 'active' : '') . '" id="' . $this->getCatTabName($term) . '">' . $prodsInCat . '</div>';

			$counter++;
		}

		// add nutrition button - gfh
		$filtersHtml .= '<li class="nofilter"><a href="/wp-content/uploads/2014/07/elmers-nutrition-guide.pdf" target="_blank">Nutrition</a></li>';
		// add print button - gfh
		$filtersHtml .= '<li class="printable nofilter"><a href="/wp-content/uploads/2014/06/elmers-menu-printable.pdf" target="_blank">Print</a></li>';

		$filtersHtml .= '</ul></div>';
		$tabsHtml .= '</div>';


		return do_shortcode($filtersHtml . $tabsHtml);
	}

	/**
	 * creates categories array in proper order
	 * @param $usedTerms
	 * @param $catorder
	 * @return array
	 */
	protected function getTermsInOrder($usedTerms, $catorder) {
		$result = array();
		foreach ($catorder as $order) {
			foreach ($usedTerms as $key => $term) {
				if ($order == $term->slug) {
					$result[] = $term;
					unset($usedTerms[$key]);
				}
			}
		}
		return $result;
	}

	/**
	 * creates class name for the category
	 * @param $cat
	 * @return string
	 */
	protected function getCatTabName($cat){
		return 'tab-' . strtolower(str_replace(' ', '-', $cat->slug));
	}

	/**
	 * builds the structure of products grouped by categories an tags
	 * @param array $products
	 * @param array $atrributes
	 * @return void
	 */
	protected function buildGroupedProds($products, $attributes){
		extract($attributes);
		$struct = array();
		foreach($products as $prod){
			$terms = get_the_terms($prod->ID, 'product_category');
			$tags = $taggroups == 'yes' ? (get_the_tags($prod->ID)) : array();
			$this->groupByTags = (bool)$tags;

			//prod can be in many categories and in many tags
			foreach($terms as $term){
				if($this->groupByTags){
					foreach($tags as $tag){
						$struct[$term->slug][$tag->name][$prod->ID] = $prod;
					}
				}else{
					$struct[$term->slug][self::NO_TAGS_IDX][$prod->ID] = $prod;
				}
			}
		}
		$this->groupedProds = $struct;
	}

	/**
	 * returns products from the given category based on the products structure
	 * @param $term
	 * @param array $atrributes
	 * @return string
	 */
	protected function getProductsInCatHtml($term, $attributes){
		extract($attributes);
		$html = '';
		$struct = $this->groupedProds;
		$prodsInCat = isset($struct[$term->slug]) ? $struct[$term->slug] : array();

		if($this->groupByTags){
			$counter = 1;
			$html .= '<div class="row-fluid">';
			$html .= '<div class="grid-sizer"></div>';
			$html .= '<div class="gutter-sizer"></div>';
			foreach($prodsInCat as $tagName => $prods){
				// get description of tag - gfh
				$tagDesc = get_term_by( 'name', $tagName, 'post_tag' );
				//$html .= $counter == 1 ? '<div class="row-fluid">' : '';
				$html .= '<div class="span6"><article class="menucardBox">';

				$html .= ' <header>
				                <h3>' . $tagName . '</h3>
				            </header>';
				$html .= !empty($tagDesc->description) ? '<p class="menucardBox-desc">' . $tagDesc->description . '</p>' : '';
				$html .= '<ul>';
				foreach($prods as $prod){
					$html .= $this->getProductHtml($prod, $attributes);
				}
				$html .= '</ul></article></div>';
				//$html .= $counter == 2 ? '</div>' : '';

				//$counter = $counter == 1 ? 2 : 1;
			}
			//$html .= $counter == 2 ? '</div>' : '';//if the number of tags is odd
			$html .= '</div>';// end row-fluid - gfh
		}else{
			$prodsQty = isset($prodsInCat[self::NO_TAGS_IDX]) ? count($prodsInCat[self::NO_TAGS_IDX]) : 0;
			$halfQty = ceil($prodsQty/2);
			$html .= '<div class="row-fluid"><div class="span6"><article class="menucardBox"><ul>';
			foreach($prodsInCat[self::NO_TAGS_IDX] as $key => $prod){
				if($halfQty){
					$html .= $this->getProductHtml($prod, $attributes);
					unset($prodsInCat[self::NO_TAGS_IDX][$key]);
					$halfQty--;
				}else{
					break;
				}
			}

			$html .= '</ul></article></div>';
			$html .= '<div class="span6"><article class="menucardBox"><ul>';

			foreach($prodsInCat[self::NO_TAGS_IDX] as $key => $prod){
				$html .= $this->getProductHtml($prod, $attributes);
				unset($prodsInCat[self::NO_TAGS_IDX][$key]);
			}

			$html .= '</ul></article></div></div>';
		}

		return $html;
	}

	/**
	 * returns single product html
	 * @param $prod
	 * @param $attributes
	 * @return string
	 */
	protected function getProductHtml($prod, $attributes){
		extract($attributes);
		$imgsrc = ct_get_feature_image_src($prod->ID, 'prod_menu');
		$imgsrcFull = ct_get_feature_image_src($prod->ID, 'full');
		$imgHtml = $imgsrc ? ' <figure class="menucardBox-img rounded">
					    <a class="fancybox" href="' . $imgsrcFull . '">
						<img class="menucardBox-thmb" src="' . $imgsrc . '" alt="">
					    </a>
		                        </figure>' : '';

		$custom = get_post_custom($prod->ID);
		$price = isset($custom['price'][0]) ? $custom['price'][0] : "";
		$currency = ct_get_option('products_index_currency', '$');
		$priceHtml = $showprice == 'yes' ? ('<span class="price">' . $pricelabel . $price . $currency . '</span>') : '';

		$preLink = $withlink == 'yes' ? '<a href="' . get_permalink($prod->ID) . '">' : '';
		$postLink = $withlink == 'yes' ? '</a>' : '';

		return '<li>
					' . $preLink . '
                    <div class="menucardBox-product">
                       ' . $imgHtml . '
                        <h4>' . $prod->post_title . '</h4>
                        <p>
                            ' . $prod->post_excerpt . '
                        </p>
                        ' . $priceHtml . '
                    </div>
                    ' . $postLink . '
                </li>';
	}


	/**
	 * Returns config
	 * @return null
	 */
	public function getAttributes() {
		$atts = $this->getAttributesWithQuery(array(
			'cat_name' => array('label' => __('categories in order', 'ct_theme'), 'default' => '', 'type' => 'input', 'help' => __("Category slugs separated by commas - filters products by categories but also determines the order of categories", 'ct_theme')),
			'taggroups' => array('label' => __('group products by tags?', 'ct_theme'), 'default' => 'no', 'type' => 'select', 'options' => array('yes' => __('yes', 'ct_theme'), 'no' => __('no', 'ct_theme'))),
			'showprice' => array('label' => __('Show price', 'ct_theme'), 'default' => 'yes', 'type' => 'select', 'options' => array('yes' => __('yes', 'ct_theme'), 'no' => __('no', 'ct_theme'))),
			'pricelabel' => array('label' => __('Price label', 'ct_theme'), 'default' => __('only ', 'ct_theme'), 'type' => 'input'),
			'withlink' => array('label' => __('links', 'ct_theme'), 'default' => 'yes', 'type' => 'select', 'choices' => array('yes' => __('yes', 'ct_theme'), 'no' => __('no', 'ct_theme')), 'help' => __("Include links to product details?", 'ct_theme')),
		));
		if (isset($atts['cat'])) {
			unset($atts['cat']);
		}
		return $atts;
	}

	/**
	 * Child shortcode info
	 * @return array
	 */

	public function getChildShortcodeInfo() {
		return array('name' => 'prod_menu_page', 'min' => 1, 'max' => 20, 'default_qty' => 10);
	}
}

new ctProductMenuShortcode();