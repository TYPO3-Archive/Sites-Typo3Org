<?php
error_reporting(E_ALL & ~E_NOTICE);

require('api-keys.php');

define('PATH_thisScript', str_replace('//', '/', str_replace('\\', '/',
	(PHP_SAPI == 'fpm-fcgi' || PHP_SAPI == 'cgi' || PHP_SAPI == 'isapi' || PHP_SAPI == 'cgi-fcgi') &&
	($_SERVER['ORIG_PATH_TRANSLATED'] ? $_SERVER['ORIG_PATH_TRANSLATED'] : $_SERVER['PATH_TRANSLATED']) ?
	($_SERVER['ORIG_PATH_TRANSLATED'] ? $_SERVER['ORIG_PATH_TRANSLATED'] : $_SERVER['PATH_TRANSLATED']) :
	($_SERVER['ORIG_SCRIPT_FILENAME'] ? $_SERVER['ORIG_SCRIPT_FILENAME'] : $_SERVER['SCRIPT_FILENAME']))));

define('PATH_site', dirname(PATH_thisScript).'/');

	// db connection
require(PATH_site . '../typo3conf/localconf.php');
define ('TYPO3_DB_NAME', $typo_db);
define ('TYPO3_DB_HOST', $typo_db_host);
define ('TYPO3_DB_USERNAME', $typo_db_username);
define ('TYPO3_DB_PASSWORD', $typo_db_password);

	// no user serviceable parts below...
if (empty($_SERVER['HTTPS'])) {
	syslog(LOG_WARNING, 'authenticate.php: This service must be called through a SSL connection!');
	header("HTTP/1.0 403 Forbidden");
	exit('Not using HTTPS');
}

if (isset($apiKeys[$_SERVER['HTTP_X_FORWARDED_FOR']]) && $apiKeys[$_SERVER['HTTP_X_FORWARDED_FOR']] === $_POST['apiKey']) {
	if (credentialsValid($_POST['username'], $_POST['password']) === TRUE) {
		syslog(LOG_NOTICE, 'authenticate.php: Credentials for user ' . $_POST['username'] . ' are valid.');
		if ($_POST['returnUserInfo']) {
			$userInfo = getUserInfo($_POST['username']);
			if (!is_array($userInfo)) {
				exit ('2');
			}
			$nameParts = explode(' ', $userInfo['name'], 2);
			$userInfo['firstName'] = isset($nameParts[0]) ? $nameParts[0] : $userInfo['name'];
			$userInfo['lastName'] = isset($nameParts[1]) ? $nameParts[1] : $userInfo['name'];
			echo(json_encode($userInfo));
			exit;
		} else {
			exit('1');
		}
	} else {
		syslog(LOG_NOTICE, 'authenticate.php: Credentials for user ' . $_POST['username'] . ' not found or invalid.');
	}
} else {
	syslog(LOG_NOTICE, 'authenticate.php: API key for remote address ' . $_SERVER['HTTP_X_FORWARDED_FOR'] . ' not found or invalid.');
	header("HTTP/1.0 403 Forbidden");
	exit('Invalid token');
}

exit('0');

/**
* Check if supplied credentials are valid
* 
* @param string $username Username
* @param string $password Clear-text password
*/
function credentialsValid($username, $password) {
	mysql_select_db(TYPO3_DB_NAME, mysql_connect(TYPO3_DB_HOST, TYPO3_DB_USERNAME, TYPO3_DB_PASSWORD));

	$query = sprintf('SELECT password FROM fe_users WHERE username = \'%s\' AND deleted = 0',
		mysql_real_escape_string($username)
	);

	$result = mysql_query($query);
	$resultRow = mysql_fetch_assoc($result);

	if ($resultRow !== FALSE) {
		$PHPass = new tx_t3secsaltedpw_phpass();
			// existing record is in format of Portable PHP password hashing framework
		if (strncmp($resultRow['password'], '$P$', 3) === 0) {
			if ($PHPass->checkPassword($password, $resultRow['password'])) {
				return TRUE;
			}
		}
	}
	return FALSE;
}

function getUserInfo($username) {
	$userData = array();
	mysql_select_db(TYPO3_DB_NAME, mysql_connect(TYPO3_DB_HOST, TYPO3_DB_USERNAME, TYPO3_DB_PASSWORD));
	mysql_query('SET NAMES utf8');
	$result = mysql_query('SELECT username, email, name, tx_t3ocla_hassignedcla FROM fe_users WHERE username = \'' . $username . '\'');
	return mysql_fetch_assoc($result);
}

