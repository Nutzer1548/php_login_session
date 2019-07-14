drop table if exists users;
create table users(
	id int unsigned not null auto_increment,
	login_email varchar(255) not null ,
	login_pass char(255),

	register_date date not null,
	login_last_date date,

	flags tinyint unsigned default 0 not null, -- 0x01 = activated

	primary key (id),
	unique(login_email)
)default charset=utf8 collate=utf8_unicode_ci;

drop table if exists blocked_email;
create table blocked_email(
	email varchar(128) not null,
	added_date date,
	primary key(email)
)default charset=utf8 collate=utf8_unicode_ci;

drop table if exists task_activate_user;
create table task_activate_user(
	id int unsigned not null auto_increment,
	user_id int unsigned not null, -- id of the user-account that needs to be activated.
	verify_string varchar(128) not null,
	--
	primary key (id)
)default charset=utf8 collate=utf8_unicode_ci;


