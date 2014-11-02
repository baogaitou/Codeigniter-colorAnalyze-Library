<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Cola_canalyze
{	
	function __construct() {
		$this->obj =& get_instance();
		$this->initialize();
	}

	public function initialize() 
	{
		require_once 'cola_lib/colorAnalyze/autoload.php';
	}

	public function analyzeColor($img)
	{
		try {
			// $img = file_get_contents($img);
		    $analyzeImage = \Image\Image::createFromFile($img);
		    $start = microtime(true);
		    $analyzer = new Analyzer($analyzeImage);
		    $result = $analyzer->getResult();
		    $duration = microtime(true) - $start;

		    // $this->sendResponse(array(
		    //     "result" => array(
		    //         "background" => $result->background->getHexString(),
		    //         "title"      => $result->title->getHexString(),
		    //         "songs"      => $result->songs->getHexString(),
		    //     ),
		    //     "metrics" => array(
		    //         "duration"         => sprintf("%f", $duration)."s",
		    //         "memory"           => $this->human_filesize(memory_get_usage()),
		    //         "memory_real"      => $this->human_filesize(memory_get_usage(true)),
		    //         "memory_peak"      => $this->human_filesize(memory_get_peak_usage()),
		    //         "memory_peak_real" => $this->human_filesize(memory_get_peak_usage(true)),
		    //     )
		    // ));
		    return $result->background->getHexString()."|".$result->title->getHexString()."|".$result->songs->getHexString();
		}
		catch (Exception $e)
		{
		    $this->sendError($e);
		}
	}


	/**
	 * Sends an error and exits
	 *
	 * @param $message
	 */
	private function sendError ($message)
	{
	    $this->sendResponse(array(
	        "error" => $message
	    ));
	}


	/**
	 * Sends data and exists
	 *
	 * @param $data
	 */
	private function sendResponse ($data)
	{
	    header("Content-Type: application/json");
	    echo json_encode($data);
	    exit;
	}


	/**
	 * Renders the file size as human readable
	 *
	 * (thanks to: http://www.php.net/manual/de/function.filesize.php#106569)
	 *
	 * @param $bytes
	 * @param int $decimals
	 *
	 * @return string
	 */
	private function human_filesize($bytes, $decimals = 2) {
	    $sz = 'BKMGTP';
	    $factor = (int) floor((strlen($bytes) - 1) / 3);
	    return sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)) . @$sz[$factor];
	}
}