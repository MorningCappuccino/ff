# Film Festival

## Deploy on remote server
### Issues
1. MariaDB to MySQL syntax
fix: remove DEFINER from DB dump

2. hostname/avatar/1.jpg not found
fix: delete .htacces from /avatar/ dir

3. hostname/madmin/ url get 404
fix: rename application/controller/mAdminController.php to mAdminController.php
or set apache settings to notCaseSensitive

4. on linux: when composer autoloader can't find class ajaxApplication - see key sensitive.
fix: rename file to AjaxApplication.php

##TODO
1. Add age rating and 2D-3D
2. Only 1 film name in Cinema
