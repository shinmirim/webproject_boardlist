create table dealboard (
   num int not null auto_increment,
   id char(15) not null,
   name char(10) not null,
   subject char(200) not null,
   content text not null,     
   productname char(200) not null,
   realprice int,
   sellprice int not null,
   status char(20) not null default 'sale',
   buyerid char(15),
   regist_day char(20) not null,
   hit int not null,
   file_name char(40),
   file_type char(40),
   file_copied char(40),
   primary key(num)
);

