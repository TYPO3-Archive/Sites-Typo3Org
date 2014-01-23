typo3.org
=========

This repository contains files that are used to build a typo3.org TYPO3 installation.

The build relies on a (non-public) PHP script collection by AOE called "t3deploy". It's task
is to install a TYPO3 project. To put it briefly:

  t3deploy deploys the filesystem, the database and executes custom scripts

build/project.yml
-----------------

That file describes from where files and database records should be taken during deployment. Most notably,
extensions that should be installed are listed here.

For more see the inline documentation of build/project.yml

htdocs/
-------

A scaffold of files that are copied to the document root at the beginning of the deployment.
Some of them (like localconf.php) will be modified later on during deployment.

Most typo3 specific folders (like typo3temp, fileadmin etc) will be created by t3deploy automatically.

scripts/
--------

Those are generic scripts that will be executed at certain points during the deployment.

Scripts from pre-install.d will be executed before t3deploy does its magic, scripts from post-install.d afterwards.
The scripts are executed in their lexical order according to their filenames.

Tests/
------

Tests in this folder are NOT executed during deployment, but are used by Jenkins for the
test_*_unit and test_*_functional jobs.

Extension specific Unit Tests should be in the extension itself. They can be integrated into Jenkins, too.

other folders
-------------

All folders that have not been mentioned above are just storage folders that someone found useful, but are not part
of the deployment.