<?php
/**
 * Magento
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magentocommerce.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Magento to newer
 * versions in the future. If you wish to customize Magento for your
 * needs please refer to http://www.magentocommerce.com for more information.
 *
 * @category   Mage
 * @package    Mage
 * @copyright  Copyright (c) 2008 Irubin Consulting Inc. DBA Varien (http://www.varien.com)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
echo "Cron starting...";

// Change current directory to the directory of current script
chdir(dirname(__FILE__));

require 'app/Mage.php';

if (!Mage::isInstalled()) {
    echo "Application is not installed yet, please complete install wizard first.";
    exit;
}

echo "Magento is installed...";

// Only for urls
// Don't remove this
$_SERVER['SCRIPT_NAME'] = str_replace(basename(__FILE__), 'index.php', $_SERVER['SCRIPT_NAME']);
$_SERVER['SCRIPT_FILENAME'] = str_replace(basename(__FILE__), 'index.php', $_SERVER['SCRIPT_FILENAME']);

Mage::app('admin')->setUseSessionInUrl(false);

umask(0);

echo "Initializing 1...";

$disabledFuncs = explode(',', ini_get('disable_functions'));
$isShellDisabled = is_array($disabledFuncs) ? in_array('shell_exec', $disabledFuncs) : true;
$isShellDisabled = (stripos(PHP_OS, 'win') === false) ? $isShellDisabled : true;
$isShellDisabled = true; /*lfb*/


echo "Initializing 2...";

try {
    if (stripos(PHP_OS, 'win') === false) {
        $options = getopt('m::');
        if (isset($options['m'])) {
            if ($options['m'] == 'always') {
                $cronMode = 'always';
		echo "Always...";

            } elseif ($options['m'] == 'default') {
                $cronMode = 'default';
		echo "Default...";

            } else {

		echo "Mode undefined...";
                Mage::throwException('Unrecognized cron mode was defined');
            }
        } else if (!$isShellDisabled) {
	    echo "Initializing 4...";
			$fileName = escapeshellarg(basename(__FILE__));
			$cronPath = escapeshellarg(dirname(__FILE__) . '/cron.sh');
			shell_exec(escapeshellcmd("/bin/sh $cronPath $fileName -mdefault 1 > /dev/null 2>&1 &"));
			shell_exec(escapeshellcmd("/bin/sh $cronPath $fileName -malways 1 > /dev/null 2>&1 &"));
            // echo "End...";
			exit;
        }
    }

echo "Executing...";

    Mage::getConfig()->init()->loadEventObservers('crontab');
    Mage::app()->addEventArea('crontab');
    if ($isShellDisabled) {
        Mage::dispatchEvent('always');
        Mage::dispatchEvent('default');
		/* Test cron lfb */
		$log = fopen(__FILE__.'.log', 'w');
		fwrite($log, date("Y-m-d H:i:s").PHP_EOL);
		fclose($log);
		/* End test lfb */
    } else {
        Mage::dispatchEvent($cronMode);
	echo "Initializing 5...";
    }
	
} catch (Exception $e) {
    Mage::printException($e);
    echo "Exception ".$e;	
    exit(1);
}
