<?php

class RenderTime {

	const PRECISION_SECOND = 0;
	const PRECISION_MILLISECOND = 1;
	const PRECISION_MICROSECOND = 2;

	private $start;
	private $end;

	public function __construct() {
		$this->start = null;
		$this->end = null;
	}

	public function start() {
		$this->start = microtime(true);
		$this->end = null;
	}

	public function stop() {
		$this->end = microtime(true);
	}

	/**
	* This function return the time the code use to process
	* @param $precision the precision wanted, with const. second, millisecond and microsecond available (default PRECISION_SECOND)
	* @param $floatingPrecision the number of numbers after the floating point (default 0)
	* @param $showUnit precise if the unit should be returned (default true)
	* @return the render time in the precision asked. Note that the precision is ±0.5 the precision (eq. 5s is at least 4.5s and at most 5.5s) <br/>
	* The code have an error about 2 or 3µs (time to execute the end function)
	*/

	public function getRenderTime($precision = self::PRECISION_SECOND, $floatingPrecision = 3, $showUnit = true) {

		$test = is_int($precision) && $precision >= self::PRECISION_SECOND && $precision <= self::PRECISION_MICROSECOND &&
		is_float($this->start) && is_float($this->end) && $this->start <= $this->end &&
		is_int($floatingPrecision) && $floatingPrecision >= 0 &&
		is_bool($showUnit);

		if($test) {

			$duration = round(($this->end - $this->start) * 10 ** ($precision * 3), $floatingPrecision);

			if($showUnit) return $duration.''.self::getUnit($precision);
			else return $duration;

		}else{

			return "Can't return the render time";

		}

	}

	private static function getUnit($precision) {
		switch($precision) {
			case self::PRECISION_SECOND :
				return 's';
			case self::PRECISION_MILLISECOND :
				return 'ms';
			case self::PRECISION_MICROSECOND :
				return 'µs';
			default :
				return '(no unit)';
		}

	}

}

?>