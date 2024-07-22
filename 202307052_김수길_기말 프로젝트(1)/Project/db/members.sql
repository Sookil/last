create table members (
  num int(11) NOT NULL,
  id char(15) NOT NULL,
  pass char(15) NOT NULL,
  name char(10) NOT NULL,
  age int(11) NOT NULL,
  phone varchar(20) NOT NULL,
  gender char(10) NOT NULL,
  address text NOT NULL,
  hobbies text NOT NULL,
  introduction text DEFAULT NULL,
  file_name char(40) DEFAULT NULL,
  file_type char(40) DEFAULT NULL,
  file_copied char(40) DEFAULT NULL,
  musician varchar(255) DEFAULT NULL,
  regist_day datetime DEFAULT NULL,
  level int(11) DEFAULT NULL
);