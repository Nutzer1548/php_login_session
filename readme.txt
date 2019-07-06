desc:
=====
Codesnippet for a website login with mysql/mariadb and php sessions.
Ment to be modular and simple. Just to seperate/identify users.

How to use:
===========
- you need a webserver with support for php7 and mysql
- 
- install the mysql-tables. See db_table.sql, but delete possible demonstration values and/or add stuff you need.
- include the 'session.php' topmost in your php-pages (mainly index.php)
- 


important:
==========
secure 'db_config.php'

todo:
=====
- everthing in 'important'
- remove error_reporting / display errors from all files
- support for 'registering'
	- comparing with email-block-list
	- verification of email / registering user
- at least an option to seperate user_name from user_mail
- delete unactivated users after x days 
- study charsets in mysql/mariadb
- use php exception handling


done:
=====
Moved db_config, to subdir. Cleant comments in db.php.

