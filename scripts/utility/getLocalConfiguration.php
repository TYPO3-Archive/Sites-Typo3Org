<?php
/**
 * Read a property from LocalConfiguration.php
 *
 * Usage: php getLocalConfiguration.php DB username path/to/LocalConfiguration.php
 */

try {
	if ($argc != 4) {
		throw new InvalidArgumentException(sprintf(
			"%d parameters given. Expected 3.",
			$argc - 1
		));
	}
	$first = $argv[1];
	$second = $argv[2];
	$file = $argv[3];
	if (!file_exists($file)) {
		throw new InvalidArgumentException(sprintf(
			"File %s does not exist", $file
		));
	}
	$localconf = include($file);
	echo $localconf[$first][$second];
	exit(0);
} catch (InvalidArgumentException $e) {
	if ($e->getMessage()) {
		echo $e->getMessage() . "\n";
	}
	echo sprintf(
		"Usage: %s DB username path/to/LocalConfiguration.php\n",
		$argv[0]
	);
	exit(-1);
}
