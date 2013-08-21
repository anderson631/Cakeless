<?php
/**
 * Cakeless CakePHP plugin Component
 *
 */
class CakelessComponent extends Component {


	/* Callbacks
	------------------------------------------------------------------------- */

	public function initialize( Controller $controller, $settings = array() ) {

		// imports LESSPHP Class (only for debug modes)
		if ( Configure::read('debug') > 0 ) {

			App::import('Vendor', 'Cakeless.lessphp', array(
				'file' => 'lessphp' . DS . 'lessc.inc.php' )
			);

		}

	}



	/* Methods
	------------------------------------------------------------------------- */

	/**
	 * Compiles a LESS syntax file and saves the compiled version
	 */
	public function compile( $lessFile, $compiledFile ) {

		if ( Configure::read('debug') > 0 ) {

			lessc::ccompile( $lessFile, $compiledFile );

		}

	}


	/**
	 * Compiles a LESS syntax file and saves the compiled version, only if a change was made
	 */
	public function cachedCompile($inputFile, $outputFile) {
		$cacheFile = $inputFile . '.cache'; // load the cache

		if(file_exists($cacheFile)) $cache = unserialize(file_get_contents($cacheFile));
		else $cache = $inputFile;

		$newCache = $less->cachedCompile($cache);

		if(!is_array($cache) || $newCache['updated'] > $cache['updated']) {
			file_put_contents($cacheFile, serialize($newCache));
			file_put_contents($outputFile, $newCache['compiled']);
		}
	}
}
