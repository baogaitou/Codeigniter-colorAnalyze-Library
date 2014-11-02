## Readme

This is a **color analyze** library for **Codeigniter** 2.x.


## Useage
Put `bb_canalyze.php` into your `applications/libraries/` and put directory `colorAnalyze` in somewhere. then use it like this:
	
    $this->load->library('bb_canalyze');

	$this->load->library('cola_canalyze');
	$c = $this->cola_canalyze->analyzeColor('data/photo/sample.jpg');