/***************************************************************
*  Copyright notice
*
*  (c) 2004-2006 Solar Designer (solar at openwall.com)
*  (c) 2008      Dries Buytaert (dries at buytaert.net)
*  (c) 2008      Marcus Krause  (marcus#exp2008@t3sec.info)
*  All rights reserved
*
*  This script is part of the TYPO3 project. The TYPO3 project is
*  free software; you can redistribute it and/or modify
*  it under the terms of the GNU General Public License as published by
*  the Free Software Foundation; either version 2 of the License, or
*  (at your option) any later version.
*
*  The GNU General Public License can be found at
*  http://www.gnu.org/copyleft/gpl.html.
*  A copy is found in the textfile GPL.txt and important notices to the license
*  from the author is found in LICENSE.txt distributed with these scripts.
*
*
*  This script is distributed in the hope that it will be useful,
*  but WITHOUT ANY WARRANTY; without even the implied warranty of
*  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
*  GNU General Public License for more details.
*
*  This copyright notice MUST APPEAR in all copies of the script!
***************************************************************/
/**
 * Secure password hashing class for user authentication.
 *
 * Derived from Drupal CMS
 * original license: GNU General Public License (GPL)
 * @see http://drupal.org/node/29706/
 *
 * Based on the Portable PHP password hashing framework
 * original license: Public Domain
 * @see http://www.openwall.com/phpass/
 *
 * $Id: class.tx_t3secsaltedpw_phpass.php 64 2008-11-20 22:52:26Z mkrause $
 *
 * @author	Marcus Krause <marcus#exp2008@t3sec.info>
 * @author	Karsten Dambekalns <karsten@typo3.org>
 */

/**
 * Class implements Portable PHP password hashing framework.
 *
 * @author  	Marcus Krause <marcus#exp2008@t3sec.info>
 *
 * @since   	2008-11-16
 * @package     TYPO3
 * @subpackage  tx_t3secsaltedpw
 */
class tx_t3secsaltedpw_phpass {

	/**
	 * The default log2 number of iterations for password stretching.
	 * This should increased by 1 from time to time to counteract
	 * increases in the speed and power of computers available to
	 * crack the hashes.
	 */
	const HASH_COUNT = 14;

	/**
	 * The default minimum allowed log2 number of iterations for
	 * password stretching.
	 */
	const MIN_HASH_COUNT = 7;

	/**
	 * The default maximum allowed log2 number of iterations for
	 * password stretching.
	 */
	const MAX_HASH_COUNT = 30;


	/**
	 * Keeps log2 number
	 * of iterations for password stretching.
	 *
	 * @access protected
	 * @var    integer
	 */
	protected $hashCount;

	/**
	 * Keeps minimum allowed log2 number
	 * of iterations for password stretching.
	 *
	 * @access protected
	 * @var    integer
	 */
	protected $minHashCount;

	/**
	 * Keeps maximum allowed log2 number
	 * of iterations for password stretching.
	 *
	 * @access protected
	 * @var    integer
	 */
	protected $maxHashCount;


	/**
	 * Class constructor.
	 *
	 * @access  public
	 * @param   integer  $hashCount  log2 number of iterations for password stretching (optional)
	 */
	public function __construct( $hashCount = null ) {
		$this->setHashCount($hashCount);
		$this->setMinHashCount();
		$this->setMaxHashCount();
	}

	/**
	 * Encodes bytes into printable base 64 using the *nix standard from crypt().
	 *
	 * @access protected
	 * @param  string     $input  the string containing bytes to encode.
	 * @param  integer    $count  the number of characters (bytes) to encode.
	 * @return string             encoded string
	 */
	protected function base64Encode($input, $count)  {
		$output = '';
		$i = 0;
		$itoa64 = $this->getItoa64();
		do {
			$value = ord($input[$i++]);
			$output .= $itoa64[$value & 0x3f];
			if ($i < $count) {
				$value |= ord($input[$i]) << 8;
			}
			$output .= $itoa64[($value >> 6) & 0x3f];
			if ($i++ >= $count) {
				break;
			}
			if ($i < $count) {
				$value |= ord($input[$i]) << 16;
			}
			$output .= $itoa64[($value >> 12) & 0x3f];
			if ($i++ >= $count) {
				break;
			}
			$output .= $itoa64[($value >> 18) & 0x3f];
		} while ($i < $count);
		return $output;
	}

	/**
	 * Checks whether a plain text password matches a stored hashed password.
	 *
	 * @param   string  $plainPW         plain-text password to compare with salted hash
	 * @param   string  $saltedHashPW    salted hash to compare plain-text password with
	 * @return  boolean                  true if plain-text password matches the salted
	 *                                   hash, otherwise false
	 */
	public function checkPassword($plainPW, $saltedHashPW) {
		$hash = $this->cryptPassword($plainPW, $saltedHashPW);
		return ($hash && $saltedHashPW == $hash);
	}

