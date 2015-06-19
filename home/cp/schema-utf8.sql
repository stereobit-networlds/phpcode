
SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+02:00";

CREATE TABLE IF NOT EXISTS `cform` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `email` varchar(64) NOT NULL,
  `postform` text CHARACTER SET utf8,
  PRIMARY KEY (`id`),
  KEY `email` (`email`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='contact form messages'

CREATE TABLE IF NOT EXISTS `categories` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ctgid` int(10) unsigned NOT NULL DEFAULT '0',
  `ctgoutline` varchar(100) DEFAULT NULL,
  `ctgoutlnorder` varchar(100) DEFAULT NULL,
  `cat1` varchar(64) DEFAULT NULL,
  `cat2` varchar(128) DEFAULT NULL,
  `cat3` varchar(128) DEFAULT NULL,
  `cat4` varchar(128) DEFAULT NULL,
  `cat5` varchar(128) DEFAULT NULL,
  `cat01` varchar(128) DEFAULT NULL,
  `cat02` varchar(128) DEFAULT NULL,
  `cat03` varchar(128) DEFAULT NULL,
  `cat04` varchar(128) DEFAULT NULL,
  `cat05` varchar(128) DEFAULT NULL,
  `cat11` varchar(128) DEFAULT NULL,
  `cat12` varchar(128) DEFAULT NULL,
  `cat13` varchar(128) DEFAULT NULL,
  `cat14` varchar(128) DEFAULT NULL,
  `cat15` varchar(128) DEFAULT NULL,
  `active` tinyint(1) DEFAULT '1',
  `view` tinyint(1) DEFAULT '1',
  `search` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `cat1` (`cat1`),KEY `cat2` (`cat2`),KEY `cat3` (`cat3`),KEY `cat4` (`cat4`),KEY `cat5` (`cat5`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='categories table';

CREATE TABLE IF NOT EXISTS `custaddress` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ccode` varchar(128) NOT NULL,
  `active` tinyint(1) DEFAULT '0',
  `address` varchar(254) DEFAULT NULL,
  `area` varchar(254) DEFAULT NULL,
  `zip` varchar(64) DEFAULT NULL,
  `voice1` varchar(64) DEFAULT NULL,
  `voice2` varchar(64) DEFAULT NULL,
  `fax` varchar(64) DEFAULT NULL,
  `mail` varchar(64) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `ccode` (`ccode`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ;

CREATE TABLE IF NOT EXISTS `customers` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `active` smallint(6) DEFAULT '0',
  `code1` varchar(128) DEFAULT NULL,
  `code2` varchar(60) DEFAULT NULL,
  `name` varchar(128) DEFAULT NULL,
  `afm` varchar(64) DEFAULT NULL,
  `eforia` varchar(64) DEFAULT NULL,
  `prfid` int(11) DEFAULT NULL,
  `prfdescr` varchar(128) DEFAULT NULL,
  `street` varchar(128) DEFAULT NULL,
  `address` text,
  `number` varchar(64) DEFAULT NULL,
  `area` varchar(64) DEFAULT NULL,
  `zip` varchar(64) DEFAULT NULL,
  `city` varchar(64) DEFAULT NULL,
  `voice1` varchar(64) DEFAULT NULL,
  `voice2` varchar(64) DEFAULT NULL,
  `fax` varchar(64) DEFAULT NULL,
  `mail` varchar(64) DEFAULT NULL,
  `attr1` varchar(128) DEFAULT NULL,
  `attr2` varchar(128) DEFAULT NULL,
  `attr3` varchar(128) DEFAULT NULL,
  `attr4` varchar(128) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `code1` (`code1`,`code2`),
  KEY `name` (`name`),
  FULLTEXT KEY `attr1` (`attr1`,`attr2`,`attr3`,`attr4`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='customers table';

CREATE TABLE IF NOT EXISTS `forum_posts` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `member` varchar(20) DEFAULT NULL,
  `headline` varchar(55) DEFAULT NULL,
  `body` text,
  `date_posted` datetime DEFAULT NULL,
  `views` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='forum posts';

CREATE TABLE IF NOT EXISTS `forum_replies` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `member` varchar(20) NOT NULL DEFAULT '',
  `headline` varchar(55) NOT NULL DEFAULT '',
  `body` text NOT NULL,
  `date_posted` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='forum replies';

CREATE TABLE IF NOT EXISTS `mailqueue` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `timein` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `timeout` timestamp NULL DEFAULT '0000-00-00 00:00:00',
  `active` tinyint(1) DEFAULT '1',
  `sender` varchar(256) NOT NULL,
  `receiver` varchar(256) NOT NULL,
  `subject` varchar(256) DEFAULT NULL,
  `body` text,
  `altbody` text,
  `cc` text,
  `bcc` text,
  `ishtml` tinyint(1) DEFAULT NULL,
  `origin` text,
  `attachments` text,
  `user` varchar(256) DEFAULT NULL,
  `pass` varchar(256) DEFAULT NULL,
  `name` varchar(256) DEFAULT NULL,
  `server` varchar(256) DEFAULT NULL,
  `encoding` varchar(64) DEFAULT NULL,
  `reply` int(11) unsigned DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `mailstatus` text,
  `trackid` varchar(256) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='bulk mail queue' ;

CREATE TABLE IF NOT EXISTS `pattachments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(128) NOT NULL,
  `type` varchar(12) DEFAULT NULL,
  `lan` int(11) DEFAULT NULL,
  `data` text,
  PRIMARY KEY (`id`),
  KEY `code` (`code`,`type`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ;

CREATE TABLE IF NOT EXISTS `paypal` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `mc_gross` varchar(64) DEFAULT NULL,
  `addres_status` varchar(64) DEFAULT NULL,
  `payer_id` varchar(64) DEFAULT NULL,
  `tax` varchar(64) DEFAULT NULL,
  `address_street` varchar(64) DEFAULT NULL,
  `payment_date` varchar(64) DEFAULT NULL,
  `payment_status` varchar(64) DEFAULT NULL,
  `charset` varchar(64) DEFAULT NULL,
  `address_zip` varchar(64) DEFAULT NULL,
  `first_name` varchar(64) DEFAULT NULL,
  `mc_fee` varchar(64) DEFAULT NULL,
  `address_country_code` varchar(64) DEFAULT NULL,
  `address_name` varchar(64) DEFAULT NULL,
  `notify_version` varchar(64) DEFAULT NULL,
  `custom` varchar(64) DEFAULT NULL,
  `payer_status` varchar(64) DEFAULT NULL,
  `business` varchar(64) DEFAULT NULL,
  `address_country` varchar(64) DEFAULT NULL,
  `address_city` varchar(64) DEFAULT NULL,
  `quantity` varchar(64) DEFAULT NULL,
  `verify_sign` varchar(64) DEFAULT NULL,
  `payer_email` varchar(64) DEFAULT NULL,
  `txn_id` varchar(64) DEFAULT NULL,
  `payment_type` varchar(64) DEFAULT NULL,
  `last_name` varchar(64) DEFAULT NULL,
  `address_state` varchar(64) DEFAULT NULL,
  `receiver_email` varchar(64) DEFAULT NULL,
  `receiver_id` varchar(64) DEFAULT NULL,
  `txn_type` varchar(64) DEFAULT NULL,
  `item_name` varchar(64) DEFAULT NULL,
  `mc_currency` varchar(64) DEFAULT NULL,
  `item_number` varchar(64) DEFAULT NULL,
  `test_ipn` varchar(64) DEFAULT NULL,
  `payment_gross` varchar(64) DEFAULT NULL,
  `shipping` varchar(64) DEFAULT NULL,
  `payment_fee` varchar(64) DEFAULT NULL,
  `receipt_id` varchar(64) DEFAULT NULL,
  `payer_business_name` varchar(64) DEFAULT NULL,
  `residence_country` varchar(64) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='paypal transactions';

CREATE TABLE IF NOT EXISTS `ppolicy` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `code1` varchar(128) DEFAULT NULL,
  `code2` int(10) DEFAULT NULL,
  `name` varchar(128) DEFAULT NULL,
  `discount` double NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `code1` (`code1`,`code2`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='customers price policy';

CREATE TABLE IF NOT EXISTS `products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code1` int(11) DEFAULT NULL,
  `code2` int(11) DEFAULT NULL,
  `code3` varchar(64) DEFAULT NULL,
  `code4` varchar(64) DEFAULT NULL,
  `code5` varchar(64) DEFAULT NULL,
  `itmname` varchar(128) DEFAULT NULL,
  `itmactive` tinyint(4) DEFAULT NULL,
  `itmfname` varchar(128) DEFAULT NULL,
  `itmremark` text,
  `itmdescr` text,
  `itmfdescr` text,
  `sysins` datetime DEFAULT '0000-00-00 00:00:00',
  `sysupd` datetime DEFAULT NULL,
  `uniida` int(11) DEFAULT '0',
  `uniname1` varchar(64) DEFAULT NULL,
  `uniname2` varchar(64) DEFAULT NULL,
  `uni1uni2` float DEFAULT '0',
  `uni2uni1` float DEFAULT '0',
  `ypoloipo1` float DEFAULT '0',
  `ypoloipo2` float DEFAULT '0',
  `price0` float DEFAULT '0',
  `price1` float DEFAULT '0',
  `cat0` varchar(128) DEFAULT NULL,
  `cat1` varchar(128) DEFAULT NULL,
  `cat2` varchar(128) DEFAULT NULL,
  `cat3` varchar(128) DEFAULT NULL,
  `cat4` varchar(128) DEFAULT NULL,
  `active` tinyint(4) DEFAULT '0',
  `price2` float DEFAULT '0',
  `pricepc` float DEFAULT '0',
  `p1` text,
  `p2` text,
  `p3` text,
  `p4` text,
  `p5` text,
  `resources` text CHARACTER SET utf8,
  `weight` float DEFAULT NULL,
  `volume` float DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `code1` (`code1`,`code2`,`code3`,`code4`,`code5`),
  KEY `itmname` (`itmname`),KEY `cat0` (`cat0`),KEY `cat1` (`cat1`),KEY `cat2` (`cat2`),KEY `cat3` (`cat3`),KEY `cat4` (`cat4`),
  FULLTEXT KEY `itmremark` (`itmremark`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='products table';

DROP TABLE IF EXISTS `ptags`;
CREATE TABLE IF NOT EXISTS `ptags` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(128) CHARACTER SET utf8 NOT NULL,
  `tag` varchar(128) NOT NULL,
  `keywords0` varchar(128) NOT NULL,
  `keywords1` varchar(128) CHARACTER SET utf8 NOT NULL,
  `keywords2` varchar(128) NOT NULL,
  `descr0` varchar(128) NOT NULL,
  `descr1` varchar(128) CHARACTER SET utf8 NOT NULL,
  `descr2` varchar(128) NOT NULL,
  `title0` varchar(128) NOT NULL,
  `title1` varchar(128) CHARACTER SET utf8 NOT NULL,
  `title2` varchar(128) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `code` (`code`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='product and categories tags';


CREATE TABLE IF NOT EXISTS `stats` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `date` date DEFAULT NULL,
  `day` int(11) DEFAULT NULL,
  `month` int(11) DEFAULT NULL,
  `year` int(11) DEFAULT NULL,
  `vid` int(11) DEFAULT NULL,
  `tid` varchar(64) DEFAULT NULL,
  `attr1` varchar(254) DEFAULT NULL,
  `attr2` varchar(254) DEFAULT NULL,
  `attr3` varchar(254) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `vid` (`vid`),
  KEY `tid` (`tid`),
  KEY `vid_2` (`vid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='item statistics';

CREATE TABLE IF NOT EXISTS `syncsql` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `fid` int(11) DEFAULT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date` datetime DEFAULT NULL,
  `execdate` datetime DEFAULT NULL,
  `status` smallint(6) NOT NULL DEFAULT '0',
  `sqlquery` text CHARACTER SET utf8,
  `sqlres` text CHARACTER SET utf8,
  `reference` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='synchronize sql tables';

CREATE TABLE IF NOT EXISTS `transactions` (
  `recid` int(11) NOT NULL AUTO_INCREMENT,
  `tid` varchar(64) NOT NULL DEFAULT '',
  `cid` varchar(60) NOT NULL DEFAULT '0',
  `tdate` date NOT NULL DEFAULT '0000-00-00',
  `ttime` time NOT NULL DEFAULT '00:00:00',
  `tdata` text NOT NULL,
  `tstatus` smallint(6) NOT NULL DEFAULT '0',
  `type1` varchar(256) NOT NULL,
  `type2` varchar(256) NOT NULL,
  `payway` varchar(64) DEFAULT NULL,
  `roadway` varchar(64) DEFAULT NULL,
  `qty` int(11) DEFAULT '0',
  `cost` double DEFAULT NULL,
  `costpt` double DEFAULT NULL,
  PRIMARY KEY (`recid`),
  UNIQUE KEY `tid` (`tid`),
  KEY `cid` (`cid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='transaction table';

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code1` varchar(60) DEFAULT NULL,
  `code2` varchar(60) DEFAULT NULL,
  `ageid` tinyint(4) DEFAULT NULL,
  `clogon` varchar(128) DEFAULT NULL,
  `cntryid` int(11) DEFAULT NULL,
  `email` varchar(128) DEFAULT NULL,
  `fname` varchar(128) DEFAULT NULL,
  `genid` tinyint(4) DEFAULT NULL,
  `ipins` int(11) DEFAULT NULL,
  `ipupd` int(11) DEFAULT NULL,
  `lanid` int(11) DEFAULT NULL,
  `lastlogon` datetime DEFAULT NULL,
  `lname` varchar(128) DEFAULT NULL,
  `notes` text,
  `seclevid` tinyint(4) DEFAULT NULL,
  `secparam` varchar(128) DEFAULT NULL,
  `sesid` text,
  `sesdata` text,
  `startdate` datetime DEFAULT NULL,
  `subscribe` tinyint(4) DEFAULT NULL,
  `username` varchar(64) DEFAULT NULL,
  `password` varchar(64) DEFAULT NULL,
  `vpass` varchar(64) DEFAULT NULL,
  `timezone` varchar(128) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `code1` (`code1`,`code2`,`email`,`username`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='customers table';

DROP TABLE IF EXISTS `wishlist`;
CREATE TABLE IF NOT EXISTS `wishlist` (
  `recid` int(11) NOT NULL AUTO_INCREMENT,
  `tid` varchar(64) NOT NULL DEFAULT '',
  `cid` varchar(60) NOT NULL DEFAULT '0',
  `listname` varchar(64) NOT NULL DEFAULT 'noname',
  `tdate` date NOT NULL DEFAULT '0000-00-00',
  `ttime` time NOT NULL DEFAULT '00:00:00',
  `tdata` text NOT NULL,
  `tstatus` smallint(6) NOT NULL DEFAULT '0',
  PRIMARY KEY (`recid`),
  UNIQUE KEY `tid` (`tid`),
  KEY `cid` (`cid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='wishlist table';

DROP TABLE IF EXISTS `standartmail`;
CREATE TABLE IF NOT EXISTS `standartmail` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `weight` float NOT NULL,
  `volume` float NOT NULL,
  `zone` varchar(10) NOT NULL,
  `cost` float NOT NULL,
  PRIMARY KEY (`id`),
  KEY `weight` (`weight`),
  KEY `zone` (`zone`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='standart mail cost array'  ;
