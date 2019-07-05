desc:
Codesnippet for a website login with mysql/mariadb and php sessions.
Ment to be modular and simple. Just to seperate/identify users.

important:
secure 'db_config.php'

todo:
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
- db_table.sql:
	- 'not null' for user flags
- 'pls' subfolder system
- session.php: only use $_SESSION as variable
- implemented 'register_account'-logic


