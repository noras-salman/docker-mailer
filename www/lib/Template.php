<?php
/** REF: https://www.daggerhart.com/simple-php-template-class/
 * Class Template - a very simple PHP class for rendering PHP templates
 */
class Template {
	/**
	 * Location of expected template
	 *
	 * @var string
	 */
	public $folder;
	/**
	 * Template constructor.
	 *
	 * @param $folder
	 */
	function __construct( $folder =  __DIR__.'/../templates/' ){
		if ( $folder ) {
			$this->set_folder( $folder );
		}
	}
	/**
	 * Simple method for updating the base folder where templates are located.
	 *
	 * @param $folder
	 */
	function set_folder( $folder ){
 
		$this->folder =$folder;
	}
	/**
	 * Find and attempt to render a template with variables
	 *
	 * @param $suggestions
	 * @param $variables
	 *
	 * @return string
	 */
	function renderFile( $suggestions, $variables = array() ){
		$template = $this->find_template( $suggestions );
		$output = '';
		if ( $template ){
			$output = $this->render_template( $template, $variables );
		}
		return $output;
	}
	/**
	 * Look for the first template suggestion
	 *
	 * @param $suggestions
	 *
	 * @return bool|string
	 */
	function find_template( $suggestions ){
		if ( !is_array( $suggestions ) ) {
			$suggestions = array( $suggestions );
		}
		$suggestions = array_reverse( $suggestions );
		$found = false;
		foreach( $suggestions as $suggestion ){ 
			if($this->folder==PAGES_DIR){
				$file = "{$suggestion}";
			}else{
				$file = "{$this->folder}/{$suggestion}.php";
			}
			
			if ( file_exists( $file ) ){
				$found = $file;
				break;
			}
		}
		return $found;
	}
	/**
	 * Execute the template by extracting the variables into scope, and including
	 * the template file.
	 *
	 * @internal param $template
	 * @internal param $variables
	 *
	 * @return string
	 */
	function render_template( /*$template, $variables*/ ){
		ob_start();
		foreach ( func_get_args()[1] as $key => $value) {
			${$key} = $value;
		}
		include func_get_args()[0];
		return ob_get_clean();
	}
	
	public static function renderPage($page,$raw=false){
		$tpl = new Template(PAGES_DIR);
		$output = $tpl->renderFile($page) ;
		$output = preg_replace ("/\R/", " ", $output); # all line endings
		$output = preg_replace ("/\t/", " ", $output); # all tabs
		$output = preg_replace ("/ +/", " ", $output); # convert all multispaces to space
		$output = preg_replace ("/^ /", "", $output);  # remove space from start
		$output = preg_replace ("/ $/", "", $output);  # and end
		if($raw)
			return $output;
		print $output;
	}
    
    public static function render($suggestions, $variables = array(),$raw=false){
        $tpl = new Template();
		$output = $tpl->renderFile($suggestions,$variables) ;
		$output = preg_replace ("/\R/", " ", $output); # all line endings
		$output = preg_replace ("/\t/", " ", $output); # all tabs
		$output = preg_replace ("/ +/", " ", $output); # convert all multispaces to space
		$output = preg_replace ("/^ /", "", $output);  # remove space from start
		$output = preg_replace ("/ $/", "", $output);  # and end
		if($raw)
			return $output;
		print $output;
    }
}
?>