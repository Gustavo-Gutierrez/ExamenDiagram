create database proy1;
 use proy1;

create table noter( 
 dgdfgdfg fsdfsd, 
 primary key() 
 );
create table carlos( 
 dgdfhdfgsdfgsd ghg, 
 primary key() 
 );
create table jorge( 
 sdgf fghfgj, 
 primary key() 
 );
create table Class( 
 sdor int,
 nr_noter  float 
primary key(sdor), 
 FOREIGN KEY (nr_noter) REFERENCES noter(nr) ON DELETE CASCADE  ON UPDATE CASCADE);