	/**
	 * Hashes a password using a secure stretched hash.
	 *
	 * By using a salt and repeated hashing the password is "stretched". Its
	 * security is increased because it becomes much more computationally costly
	 * for an attacker to try to break the hash by brute-force computation of the
	 * hashes of a large number of plain-text words or strings to find a match.
	 *
	 * @param   string  $password  plain-text password to hash
	 * @param   string  $setting   an existing hash or the output of getGeneratedSalt()
	 * @return  mixed              a string containing the hashed password (and salt)
	 *                             or boolean FALSE on failure.
	 */
	protected function cryptPassword($password, $setting)  {
			// The first 12 characters of an existing hash are its setting string.
		$setting = substr($setting, 0, 12);

		if (0 != strncmp($setting, '$P$', 3)) return FALSE;

		$count_log2 = self::getCountLog2($setting);
			// Hashes may be imported from elsewhere, so we allow != HASH_COUNT
		if ($count_log2 < $this->getMinHashCount() || $count_log2 > $this->getMaxHashCount()) {
			return FALSE;
		}
		$salt = substr($setting, 4, 8);
			// Hashes must have an 8 character salt.
		if (!isset($salt{7})) return FALSE;

			// We must use md5() or sha1() here since they are the only cryptographic
			// primitives always available in PHP 5. To implement our own low-level
			// cryptographic function in PHP would result in much worse performance and
			// consequently in lower iteration counts and hashes that are quicker to crack
			// (by non-PHP code).
		$count = 1 << $count_log2;

		$hash = md5($salt . $password, TRUE);
		do {
			$hash = md5($hash . $password, TRUE);
		} while (--$count);

		$output =  $setting . $this->base64Encode($hash, 16);
			// base64Encode() of a 16 byte MD5 will always be 22 characters.
		return (strlen($output) == 34) ? $output : FALSE;
	}

	/**
	 * Parses the log2 iteration count from a stored hash or setting string.
	 *
	 * @access  protected
	 * @param   string     $setting  hash or to get log2 iteration count from
	 */
	protected function getCountLog2($setting) {
		$itoa64 = $this->getItoa64();
		return strpos($itoa64, $setting[3]);
	}

	/**
	 * Generates a random base 64-encoded salt prefixed with settings for the hash.
	 *
	 * Proper use of salts may defeat a number of attacks, including:
	 *  - The ability to try candidate passwords against multiple hashes at once.
	 *  - The ability to use pre-hashed lists of candidate passwords.
	 *  - The ability to determine whether two users have the same (or different)
	 *    password without actually having to guess one of the passwords.
	 *
	 * @access  protected
	 * @param   integer    $countLog2  determines the number of iterations used in the hashing
	 *                                 process; a larger value is more secure, but takes more
	 *                                 time to complete.
	 * @return  string                 a 12 character string containing the iteration count and
	 *                                 a random salt.
	 */
	protected function getGeneratedSalt($countLog2) {
		$output = '$P$';
			// Minimum log2 iterations is MIN_HASH_COUNT.
		$countLog2 = max($countLog2, $this->getMinHashCount());
			// Maximum log2 iterations is MAX_HASH_COUNT.
			// We encode the final log2 iteration count in base 64.
		$itoa64 = $this->getItoa64();
		$output .= $itoa64[min($countLog2, $this->getMaxHashCount())];
			// 6 bytes is the standard salt for a portable phpass hash.
		$output .= $this->base64Encode($this->generateRandomBytes(6), 6);
		return $output;
	}

	/**
	 * Method returns log2 number of iterations for password stretching.
	 *
	 * @access  protected
	 * @return  integer    log2 number of iterations for password stretching
	 * @see                HASH_COUNT
	 * @see                $hashCount
	 * @see                setHashCount()
	 */
	public function getHashCount() {
		return isset($this->hashCount) ? $this->hashCount : self::HASH_COUNT;
	}

	/**
	 * Hashes a password using a secure hash.
	 *
	 * @access  public
	 * @param   string   $password   plain-text password.
	 * @param   integer  $countLog2  optional integer to specify the iteration count;
	 *                               generally used only during bulk operations where
	 *                               a value less than the default is needed for speed
	 * @return  mixed                string containing the hashed password (and a salt),
	 *                               or boolean FALSE on failure.
	 */
	public function getHashedPassword($password, $countLog2 = 0) {
		if (empty($countLog2)) {
				// uses the standard iteration count
			$countLog2 = $this->getHashCount();
		}
		return $this->cryptPassword($password, $this->getGeneratedSalt($countLog2));
	}

	/**
	 * Returns a string for mapping an int to the corresponding base 64 character.
	 *
	 * @access  protected
	 * @return  string     string for mapping an int to the corresponding
	 *                     base 64 character
	 */
	protected function getItoa64() {
		return './0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
	}

