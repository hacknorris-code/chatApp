create database if not exists micropost;
use micropost
create table if not exists posts (ID int auto_increment primary key, author tinytext, content longtext, time timestamp);
create table if not exists users (ID int auto_increment primary key, name tinytext, mail tinytext unique, password text, admin bool);
insert into users values (NULL,"admin","admin@localhost","admin",1);
