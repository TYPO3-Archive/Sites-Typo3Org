sed 's/\%%%replace_frontend_protokol_hostname%%%/http:\/\/www.t3o-2011.loc/g' database/full_complete.sql > tmp.sql && cat tmp.sql > database/full_complete.sql
sed 's/\%%%replace_frontend_hostname%%%/www.t3o-2011.loc/g' database/full_complete.sql > tmp.sql && cat tmp.sql > database/full_complete.sql
sed 's/\%%%replace_frontend_hostname%%%/www.t3o-2011.loc/g' filesystem/htdocs/typo3conf/localconf.php > tmp.php && cat tmp.php > filesystem/htdocs/typo3conf/localconf.php
sed 's/\%%%replace_backend_hostname%%%/www.t3o-2011.loc/g' filesystem/htdocs/typo3conf/domainconf.php > tmp.php && cat tmp.php > filesystem/htdocs/typo3conf/domainconf.php
sed 's/\%%%replace_sitename%%%/T3O Local/g' filesystem/htdocs/typo3conf/localconf.php > tmp.php && cat tmp.php > filesystem/htdocs/typo3conf/localconf.php
sed 's/\%%%replace_databaseusername%%%/t3o/g' filesystem/htdocs/typo3conf/localconf.php > tmp.php && cat tmp.php > filesystem/htdocs/typo3conf/localconf.php
sed 's/\%%%replace_databasepassword%%%/t3o/g' filesystem/htdocs/typo3conf/localconf.php > tmp.php && cat tmp.php > filesystem/htdocs/typo3conf/localconf.php
sed 's/\%%%replace_databasehost%%%/localhost/g' filesystem/htdocs/typo3conf/localconf.php > tmp.php && cat tmp.php > filesystem/htdocs/typo3conf/localconf.php
sed 's/\%%%replace_databasename%%%/t3o_2011/g' filesystem/htdocs/typo3conf/localconf.php > tmp.php && cat tmp.php > filesystem/htdocs/typo3conf/localconf.php