	/**
	 * Method returns maximum allowed log2 number of iterations for password stretching.
	 *
	 * @return  integer  maximum allowed log2 number of iterations for password stretching
	 * @see              MAX_HASH_COUNT
	 * @see              $maxHashCount
	 * @see              setMaxHashCount()
	 */
	public function getMaxHashCount() {
		return isset($this->maxHashCount) ? $this->maxHashCount : self::MAX_HASH_COUNT;
	}

	/**
	 * Method returns minimum allowed log2 number of iterations for password stretching.
	 *
	 * @return  integer  minimum allowed log2 number of iterations for password stretching
	 * @see              MIN_HASH_COUNT
	 * @see              $minHashCount
	 * @see              setMinHashCount()
	 */
	public function getMinHashCount() {
		return isset($this->minHashCount) ? $this->minHashCount : self::MIN_HASH_COUNT;
	}

	/**
	 * Checks whether a user's hashed password needs to be replaced with a new hash.
	 *
	 * This is typically called during the login process when the plain text
	 * password is available.  A new hash is needed when the desired iteration
	 * count has changed through a change in the variable $hashCount or
	 * HASH_COUNT or if the user's password hash was generated in an bulk update
	 * with class ext_update.
	 *
	 * @access  public
	 * @param   string   $passString  salted hash to check if it needs an update
	 * @return  boolean	              true if salted hash needs an update,
	 *                                otherwise false
	 */
	public function isHashUpdateNeeded($passString) {
			// Check whether this was an updated password.
		if ((0 != strncmp($passString, '$P$', 3)) || (strlen($passString) != 34)) {
			return true;
		}
			// Check whether the iteration count used differs from the standard number.
		return ($this->getCountLog2($passString) != self::HASH_COUNT);
	}

	/**
	 * Method sets log2 number of iterations for password stretching.
	 *
	 * @param  integer  $hashCount  log2 number of iterations for password stretching to set
	 * @see                         HASH_COUNT
	 * @see                         $hashCount
	 * @see                         getHashCount()
	 */
	public function setHashCount($hashCount = null) {
		$this->hashCount = isset($hashCount) ? intval($hashCount) : self::HASH_COUNT;
	}

	/**
	 * Method sets minimum allowed log2 number of iterations for password stretching.
	 *
	 * @param  integer  $minHashCount  minimum allowed log2 number of iterations
	 *                                 for password stretching to set
	 * @see                            MIN_HASH_COUNT
	 * @see                            $minHashCount
	 * @see                            getMinHashCount()
	 */
	public function setMinHashCount($minHashCount = null) {
		$this->minHashCount = isset($minHashCount) ? intval($minHashCount) : self::MIN_HASH_COUNT;
	}

	/**
	 * Method sets maximum allowed log2 number of iterations for password stretching.
	 *
	 * @param  integer  $maxHashCount  maximum allowed log2 number of iterations
	 *                                 for password stretching to set
	 * @see                            MAX_HASH_COUNT
	 * @see                            $maxHashCount
	 * @see                            getMaxHashCount()
	 */
	public function setMaxHashCount($maxHashCount = null) {
		$this->maxHashCount = isset($maxHashCount) ? $maxHashCount : self::MAX_HASH_COUNT;
	}

	/**
	 * Returns a string of highly randomized bytes (over the full 8-bit range).
	 *
	 * This function is better than simply calling mt_rand() or any other built-in
	 * PHP function because it can return a long string of bytes (compared to < 4
	 * bytes normally from mt_rand()) and uses the best available pseudo-random source.
	 *
	 * retrieved from Drupal CMS
	 *
	 * @param $count
	 *   The number of characters (bytes) to return in the string.
	 */
	public function generateRandomBytes($count)  {
			// We initialize with the somewhat random PHP process ID on the first call.
		if (empty($random_state)) {
			$random_state = getmypid();
		}
		$output = '';
			// /dev/urandom is available on many *nix systems and is considered the best
			// commonly available pseudo-random source.
		if ($fh = @fopen('/dev/urandom', 'rb')) {
			$output = fread($fh, $count);
			fclose($fh);
		}
			// If /dev/urandom is not available or returns no bytes, this loop will
			// generate a good set of pseudo-random bytes on any system.
			// Note that it may be important that our $random_state is passed
			// through md5() prior to being rolled into $output, that the two md5()
			// invocations are different, and that the extra input into the first one -
			// the microtime() - is prepended rather than appended.  This is to avoid
			// directly leaking $random_state via the $output stream, which could
			// allow for trivial prediction of further "random" numbers.
		while (!isset($output{$count - 1})) {
				// while (strlen($output) < $count)
			$random_state = md5(microtime() . mt_rand() . $random_state);
			$output .= md5(mt_rand() . $random_state, true);
		}
		return substr($output, 0, $count);
	}
}

?>
