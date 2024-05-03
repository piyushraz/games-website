drop table appuser cascade;

create table appuser (
	userid varchar(50) primary key,
	password varchar(50)
	favorite_color VARCHAR(50),
    favorite_number INT,
    favorite_game VARCHAR(50),S
);

insert into appuser values('auser', 'apassword');

