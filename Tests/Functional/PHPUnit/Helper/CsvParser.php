<?php

class CsvParser {
	/**
	 * parse a csv file that might have comment lines (starting with #)
	 *
	 * @param $filePath
	 * @param int $minColumns
	 * @param int $maxColumns
	 * @throws RuntimeException
	 * @throws InvalidArgumentException
	 * @return array
	 */
	public function parseCsvFile($filePath, $minColumns = 1, $maxColumns = 1) {
		$return = array();
		if(!file_exists($filePath)) {
			throw new \InvalidArgumentException(sprintf('File %s does not exist.', $filePath));
		}

		$handle = @fopen($filePath, 'r');
		if(!$handle) {
			throw new \RuntimeException(sprintf('Could not open file %s.', $filePath));
		}
		$lineNr = 1;
		while (($line = fgets($handle, 4096)) !== false) {
			if(trim($line) == '' || $line[0] == '#') {
				// ignore comment lines
			} else {
				$array = str_getcsv($line);
				if(count($array) < $minColumns) {
					throw new \InvalidArgumentException(sprintf(
						'Invalid line %d: Got %d arguments, but expected at least %d.',
						$lineNr,
						count($array),
						$minColumns
					));
				}
				if(count($array) > $maxColumns) {
					throw new \InvalidArgumentException(sprintf(
						'Invalid line %d: Got %d arguments, but expected at most %d.',
						$lineNr,
						count($array),
						$maxColumns
					));
				}
				$return[$array[0]] = $array;
			}
			$lineNr++;
		}
		fclose($handle);

		return $return;
	}
}