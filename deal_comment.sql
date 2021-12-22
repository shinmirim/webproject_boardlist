create table dealcomment(
   num int not null auto_increment,
   boardnum int not null,
   id char(15) not null,
   name char(10) not null,
   content text not null, 
   regist_day char(20) not null,       
   primary key(num)
);

