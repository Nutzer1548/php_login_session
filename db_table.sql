-- demo-daten zum testen
-- todo: lern das mit den Zeichensätzen die hier verwenung finden (müssen)

drop table if exists users;
create table users(
	id int unsigned not null auto_increment,
	login_email varchar(255) collate utf8_unicode_ci not null ,
	login_pass char(255),
	register_date date not null,
	login_last_date date,
--	verify_string varchar(128) not null,

	flags tinyint unsigned default 0 not null, -- 0x01 = activated

	primary key (id),
	unique(login_email)
) default charset=utf8 collate=utf8_unicode_ci;

insert into users (login_email, login_pass, register_date) values
	('anton@localhost', '$2y$10$QNvFY9FFu88SCgDpUuTIvOaEXfj7UIREsywYQ1SBvj.7jGJ3aD4Qi', curdate()), -- password ist 123456
	('berta@localhost', '$2y$10$WVaoNUcRUUzqDRIMyUa6MOuHObGMMsiLh9uKK0M9/luY7Ob7jgcdW', curdate()); -- password ist qweasd

drop table if exists blocked_email;
create table blocked_email(
	email varchar(128) not null,
	added_date date,
	primary key(email)
);

insert into blocked_email (email, added_date) values
	('zebra@localhost', curdate());


drop table if exists task_activate_user;
create table task_activate_user(
	id int unsigned not null auto_increment,
	user_id int unsigned not null, -- id of the user-account that needs to be activated.
--	email varchar(255) collate utf8_unicode_ci not null,
	verify_string varchar(128) not null,
	--
	primary key (id)
) default charset=utf8 collate=utf8_unicode_ci;

insert into task_activate_user (user_id, verify_string) values
	(1,'yDsNMZiIKLJG9AW2giOeOZwHRt4em_Izk-RyUPBs');
