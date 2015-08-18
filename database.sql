
<!--  database memo -->
 create database user_dotinstall;

 grant all on user_dotinstall.* to dbuser@localhost identified by 'rwrwrwrw0521';


 use user_dotinstall;

 create table users (
 	id int not null auto_increment primary key,
 	name varchar(255),
 	email varchar(255) unique,
	password varchar(255),
	created datetime,
 	modified datetime
 );