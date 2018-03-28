/**
 * @Author: Thibault Napoléon <Imothep>
 * @Company: ISEN Yncréa Ouest
 * @Email: thibault.napoleon@isen-ouest.yncrea.fr
 * @Created Date: 29-Jan-2018 - 21:08:44
 * @Last Modified: 05-Feb-2018 - 23:32:16
 */

#-------------------------------------------------------------------------------
#--- Change database -----------------------------------------------------------
#-------------------------------------------------------------------------------
use cw_cir2;

#-------------------------------------------------------------------------------
#--- Database cleanup ----------------------------------------------------------
#-------------------------------------------------------------------------------
drop table if exists twitts;

#-------------------------------------------------------------------------------
#--- Database creation ---------------------------------------------------------
#-------------------------------------------------------------------------------
create table twitts
(
	id int not null auto_increment,
	text varchar(80) not null,
	login varchar(20) not null,
	primary key(id)
)
engine = innodb;

#-------------------------------------------------------------------------------
#--- Populate databases --------------------------------------------------------
#-------------------------------------------------------------------------------
insert into twitts(text, login) values('Un twitt des CIR1 !!', 'cir1');
insert into twitts(text, login) values('Un twitt des CIR2 !!', 'cir2');
insert into twitts(text, login) values('Un twitt des CIR3 !!', 'cir3');

set autocommit = 0;
set names utf8;
