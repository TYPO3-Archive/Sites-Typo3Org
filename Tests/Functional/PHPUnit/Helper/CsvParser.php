<?php

class CsvParser {
	/**
	 * parse a csv file that might have comment lines (starting with #)
	 *
	 * @param $filePath
	 * @return array
	 * @throws RuntimeException
	 * @throws InvalidArgumentException
	 */
	public function parseCsvFile($filePath) {
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
			if(empty($line) || $line[0] == '#') {
				// ignore comment lines
			} else {
				$array = str_getcsv($line);
				if(count($array) != 1) {
					throw new \InvalidArgumentException(sprintf('Invalid line %d: Got %d arguments, but expected 1.', $lineNr, count($array)));
				}
				$return[] = $array;
			}
			$lineNr++;
		}
		fclose($handle);

		return $return;
	}
}