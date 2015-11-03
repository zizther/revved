<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Forward compatibility for the ee() function which replaces ee() in recent versions of ExpressionEngine
 * < EE 2.6.0 backward compat
 */
if ( ! function_exists('ee'))
{
	function ee()
	{
		static $EE;
		if ( ! $EE) $EE = get_instance();
		return $EE;
	}
}

/**
 * Revved
 *
 * @package		ExpressionEngine
 * @subpackage	Addons
 * @category	Plugin
 * @author		Nathan Reed
 * @link		http://www.vimia.co.uk
 */

$plugin_info = array(
	'pi_name' => 'Revved',
    'pi_version' => '1.0',
    'pi_author' => 'Nathan Reed',
    'pi_author_url' => 'http://vimia.co.uk',
    'pi_description' => 'Allows you to swap out asset file names with their revved version, as defined in a JSON manifest file.',
    'pi_usage' => revved::usage()
);


class Revved
{

	static protected $manifest;

    var $return_data;

    function Revved()
    {
	    $revvedFile;
	    $manifestJson = 'rev-manifest.json';
	    $manifestPath;
    	$manifestPathAboveDR = $_SERVER['DOCUMENT_ROOT'] . '/../' . $manifestJson;
    	$manifestPathInDR = $_SERVER['DOCUMENT_ROOT'] . '/' .$manifestJson;
    	$manifest;

        //$this->EE =& get_instance();

		// Get file param
        $file = ee()->TMPL->fetch_param('file');

		// Get manifest path
		if ($this->manifestExists($manifestPathAboveDR))
		{
			$manifestPath = $manifestPathAboveDR;
		}
		else
		{
			if (!$this->manifestExists($manifestPathInDR))
			{
				throw new InvalidArgumentException('No rev manifest file can be found in the DOCUMENT_ROOT or above it.');
			}

			$manifestPath = $manifestPathInDR;
		}

		$revvedFile = $this->getAssetRevisionFilename($manifestPath, $file);

        $this->return_data = $revvedFile;
    }

    /**
	 * Check if the requested manifest file exists
	 *
	 * @param $manifest
	 *
	 * @return bool
	 */
	function manifestExists($manifest)
	{
		return file_exists($manifest);
	}

	/**
	 * Get the filename of an asset revision from the asset manifest
	 *
	 * @param $manifestPath
	 * @param $file
	 *
	 * @return mixed
	 */
	function getAssetRevisionFilename($manifestPath, $file)
	{
		if (is_null(self::$manifest))
		{
			self::$manifest = json_decode(file_get_contents($manifestPath), true);
		}
		if (!isset(self::$manifest[$file]))
		{
			throw new InvalidArgumentException("File {$file} not found in rev manifest");
		}

/*
		$manifest = json_decode(file_get_contents($manifestPath), true);

		if (!isset($manifest[$file]))
		{
			throw new InvalidArgumentException("File {$file} not found in rev manifest");
		}
*/

		return self::$manifest[$file];
	}


    // ----------------------------------------
    //  Plugin Usage
    // ----------------------------------------
    // This function describes how the plugin is used.
    //  Make sure and use output buffering
    public static function usage()
    {
        ob_start();
        ?>
Example:
----------------
{exp:revved file="css/styles.css"}

Manifest file:
----------------
Add a rev-manifest file in the document root of your project.

Parameters:
----------------
file=""
The file to get the revved version for.
It must match the file path in the rev-manifest file.


----------------
CHANGELOG:

1.0
* Initial release for EE 2.x



        <?php
        $buffer = ob_get_contents();
        ob_end_clean();
        return $buffer;
    }

}
/* END Class */
/* End of file pi.revved.php */
/* Location: ./system/expressionengine/third_party/revved/pi.revved.php */