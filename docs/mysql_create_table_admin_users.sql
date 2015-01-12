/*
CREATE DATE : 23/12/2014
TABLE       : adm_users
*/
CREATE TABLE adm_users (
 cd_user         int(11)      NOT NULL      AUTO_INCREMENT,
 de_user         varchar(24)  NOT NULL     COMMENT 'username',
 de_name         varchar(30)  NOT NULL     COMMENT 'user full name',
 de_mail         varchar(45)  NOT NULL     COMMENT 'user email',
 de_pass         varchar(32)  NOT NULL     COMMENT 'user password',
 PRIMARY KEY (cd_user),
 UNIQUE KEY (de_user),
 UNIQUE KEY (de_mail)
)
ENGINE=InnoDB DEFAULT
CHARSET=utf8
COMMENT='Admin users of angular-login App';

