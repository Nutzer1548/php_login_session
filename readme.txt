desc:
=====
Codesnippet for a website login with mysql/mariadb and php sessions.
Ment to be modular and simple. Just to seperate/identify users.

important
=========
not ready to use. still in development.


How to use:
===========
- you need a webserver with support for php7 and mysql
- 
- install the mysql-tables. See db_table.sql, but delete possible demonstration values and/or add stuff you need.
- include the 'session.php' topmost in your php-pages (mainly index.php)
- 



todo:
=====
[ ] remove error_reporting / display errors from all files
[ ] at least an option to seperate user_name from user_mail
[ ] delete unactivated users after x days 
[ ] study charsets in mysql/mariadb
[ ] use php exception handling
[ ] add template for registration-email.
[ ] implement banning

done:
=====
added config.php with global $PLS holding page-urls
[x] support for 'registering'
	[x] comparing with email-block-list
