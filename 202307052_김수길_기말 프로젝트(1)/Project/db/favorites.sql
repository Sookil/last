create table favorites(
    num int auto_increment,
    id char(15) not null,
    mana_num int not null,
    subject char(200) not null,
    board_id char(15) not null,
    regist_day char(20) not null,
    primary key(num),
    constraint mana_numkf
	foreign key (mana_num)
	references board(num)
	on delete cascade
);




