CREATE TABLE `adminsettings` (
`id` integer unsigned not null primary key auto_increment,
`adminuser` varchar(255) not null,
`adminpass` varchar(255) not null,
`adminname` varchar(255) not null,
`adminemail` varchar(300) not null,
`adminpaypal` varchar(300) not null,
`admincoinpayments` varchar(300) not null,
`admincoinpaymentsapikey` varchar(300) not null,
`admincoinpaymentsapisecret` varchar(300) not null,
`admincoinpaymentspublickey` varchar(300) not null,
`admincoinpaymentsprivatekey` varchar(300) not null,
`sitename` varchar(255) not null,
`domain` varchar(300) not null,
`metatitle` varchar(60) not null,
`metadescription` varchar(160) not null,
`downloadsfolder` varchar(300) not null default '/downloads/',
`adminautoapprove` tinyint(1) not null default '0',
`clicktimer` integer unsigned not null default '0',
`textadprice` decimal(9, 2) not null default '2.00',
`textadhits` integer unsigned not null default '2000',
`bannerprice` decimal(9, 2) not null default '2.00',
`bannerhits` integer unsigned not null default '2000',
`networksoloprice` decimal(9, 2) not null default '5.00',

`freebannerclickstosignup` integer unsigned not null default 8,
`freebannerslots` varchar(32) not null default '1,2,3',
`freerefersfreedownlineupgradestogetbonus` integer unsigned not null default '5',
`freerefersfreedownlineupgradesbonusslots` varchar(32) not null default '3',
`freerefersprodownlineupgradestogetbonus` integer unsigned not null default '8',
`freerefersprodownlineupgradesbonusslots` varchar(32) not null default '4',
`freerefersgolddownlineupgradestogetbonus` integer unsigned not null default '0',
`freerefersgolddownlineupgradesbonusslots` varchar(32) not null default '',
`freerefersfreebannerslots1` varchar(32) not null default '4,5,6,7,8,11',
`freerefersprobannerslots1` varchar(32) not null default '7,8,11',
`freerefersgoldbannerslots1` varchar(32) not null default '11',
`freerefersfreebannerslots2` varchar(32) not null default '',
`freerefersprobannerslots2` varchar(32) not null default '',
`freerefersgoldbannerslots2` varchar(32) not null default '',
`freerefersfreebannerslots3` varchar(32) not null default '',
`freerefersprobannerslots3` varchar(32) not null default '',
`freerefersgoldbannerslots3` varchar(32) not null default '',
`freerefersfreebannerslots4` varchar(32) not null default '',
`freerefersprobannerslots4` varchar(32) not null default '',
`freerefersgoldbannerslots4` varchar(32) not null default '',
`freerefersfreebannerslots5` varchar(32) not null default '',
`freerefersprobannerslots5` varchar(32) not null default '',
`freerefersgoldbannerslots5` varchar(32) not null default '',
`freerefersfreebannerslots6` varchar(32) not null default '',
`freerefersprobannerslots6` varchar(32) not null default '',
`freerefersgoldbannerslots6` varchar(32) not null default '',
`freerefersproearn` decimal(9,2) not null default 4.00,
`freerefersgoldearn` decimal(9,2) not null default 6.00,
`freesignupbonustextads` integer unsigned not null default '0',
`freesignupbonusbannerspaid` integer unsigned not null default '0',
`freesignupbonusnetworksolos` integer unsigned not null default '0',
`freemonthlybonustextads` integer unsigned not null default '0',
`freemonthlybonusbannerspaid` integer unsigned not null default '0',
`freemonthlybonusnetworksolos` integer unsigned not null default '0',
`freeadclickstogettextad` integer unsigned not null default '100',
`freeadclickstogetbannerspaid` integer unsigned not null default '100',
`freeadclickstogetnetworksolo` integer unsigned not null default '100',

`proprice` decimal(9, 2) not null default 5.99,
`propayinterval` varchar(12) not null default 'monthly',
`probannerclickstosignup` integer unsigned not null default 5,
`probannerslots` varchar(32) not null default '1,2,3,4,5,6',
`prorefersfreedownlineupgradestogetbonus` integer unsigned not null default '5',
`prorefersfreedownlineupgradesbonusslots` varchar(32) not null default '3',
`prorefersprodownlineupgradestogetbonus` integer unsigned not null default '8',
`prorefersprodownlineupgradesbonusslots` varchar(32) not null default '4',
`prorefersgolddownlineupgradestogetbonus` integer unsigned not null default '0',
`prorefersgolddownlineupgradesbonusslots` varchar(32) not null default '',
`prorefersfreebannerslots1` varchar(32) not null default '4,5,6,7,8,11',
`prorefersprobannerslots1` varchar(32) not null default '7,8,11',
`prorefersgoldbannerslots1` varchar(32) not null default '11',
`prorefersfreebannerslots2` varchar(32) not null default '',
`prorefersprobannerslots2` varchar(32) not null default '',
`prorefersgoldbannerslots2` varchar(32) not null default '',
`prorefersfreebannerslots3` varchar(32) not null default '',
`prorefersprobannerslots3` varchar(32) not null default '',
`prorefersgoldbannerslots3` varchar(32) not null default '',
`prorefersfreebannerslots4` varchar(32) not null default '',
`prorefersprobannerslots4` varchar(32) not null default '',
`prorefersgoldbannerslots4` varchar(32) not null default '',
`prorefersfreebannerslots5` varchar(32) not null default '',
`prorefersprobannerslots5` varchar(32) not null default '',
`prorefersgoldbannerslots5` varchar(32) not null default '',
`prorefersfreebannerslots6` varchar(32) not null default '',
`prorefersprobannerslots6` varchar(32) not null default '',
`prorefersgoldbannerslots6` varchar(32) not null default '',
`prorefersproearn` decimal(9,2) not null default 6.00,
`prorefersgoldearn` decimal(9,2) not null default 8.00,
`prosignupbonustextads` integer unsigned not null default '1',
`prosignupbonusbannerspaid` integer unsigned not null default '1',
`prosignupbonusnetworksolos` integer unsigned not null default '0',
`promonthlybonustextads` integer unsigned not null default '1',
`promonthlybonusbannerspaid` integer unsigned not null default '1',
`promonthlybonusnetworksolos` integer unsigned not null default '0',
`proadclickstogettextad` integer unsigned not null default '100',
`proadclickstogetbannerspaid` integer unsigned not null default '100',
`proadclickstogetnetworksolo` integer unsigned not null default '100',

`goldprice` decimal(9, 2) not null default '9.99',
`goldpayinterval` varchar(12) not null default 'monthly',
`goldbannerclickstosignup` integer unsigned not null default 3,
`goldbannerslots` varchar(32) not null default '1,2,3,4,5,6,7,8',
`goldrefersfreedownlineupgradestogetbonus` integer unsigned not null default '5',
`goldrefersfreedownlineupgradesbonusslots` varchar(32) not null default '3',
`goldrefersprodownlineupgradestogetbonus` integer unsigned not null default '8',
`goldrefersprodownlineupgradesbonusslots` varchar(32) not null default '4',
`goldrefersgolddownlineupgradestogetbonus` integer unsigned not null default '0',
`goldrefersgolddownlineupgradesbonusslots` varchar(32) not null default '',
`goldrefersfreebannerslots1` varchar(32) not null default '4,5,6,7,8,11',
`goldrefersprobannerslots1` varchar(32) not null default '7,8,11',
`goldrefersgoldbannerslots1` varchar(32) not null default '11',
`goldrefersfreebannerslots2` varchar(32) not null default '',
`goldrefersprobannerslots2` varchar(32) not null default '',
`goldrefersgoldbannerslots2` varchar(32) not null default '',
`goldrefersfreebannerslots3` varchar(32) not null default '',
`goldrefersprobannerslots3` varchar(32) not null default '',
`goldrefersgoldbannerslots3` varchar(32) not null default '',
`goldrefersfreebannerslots4` varchar(32) not null default '',
`goldrefersprobannerslots4` varchar(32) not null default '',
`goldrefersgoldbannerslots4` varchar(32) not null default '',
`goldrefersfreebannerslots5` varchar(32) not null default '',
`goldrefersprobannerslots5` varchar(32) not null default '',
`goldrefersgoldbannerslots5` varchar(32) not null default '',
`goldrefersfreebannerslots6` varchar(32) not null default '',
`goldrefersprobannerslots6` varchar(32) not null default '',
`goldrefersgoldbannerslots6` varchar(32) not null default '',
`goldrefersproearn` decimal(9,2) not null default 8.00,
`goldrefersgoldearn` decimal(9,2) not null default 10.00,
`goldsignupbonustextads` integer unsigned not null default '2',
`goldsignupbonusbannerspaid` integer unsigned not null default '2',
`goldsignupbonusnetworksolos` integer unsigned not null default '1',
`goldmonthlybonustextads` integer unsigned not null default '2',
`goldmonthlybonusbannerspaid` integer unsigned not null default '2',
`goldmonthlybonusnetworksolos` integer unsigned not null default '1',
`goldadclickstogettextad` integer unsigned not null default '100',
`goldadclickstogetbannerspaid` integer unsigned not null default '100',
`goldadclickstogetnetworksolo` integer unsigned not null default '100'

) ENGINE=MyISAM DEFAULT CHARSET=latin1;

CREATE TABLE `adminnotes` (
`id` int(11) NOT NULL primary key auto_increment,
`name` varchar(25) NOT NULL default '',
`htmlcode` longtext NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

CREATE TABLE `bannermaker` (
  `id` int(10) UNSIGNED NOT NULL primary key auto_increment,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `filename` varchar(255) COLLATE utf8_unicode_ci NOT NULL unique,
  `htmlcode` longtext COLLATE utf8_unicode_ci NOT NULL,
  `width` int(11) NOT NULL DEFAULT '1000',
  `height` int(11) NOT NULL DEFAULT '300',
  `bgcolor` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'transparent',
  `bgimage` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'none',
  `bordercolor` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'transparent',
  `borderwidth` int(11) NOT NULL DEFAULT '0',
  `borderstyle` varchar(12) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'solid',
  `adddate` datetime not null,
   foreign key (`username`) references `members`(`username`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `bannermakerimageuploads` (
`id` int(10) UNSIGNED NOT NULL primary key auto_increment,
`username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
`filename` varchar(255) NOT NULL DEFAULT '',
`filesize` int(11) NOT NULL DEFAULT '0',
`filetype` varchar(255) NOT NULL DEFAULT '',
`adddate` datetime not null,
foreign key (`username`) references `members`(`username`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

create table `bannerspaid` (
`id` integer unsigned not null primary key auto_increment,
`username` varchar(255) not null default 'admin',
`name` varchar(255) not null,
`alt` varchar(255) not null,
`url` varchar(300) not null,
`shorturl` varchar(255) not null,
`imageurl` varchar(300) not null,
`added` tinyint(1) not null default '0',
`approved` tinyint(1) not null default '0',
`hits` integer unsigned not null default '0',
`clicks` integer unsigned not null default '0',
`adddate` datetime not null
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

CREATE TABLE `countries` (
`country_id` int(11) not null primary key auto_increment,
`country_name` varchar(64) not null DEFAULT '',
`iso_code2` char(2) not null DEFAULT '',
`iso_code3` char(3) not null DEFAULT '',
`reserved1` int(11) not null DEFAULT '0',
KEY `IDX_COUNTRIES_NAME` (`country_name`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

CREATE TABLE `downloadaccess` (
`id` int(10) UNSIGNED NOT NULL primary key auto_increment,
`downloadid` int(10) UNSIGNED NOT NULL,
`username` varchar(255) NOT NULL,
`dategiven` datetime NOT NULL,
KEY downloadaccess_downloadid_foreign (id)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

CREATE TABLE `downloads` (
`id` int(10) UNSIGNED NOT NULL primary key auto_increment,
`name` varchar(255) NOT NULL DEFAULT '',
`type` varchar(255) NOT NULL DEFAULT 'link',
`description` longtext NOT NULL,
`url` varchar(255) NOT NULL,
`file` varchar(255) NOT NULL DEFAULT '',
`filesize` int(11) NOT NULL DEFAULT '0',
`filetype` varchar(255) NOT NULL DEFAULT '',
`dateadded` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

CREATE TABLE `faqs` (
`id` int(10) UNSIGNED NOT NULL primary key auto_increment,
`question` text COLLATE utf8_unicode_ci NOT NULL,
`answer` text COLLATE utf8_unicode_ci NOT NULL,
`positionnumber` int(11) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE mail (
`id` int(10) unsigned not null primary key auto_increment,
username varchar(255) not null default 'admin',
`subject` varchar(255) not null,
message longtext not null,
url varchar(255) not null,
needtosend tinyint(1) not null default '0',
sent datetime DEFAULT NULL,
clicks int(11) not null default '0',
save tinyint(1) not null default '0',
KEY mail_username_foreign (username)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

create table members (
id integer unsigned not null primary key auto_increment,
username varchar(255) not null unique,
password varchar(255) not null,
accounttype varchar(4) not null default 'Free',
firstname varchar(255) not null,
lastname varchar(255) not null,
country varchar(255) not null,
email varchar(300) not null,
paypal varchar(300) not null,
bitcoin varchar(300) not null,
signupdate datetime not null,
signupip varchar(255) not null,
verificationcode varchar(255) not null,
verified varchar(255) not null,
referid varchar(255) not null,
lastlogin datetime not null,
textadclicks integer unsigned not null default '0',
banneradclicks integer unsigned not null default '0',
networksoloclicks integer unsigned not null default '0',
owed decimal(9,2) not null default 0.00,
paid decimal(9,2) not null default 0.00
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

create table `networksolos` (
`id` integer unsigned not null primary key auto_increment,
`username` varchar(255) not null default 'admin',
`name` varchar(255) not null,
`subject` varchar(255) not null,
`url` varchar(300) not null,
`shorturl` varchar(255) not null,
`message` longtext not null,
`added` tinyint(1) not null default '0',
`approved` tinyint(1) not null default '0',
`sent` varchar(30) not null default 'Not Yet',
`clicks` integer unsigned not null default '0',
`adddate` datetime not null
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

CREATE TABLE `pages` (
`id` int(10) unsigned not null primary key auto_increment,
`name` varchar(255) not null,
`htmlcode` longtext not null,
`slug` varchar(255) not null,
`core` varchar(4) not null default 'no',
UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

CREATE TABLE `pendingpurchases` (
`id` int(10) unsigned not null primary key auto_increment,
`formfields` text not null,
`dateadded` datetime default null,
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

CREATE TABLE `promotional` (
`id` int(10) unsigned not null primary key auto_increment,
`name` varchar(255) NOT NULL,
`type` varchar(255) NOT NULL DEFAULT 'banner',
`promotionalimage` varchar(300) NOT NULL,
`promotionalsubject` varchar(255) NOT NULL,
`promotionaladbody` longtext NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

create table `textads` (
`id` integer unsigned not null primary key auto_increment,
`username` varchar(255) not null default 'admin',
`name` varchar(255) not null,
`title` varchar(255) not null,
`url` varchar(300) not null,
`shorturl` varchar(255) not null,
`description` varchar(255) not null,
`imageurl` varchar(300) not null,
`added` tinyint(1) not null default '0',
`approved` tinyint(1) not null default '0',
`hits` integer unsigned not null default '0',
`clicks` integer unsigned not null default '0',
`adddate` datetime not null
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

# Membership upgrades do not have adid so that can be null.
create table transactions (
id integer unsigned not null primary key auto_increment,
adid integer unsigned null,
item varchar(255) not null,
username varchar(255) not null,
amount decimal(9,2) not null default '0.00',
datepaid varchar(255) null,
paymethod varchar(255) null,
transaction varchar(255) null,
foreign key (adid) references ads(id)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

create table `viralbanners` (
`id` integer unsigned not null primary key auto_increment,
`username` varchar(255) not null default 'admin',
`name` varchar(255) not null,
`alt` varchar(255) not null,
`url` varchar(300) not null,
`shorturl` varchar(255) not null,
`imageurl` varchar(300) not null,
`added` tinyint(1) not null default '0',
`approved` tinyint(1) not null default '0',
`hits` integer unsigned not null default '0',
`clicks` integer unsigned not null default '0',
`adddate` datetime not null,
`bannerpageslot` integer unsigned not null default '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

insert into adminsettings (adminuser, adminpass, adminname, adminemail, sitename, domain, metatitle, metadescription) values ('Admin', 'admin', 'YOUR NAME', 'YOUR ADMIN EMAIL', 'YOUR SITE NAME','http://YOURDOMAIN.COM', 'YOUR SITE META TITLE', 'YOUR SITE META DESCRIPTION');

INSERT INTO `adminnotes` (`id`, `name`, `htmlcode`) values (1, 'Admin Notes', '');

INSERT INTO pages (name, htmlcode, slug, core) values ('Home Page', '', '', 'yes');
INSERT INTO pages (name, htmlcode, slug, core) values ('Login Page', '', 'login', 'yes');
INSERT INTO pages (name, htmlcode, slug, core) values ('Members Area Main Page', '', 'members', 'yes');
INSERT INTO pages (name, htmlcode, slug, core) values ('Members Area Profile Page', '', 'profile', 'yes');
INSERT INTO pages (name, htmlcode, slug, core) values ('Members Area Promotion Page', '', 'promotion', 'yes');
INSERT INTO pages (name, htmlcode, slug, core) values ('Members Area Text Ads Page', '', 'ads', 'yes');
INSERT INTO pages (name, htmlcode, slug, core) values ('Members Area Paid Banner Ads Page', '', 'bannerspaid', 'yes');
INSERT INTO pages (name, htmlcode, slug, core) values ('Members Area Viral Banners Page', '', 'viralbanners', 'yes');
INSERT INTO pages (name, htmlcode, slug, core) values ('Members Area Network Solos Page', '', 'networksolos', 'yes');
INSERT INTO pages (name, htmlcode, slug, core) values ('Members Area Banner Maker Page', '', 'imagemaker', 'yes');
INSERT INTO pages (name, htmlcode, slug, core) values ('Members Area Downloads Page', '', 'downloads', 'yes');
INSERT INTO pages (name, htmlcode, slug, core) values ('Registration Page', '', 'register', 'yes');
INSERT INTO pages (name, htmlcode, slug, core) values ('Thank You Page - New Member Signup', '<h4 align="center">Thank you so much for your membership purchase!</h4><br>', 'thankyou', 'yes');
INSERT INTO pages (name, htmlcode, slug, core) values ('Logout Page', '', 'logout', 'yes');
INSERT INTO pages (name, htmlcode, slug, core) values ('About Us Page', '', 'aboutus', 'yes');
INSERT INTO pages (name, htmlcode, slug, core) values ('Terms Page', '', 'terms', 'yes');
INSERT INTO pages (name, htmlcode, slug, core) values ('FAQ Page', '', 'faq', 'yes');
INSERT INTO pages (name, htmlcode, slug, core) values ('404 Page', 'Your custom 404 content here!', '404', 'yes');

UPDATE `pages` SET `htmlcode` = '<h4>CONDITIONS OF USE</h4>\r\n<p>Welcome to our program!&nbsp;~SITENAME~&nbsp;and its associates provide their services to you subject to the following conditions. If you visit or shop within this website, you accept these conditions. Please read them carefully.</p>\r\n<h4>PRIVACY</h4>\r\n<p>Please review our Privacy Notice, which also governs your visit to our website, to understand our practices.</p>\r\n<h4>ELECTRONIC COMMUNICATIONS</h4>\r\n<p>When you visit ~SITENAME~ or send e-mails to us, you are communicating with us electronically. You consent to receive communications from us electronically. We will communicate with you by e-mail or by posting notices on this site. You agree that all agreements, notices, disclosures and other communications that we provide to you electronically satisfy any legal requirement that such communications be in writing.</p>\r\n<h4>COPYRIGHT</h4>\r\n<p>All content included on this site, such as text, graphics, logos, button icons, images, audio clips, digital downloads, data compilations, and software, is the property of ~SITENAME~ or its content suppliers and protected by international copyright laws. The compilation of all content on this site is the exclusive property of ~SITENAME~, with copyright authorship for this collection by ~SITENAME~, and protected by international copyright laws.</p>\r\n<h4>LICENSE AND SITE ACCESS</h4>\r\n<p>~SITENAME~ grants you a limited license to access and make personal use of this site and not to download (other than page caching) or modify it, or any portion of it, except with express written consent of ~SITENAME~. This license does not include any resale or commercial use of this site or its contents: any collection and use of any product listings, descriptions, or prices: any derivative use of this site or its contents: any downloading or copying of account information for the benefit of another merchant: or any use of data mining, robots, or similar data gathering and extraction tools. This site or any portion of this site may not be reproduced, duplicated, copied, sold, resold, visited, or otherwise exploited for any commercial purpose without express written consent of ~SITENAME~. You may not frame or utilize framing techniques to enclose any trademark, logo, or other proprietary information (including images, text, page layout, or form) of ~SITENAME~ and our associates without express written consent. You may not use any meta tags or any other \"hidden text\" utilizing the ~SITENAME~ name or trademarks without the express written consent of ~SITENAME~. Any unauthorized use terminates the permission or license granted by ~SITENAME~. You are granted a limited, revocable, and nonexclusive right to create a hyperlink to the home page of ~SITENAME~ so long as the link does not portray ~SITENAME~, its associates, or their products or services in a false, misleading, derogatory, or otherwise offensive matter. You may not use any ~SITENAME~ logo or other proprietary graphic or trademark as part of the link without express written permission.</p>\r\n<h4>YOUR MEMBERSHIP ACCOUNT</h4>\r\n<p>If you use this site, you are responsible for maintaining the confidentiality of your account and password and for restricting access to your computer, and you agree to accept responsibility for all activities that occur under your account or password. If you are under 18, you may use our website only with involvement of a parent or guardian. ~SITENAME~ and its associates reserve the right to refuse service, terminate accounts, remove or edit content, or cancel orders in their sole discretion.</p>\r\n<h4>EARNINGS</h4>
<p>There is no guarantee by us, nor by any other member, of any amount of earnings.&nbsp;It is your responsibility to make sure your&nbsp;payment ID&nbsp;is correctly saved in your profile. Earnings&nbsp;made to the wrong person because of an incorrectly entered&nbsp;payment ID on your account is your responsibility.</p>\r\n<h4>PRODUCT DESCRIPTIONS</h4>\r\n<p>~SITENAME~ and its associates attempt to be as accurate as possible. However, ~SITENAME~ does not warrant that product descriptions or other content of this site is accurate, complete, reliable, current, or error-free. If a product offered by ~SITENAME~ itself is not as described, your sole remedy is to return it in unused condition.&nbsp;</p>\r\n<h4>REVIEWS, COMMENTS, EMAILS, AND OTHER CONTENT</h4>\r\n<p>Visitors may post reviews, comments, and other content: and submit suggestions, ideas, comments, questions, or other information, so long as the content is not illegal, obscene, threatening, defamatory, invasive of privacy, infringing of intellectual property rights, or otherwise injurious to third parties or objectionable and does not consist of or contain software viruses, political campaigning, commercial solicitation, chain letters, mass mailings, or any form of \"spam.\" You may not use a false e-mail address, impersonate any person or entity, or otherwise mislead as to the origin of a card or other content. ~SITENAME~ reserves the right (but not the obligation) to remove or edit such content, but does not regularly review posted content. If you do post content or submit material, and unless we indicate otherwise, you grant ~SITENAME~ and its associates a nonexclusive, royalty-free, perpetual, irrevocable, and fully sublicensable right to use, reproduce, modify, adapt, publish, translate, create derivative works from, distribute, and display such content throughout the world in any media. You grant ~SITENAME~ and its associates and sublicensees the right to use the name that you submit in connection with such content, if they choose. You represent and warrant that you own or otherwise control all of the rights to the content that you post: that the content is accurate: that use of the content you supply does not violate this policy and will not cause injury to any person or entity: and that you will indemnify ~SITENAME~ or its associates for all claims resulting from content you supply. ~SITENAME~ has the right but not the obligation to monitor and edit or remove any activity or content. ~SITENAME~ takes no responsibility and assumes no liability for any content posted by you or any third party.</p>\r\n<h4>SPAM</h4>\r\n<p>~SITENAME~ has a&nbsp;zero&nbsp;tolerance for spam. Anyone caught spamming will be deleted from the program and is subject to civil and criminal prosecution. If you include ~SITENAME~\'s name or URL in any email promotion, you may only email to your own double-optin&nbsp;subscribers. Safelists and or Advertising Exchanges, are also allowed as well as downline mailing programs, providing all spam laws are followed.</p>\r\n<p>The following are grounds for termination of your account:</p>\r\n<p>To send unsolicited emails to anyone that is not on your own personal double-optin list.</p>\r\n<p>If this does not make sense to you, then do not include promotions for ~SITENAME~ in emails.<br /><br />To falsify user information provided to ~SITENAME~ or to other users of the service<br />in connection with ~SITENAME~, or any of it\'s other sites.<br /><br />To use or add the ~SITENAME~ name and URL in bought commercial bulk email lists.</p>\r\n<p>~SITENAME~ considers the above practices to constitute abuse of our service and of the recipients of such unsolicited mailings and/or postings who often bear the expense. Therefore, these practices are prohibited by ~SITENAME~ terms and conditions of service. Engaging in one or more of these practices will result in termination of the offender\'s account.</p>\r\n<h4>DISCLAIMER</h4>\r\n<p>DISCLAIMER OF WARRANTIES AND LIMITATION OF LIABILITY THIS SITE IS PROVIDED BY ~SITENAME~ ON AN \"AS IS\" AND \"AS AVAILABLE\" BASIS. ~SITENAME~ MAKES NO REPRESENTATIONS OR WARRANTIES OF ANY KIND, EXPRESS OR IMPLIED, AS TO THE OPERATION OF THIS SITE OR THE INFORMATION, CONTENT, MATERIALS, OR PRODUCTS INCLUDED ON THIS SITE. YOU EXPRESSLY AGREE THAT YOUR USE OF THIS SITE IS AT YOUR SOLE RISK. TO THE FULL EXTENT PERMISSIBLE BY APPLICABLE LAW, MYCOMPANY DISCLAIMS ALL WARRANTIES, EXPRESS OR IMPLIED, INCLUDING, BUT NOT LIMITED TO, IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE. ~SITENAME~ DOES NOT WARRANT THAT THIS SITE, ITS SERVERS, OR E-MAIL SENT FROM ~SITENAME~ ARE FREE OF VIRUSES OR OTHER HARMFUL COMPONENTS. ~SITENAME~ WILL NOT BE LIABLE FOR ANY DAMAGES OF ANY KIND ARISING FROM THE USE OF THIS SITE, INCLUDING, BUT NOT LIMITED TO DIRECT, INDIRECT, INCIDENTAL, PUNITIVE, AND CONSEQUENTIAL DAMAGES. CERTAIN STATE LAWS DO NOT ALLOW LIMITATIONS ON IMPLIED WARRANTIES OR THE EXCLUSION OR LIMITATION OF CERTAIN DAMAGES. IF THESE LAWS APPLY TO YOU, SOME OR ALL OF THE ABOVE DISCLAIMERS, EXCLUSIONS, OR LIMITATIONS MAY NOT APPLY TO YOU, AND YOU MIGHT HAVE ADDITIONAL RIGHTS.</p>\r\n<h4>APPLICABLE LAW</h4>\r\n<p>By visiting ~SITENAME~, you agree that the laws of the state, without regard to principles of conflict of laws, will govern these Conditions of Use and any dispute of any sort that might arise between you and ~SITENAME~ or its associates.</p>\r\n<h4>SITE POLICIES, MODIFICATION, AND SEVERABILITY</h4>\r\n<p>Please review our other policies and FAQs posted on this site. These policies also govern your visit to ~SITENAME~. We reserve the right to make changes to our site, policies, and these Conditions of Use at any time. If any of these conditions shall be deemed invalid, void, or for any reason unenforceable, that condition shall be deemed severable and shall not affect the validity and enforceability of any remaining condition.</p>\r\n<h4>CODE OF CONDUCT</h4>\r\n<p>You agree that any ad posts that displays and/or connects with malware, porn, gambling, warez, or other inappropriate sites will be DELETED and that your account will be deleted without refund.</p>\r\n<p>You agree that no ad posts will promote any form of illegal activity. You agree that all ad posts will be fully compliant with federal and state laws.</p>\r\n<p>You agree to no racist or hateful ads.</p>\r\n<p>You agree to only have links in ad posts that point to other html web pages. You agree to have no links to e-books, downloads, zip files, mp3&rsquo;s etc.</p>\r\n<p>You agree to only use URLs that do not break frames.</p>\r\n<p>You agree not to include profanity in your ad posts.</p>\r\n<p>You agree that any form of misleading readers will not be tolerated.</p>\r\n<h4>QUESTIONS</h4>\r\n<p>Questions regarding our Conditions of Usage, Privacy Policy, or other policy related material can be directed to our support staff by clicking on the \"Contact Us\" link in the&nbsp;top menu.</p>' WHERE `pages`.`name` = 'Terms Page';

INSERT INTO `countries` (`country_id`, `country_name`, `iso_code2`, `iso_code3`, `reserved1`) values (1, 'Afghanistan', 'AF', 'AFG', 0);
INSERT INTO `countries` (`country_id`, `country_name`, `iso_code2`, `iso_code3`, `reserved1`) values (2, 'Albania', 'AL', 'ALB', 0);
INSERT INTO `countries` (`country_id`, `country_name`, `iso_code2`, `iso_code3`, `reserved1`) values (3, 'Algeria', 'DZ', 'DZA', 0);
INSERT INTO `countries` (`country_id`, `country_name`, `iso_code2`, `iso_code3`, `reserved1`) values (4, 'American Samoa', 'AS', 'ASM', 0);
INSERT INTO `countries` (`country_id`, `country_name`, `iso_code2`, `iso_code3`, `reserved1`) values (5, 'Andorra', 'AD', 'AND', 0);
INSERT INTO `countries` (`country_id`, `country_name`, `iso_code2`, `iso_code3`, `reserved1`) values (6, 'Angola', 'AO', 'AGO', 0);
INSERT INTO `countries` (`country_id`, `country_name`, `iso_code2`, `iso_code3`, `reserved1`) values (7, 'Anguilla', 'AI', 'AIA', 0);
INSERT INTO `countries` (`country_id`, `country_name`, `iso_code2`, `iso_code3`, `reserved1`) values (8, 'Antarctica', 'AQ', 'ATA', 0);
INSERT INTO `countries` (`country_id`, `country_name`, `iso_code2`, `iso_code3`, `reserved1`) values (9, 'Antigua and Barbuda', 'AG', 'ATG', 0);
INSERT INTO `countries` (`country_id`, `country_name`, `iso_code2`, `iso_code3`, `reserved1`) values (10, 'Argentina', 'AR', 'ARG', 0);
INSERT INTO `countries` (`country_id`, `country_name`, `iso_code2`, `iso_code3`, `reserved1`) values (11, 'Armenia', 'AM', 'ARM', 0);
INSERT INTO `countries` (`country_id`, `country_name`, `iso_code2`, `iso_code3`, `reserved1`) values (12, 'Aruba', 'AW', 'ABW', 0);
INSERT INTO `countries` (`country_id`, `country_name`, `iso_code2`, `iso_code3`, `reserved1`) values (13, 'Australia', 'AU', 'AUS', 0);
INSERT INTO `countries` (`country_id`, `country_name`, `iso_code2`, `iso_code3`, `reserved1`) values (14, 'Austria', 'AT', 'AUT', 0);
INSERT INTO `countries` (`country_id`, `country_name`, `iso_code2`, `iso_code3`, `reserved1`) values (15, 'Azerbaijan', 'AZ', 'AZE', 0);
INSERT INTO `countries` (`country_id`, `country_name`, `iso_code2`, `iso_code3`, `reserved1`) values (16, 'Bahamas', 'BS', 'BHS', 0);
INSERT INTO `countries` (`country_id`, `country_name`, `iso_code2`, `iso_code3`, `reserved1`) values (17, 'Bahrain', 'BH', 'BHR', 0);
INSERT INTO `countries` (`country_id`, `country_name`, `iso_code2`, `iso_code3`, `reserved1`) values (18, 'Bangladesh', 'BD', 'BGD', 0);
INSERT INTO `countries` (`country_id`, `country_name`, `iso_code2`, `iso_code3`, `reserved1`) values (19, 'Barbados', 'BB', 'BRB', 0);
INSERT INTO `countries` (`country_id`, `country_name`, `iso_code2`, `iso_code3`, `reserved1`) values (20, 'Belarus', 'BY', 'BLR', 0);
INSERT INTO `countries` (`country_id`, `country_name`, `iso_code2`, `iso_code3`, `reserved1`) values (21, 'Belgium', 'BE', 'BEL', 0);
INSERT INTO `countries` (`country_id`, `country_name`, `iso_code2`, `iso_code3`, `reserved1`) values (22, 'Belize', 'BZ', 'BLZ', 0);
INSERT INTO `countries` (`country_id`, `country_name`, `iso_code2`, `iso_code3`, `reserved1`) values (23, 'Benin', 'BJ', 'BEN', 0);
INSERT INTO `countries` (`country_id`, `country_name`, `iso_code2`, `iso_code3`, `reserved1`) values (24, 'Bermuda', 'BM', 'BMU', 0);
INSERT INTO `countries` (`country_id`, `country_name`, `iso_code2`, `iso_code3`, `reserved1`) values (25, 'Bhutan', 'BT', 'BTN', 0);
INSERT INTO `countries` (`country_id`, `country_name`, `iso_code2`, `iso_code3`, `reserved1`) values (26, 'Bolivia', 'BO', 'BOL', 0);
INSERT INTO `countries` (`country_id`, `country_name`, `iso_code2`, `iso_code3`, `reserved1`) values (27, 'Bosnia and Herzegowina', 'BA', 'BIH', 0);
INSERT INTO `countries` (`country_id`, `country_name`, `iso_code2`, `iso_code3`, `reserved1`) values (28, 'Botswana', 'BW', 'BWA', 0);
INSERT INTO `countries` (`country_id`, `country_name`, `iso_code2`, `iso_code3`, `reserved1`) values (29, 'Bouvet Island', 'BV', 'BVT', 0);
INSERT INTO `countries` (`country_id`, `country_name`, `iso_code2`, `iso_code3`, `reserved1`) values (30, 'Brazil', 'BR', 'BRA', 0);
INSERT INTO `countries` (`country_id`, `country_name`, `iso_code2`, `iso_code3`, `reserved1`) values (31, 'British Indian Ocean Territory', 'IO', 'IOT', 0);
INSERT INTO `countries` (`country_id`, `country_name`, `iso_code2`, `iso_code3`, `reserved1`) values (32, 'Brunei Darussalam', 'BN', 'BRN', 0);
INSERT INTO `countries` (`country_id`, `country_name`, `iso_code2`, `iso_code3`, `reserved1`) values (33, 'Bulgaria', 'BG', 'BGR', 0);
INSERT INTO `countries` (`country_id`, `country_name`, `iso_code2`, `iso_code3`, `reserved1`) values (34, 'Burkina Faso', 'BF', 'BFA', 0);
INSERT INTO `countries` (`country_id`, `country_name`, `iso_code2`, `iso_code3`, `reserved1`) values (35, 'Burundi', 'BI', 'BDI', 0);
INSERT INTO `countries` (`country_id`, `country_name`, `iso_code2`, `iso_code3`, `reserved1`) values (36, 'Cambodia', 'KH', 'KHM', 0);
INSERT INTO `countries` (`country_id`, `country_name`, `iso_code2`, `iso_code3`, `reserved1`) values (37, 'Cameroon', 'CM', 'CMR', 0);
INSERT INTO `countries` (`country_id`, `country_name`, `iso_code2`, `iso_code3`, `reserved1`) values (38, 'Canada', 'CA', 'CAN', 0);
INSERT INTO `countries` (`country_id`, `country_name`, `iso_code2`, `iso_code3`, `reserved1`) values (39, 'Cape Verde', 'CV', 'CPV', 0);
INSERT INTO `countries` (`country_id`, `country_name`, `iso_code2`, `iso_code3`, `reserved1`) values (40, 'Cayman Islands', 'KY', 'CYM', 0);
INSERT INTO `countries` (`country_id`, `country_name`, `iso_code2`, `iso_code3`, `reserved1`) values (41, 'Central African Republic', 'CF', 'CAF', 0);
INSERT INTO `countries` (`country_id`, `country_name`, `iso_code2`, `iso_code3`, `reserved1`) values (42, 'Chad', 'TD', 'TCD', 0);
INSERT INTO `countries` (`country_id`, `country_name`, `iso_code2`, `iso_code3`, `reserved1`) values (43, 'Chile', 'CL', 'CHL', 0);
INSERT INTO `countries` (`country_id`, `country_name`, `iso_code2`, `iso_code3`, `reserved1`) values (44, 'China', 'CN', 'CHN', 0);
INSERT INTO `countries` (`country_id`, `country_name`, `iso_code2`, `iso_code3`, `reserved1`) values (45, 'Christmas Island', 'CX', 'CXR', 0);
INSERT INTO `countries` (`country_id`, `country_name`, `iso_code2`, `iso_code3`, `reserved1`) values (46, 'Cocos (Keeling) Islands', 'CC', 'CCK', 0);
INSERT INTO `countries` (`country_id`, `country_name`, `iso_code2`, `iso_code3`, `reserved1`) values (47, 'Colombia', 'CO', 'COL', 0);
INSERT INTO `countries` (`country_id`, `country_name`, `iso_code2`, `iso_code3`, `reserved1`) values (48, 'Comoros', 'KM', 'COM', 0);
INSERT INTO `countries` (`country_id`, `country_name`, `iso_code2`, `iso_code3`, `reserved1`) values (49, 'Congo', 'CG', 'COG', 0);
INSERT INTO `countries` (`country_id`, `country_name`, `iso_code2`, `iso_code3`, `reserved1`) values (50, 'Cook Islands', 'CK', 'COK', 0);
INSERT INTO `countries` (`country_id`, `country_name`, `iso_code2`, `iso_code3`, `reserved1`) values (51, 'Costa Rica', 'CR', 'CRI', 0);
INSERT INTO `countries` (`country_id`, `country_name`, `iso_code2`, `iso_code3`, `reserved1`) values (52, 'Cote D''Ivoire', 'CI', 'CIV', 0);
INSERT INTO `countries` (`country_id`, `country_name`, `iso_code2`, `iso_code3`, `reserved1`) values (53, 'Croatia', 'HR', 'HRV', 0);
INSERT INTO `countries` (`country_id`, `country_name`, `iso_code2`, `iso_code3`, `reserved1`) values (54, 'Cuba', 'CU', 'CUB', 0);
INSERT INTO `countries` (`country_id`, `country_name`, `iso_code2`, `iso_code3`, `reserved1`) values (55, 'Cyprus', 'CY', 'CYP', 0);
INSERT INTO `countries` (`country_id`, `country_name`, `iso_code2`, `iso_code3`, `reserved1`) values (56, 'Czech Republic', 'CZ', 'CZE', 0);
INSERT INTO `countries` (`country_id`, `country_name`, `iso_code2`, `iso_code3`, `reserved1`) values (57, 'Denmark', 'DK', 'DNK', 0);
INSERT INTO `countries` (`country_id`, `country_name`, `iso_code2`, `iso_code3`, `reserved1`) values (58, 'Djibouti', 'DJ', 'DJI', 0);
INSERT INTO `countries` (`country_id`, `country_name`, `iso_code2`, `iso_code3`, `reserved1`) values (59, 'Dominica', 'DM', 'DMA', 0);
INSERT INTO `countries` (`country_id`, `country_name`, `iso_code2`, `iso_code3`, `reserved1`) values (60, 'Dominican Republic', 'DO', 'DOM', 0);
INSERT INTO `countries` (`country_id`, `country_name`, `iso_code2`, `iso_code3`, `reserved1`) values (61, 'East Timor', 'TP', 'TMP', 0);
INSERT INTO `countries` (`country_id`, `country_name`, `iso_code2`, `iso_code3`, `reserved1`) values (62, 'Ecuador', 'EC', 'ECU', 0);
INSERT INTO `countries` (`country_id`, `country_name`, `iso_code2`, `iso_code3`, `reserved1`) values (63, 'Egypt', 'EG', 'EGY', 0);
INSERT INTO `countries` (`country_id`, `country_name`, `iso_code2`, `iso_code3`, `reserved1`) values (64, 'El Salvador', 'SV', 'SLV', 0);
INSERT INTO `countries` (`country_id`, `country_name`, `iso_code2`, `iso_code3`, `reserved1`) values (65, 'Equatorial Guinea', 'GQ', 'GNQ', 0);
INSERT INTO `countries` (`country_id`, `country_name`, `iso_code2`, `iso_code3`, `reserved1`) values (66, 'Eritrea', 'ER', 'ERI', 0);
INSERT INTO `countries` (`country_id`, `country_name`, `iso_code2`, `iso_code3`, `reserved1`) values (67, 'Estonia', 'EE', 'EST', 0);
INSERT INTO `countries` (`country_id`, `country_name`, `iso_code2`, `iso_code3`, `reserved1`) values (68, 'Ethiopia', 'ET', 'ETH', 0);
INSERT INTO `countries` (`country_id`, `country_name`, `iso_code2`, `iso_code3`, `reserved1`) values (69, 'Falkland Islands (Malvinas)', 'FK', 'FLK', 0);
INSERT INTO `countries` (`country_id`, `country_name`, `iso_code2`, `iso_code3`, `reserved1`) values (70, 'Faroe Islands', 'FO', 'FRO', 0);
INSERT INTO `countries` (`country_id`, `country_name`, `iso_code2`, `iso_code3`, `reserved1`) values (71, 'Fiji', 'FJ', 'FJI', 0);
INSERT INTO `countries` (`country_id`, `country_name`, `iso_code2`, `iso_code3`, `reserved1`) values (72, 'Finland', 'FI', 'FIN', 0);
INSERT INTO `countries` (`country_id`, `country_name`, `iso_code2`, `iso_code3`, `reserved1`) values (73, 'France', 'FR', 'FRA', 0);
INSERT INTO `countries` (`country_id`, `country_name`, `iso_code2`, `iso_code3`, `reserved1`) values (74, 'France, Metropolitan', 'FX', 'FXX', 0);
INSERT INTO `countries` (`country_id`, `country_name`, `iso_code2`, `iso_code3`, `reserved1`) values (75, 'French Guiana', 'GF', 'GUF', 0);
INSERT INTO `countries` (`country_id`, `country_name`, `iso_code2`, `iso_code3`, `reserved1`) values (76, 'French Polynesia', 'PF', 'PYF', 0);
INSERT INTO `countries` (`country_id`, `country_name`, `iso_code2`, `iso_code3`, `reserved1`) values (77, 'French Southern Territories', 'TF', 'ATF', 0);
INSERT INTO `countries` (`country_id`, `country_name`, `iso_code2`, `iso_code3`, `reserved1`) values (78, 'Gabon', 'GA', 'GAB', 0);
INSERT INTO `countries` (`country_id`, `country_name`, `iso_code2`, `iso_code3`, `reserved1`) values (79, 'Gambia', 'GM', 'GMB', 0);
INSERT INTO `countries` (`country_id`, `country_name`, `iso_code2`, `iso_code3`, `reserved1`) values (80, 'Georgia', 'GE', 'GEO', 0);
INSERT INTO `countries` (`country_id`, `country_name`, `iso_code2`, `iso_code3`, `reserved1`) values (81, 'Germany', 'DE', 'DEU', 0);
INSERT INTO `countries` (`country_id`, `country_name`, `iso_code2`, `iso_code3`, `reserved1`) values (82, 'Ghana', 'GH', 'GHA', 0);
INSERT INTO `countries` (`country_id`, `country_name`, `iso_code2`, `iso_code3`, `reserved1`) values (83, 'Gibraltar', 'GI', 'GIB', 0);
INSERT INTO `countries` (`country_id`, `country_name`, `iso_code2`, `iso_code3`, `reserved1`) values (84, 'Greece', 'GR', 'GRC', 0);
INSERT INTO `countries` (`country_id`, `country_name`, `iso_code2`, `iso_code3`, `reserved1`) values (85, 'Greenland', 'GL', 'GRL', 0);
INSERT INTO `countries` (`country_id`, `country_name`, `iso_code2`, `iso_code3`, `reserved1`) values (86, 'Grenada', 'GD', 'GRD', 0);
INSERT INTO `countries` (`country_id`, `country_name`, `iso_code2`, `iso_code3`, `reserved1`) values (87, 'Guadeloupe', 'GP', 'GLP', 0);
INSERT INTO `countries` (`country_id`, `country_name`, `iso_code2`, `iso_code3`, `reserved1`) values (88, 'Guam', 'GU', 'GUM', 0);
INSERT INTO `countries` (`country_id`, `country_name`, `iso_code2`, `iso_code3`, `reserved1`) values (89, 'Guatemala', 'GT', 'GTM', 0);
INSERT INTO `countries` (`country_id`, `country_name`, `iso_code2`, `iso_code3`, `reserved1`) values (90, 'Guinea', 'GN', 'GIN', 0);
INSERT INTO `countries` (`country_id`, `country_name`, `iso_code2`, `iso_code3`, `reserved1`) values (91, 'Guinea-bissau', 'GW', 'GNB', 0);
INSERT INTO `countries` (`country_id`, `country_name`, `iso_code2`, `iso_code3`, `reserved1`) values (92, 'Guyana', 'GY', 'GUY', 0);
INSERT INTO `countries` (`country_id`, `country_name`, `iso_code2`, `iso_code3`, `reserved1`) values (93, 'Haiti', 'HT', 'HTI', 0);
INSERT INTO `countries` (`country_id`, `country_name`, `iso_code2`, `iso_code3`, `reserved1`) values (94, 'Heard and Mc Donald Islands', 'HM', 'HMD', 0);
INSERT INTO `countries` (`country_id`, `country_name`, `iso_code2`, `iso_code3`, `reserved1`) values (95, 'Honduras', 'HN', 'HND', 0);
INSERT INTO `countries` (`country_id`, `country_name`, `iso_code2`, `iso_code3`, `reserved1`) values (96, 'Hong Kong', 'HK', 'HKG', 0);
INSERT INTO `countries` (`country_id`, `country_name`, `iso_code2`, `iso_code3`, `reserved1`) values (97, 'Hungary', 'HU', 'HUN', 0);
INSERT INTO `countries` (`country_id`, `country_name`, `iso_code2`, `iso_code3`, `reserved1`) values (98, 'Iceland', 'IS', 'ISL', 0);
INSERT INTO `countries` (`country_id`, `country_name`, `iso_code2`, `iso_code3`, `reserved1`) values (99, 'India', 'IN', 'IND', 0);
INSERT INTO `countries` (`country_id`, `country_name`, `iso_code2`, `iso_code3`, `reserved1`) values (100, 'Indonesia', 'ID', 'IDN', 0);
INSERT INTO `countries` (`country_id`, `country_name`, `iso_code2`, `iso_code3`, `reserved1`) values (101, 'Iran (Islamic Republic of)', 'IR', 'IRN', 0);
INSERT INTO `countries` (`country_id`, `country_name`, `iso_code2`, `iso_code3`, `reserved1`) values (102, 'Iraq', 'IQ', 'IRQ', 0);
INSERT INTO `countries` (`country_id`, `country_name`, `iso_code2`, `iso_code3`, `reserved1`) values (103, 'Ireland', 'IE', 'IRL', 0);
INSERT INTO `countries` (`country_id`, `country_name`, `iso_code2`, `iso_code3`, `reserved1`) values (104, 'Israel', 'IL', 'ISR', 0);
INSERT INTO `countries` (`country_id`, `country_name`, `iso_code2`, `iso_code3`, `reserved1`) values (105, 'Italy', 'IT', 'ITA', 0);
INSERT INTO `countries` (`country_id`, `country_name`, `iso_code2`, `iso_code3`, `reserved1`) values (106, 'Jamaica', 'JM', 'JAM', 0);
INSERT INTO `countries` (`country_id`, `country_name`, `iso_code2`, `iso_code3`, `reserved1`) values (107, 'Japan', 'JP', 'JPN', 0);
INSERT INTO `countries` (`country_id`, `country_name`, `iso_code2`, `iso_code3`, `reserved1`) values (108, 'Jordan', 'JO', 'JOR', 0);
INSERT INTO `countries` (`country_id`, `country_name`, `iso_code2`, `iso_code3`, `reserved1`) values (109, 'Kazakhstan', 'KZ', 'KAZ', 0);
INSERT INTO `countries` (`country_id`, `country_name`, `iso_code2`, `iso_code3`, `reserved1`) values (110, 'Kenya', 'KE', 'KEN', 0);
INSERT INTO `countries` (`country_id`, `country_name`, `iso_code2`, `iso_code3`, `reserved1`) values (111, 'Kiribati', 'KI', 'KIR', 0);
INSERT INTO `countries` (`country_id`, `country_name`, `iso_code2`, `iso_code3`, `reserved1`) values (112, 'Korea', 'KP', 'PRK', 0);
INSERT INTO `countries` (`country_id`, `country_name`, `iso_code2`, `iso_code3`, `reserved1`) values (114, 'Kuwait', 'KW', 'KWT', 0);
INSERT INTO `countries` (`country_id`, `country_name`, `iso_code2`, `iso_code3`, `reserved1`) values (115, 'Kyrgyzstan', 'KG', 'KGZ', 0);
INSERT INTO `countries` (`country_id`, `country_name`, `iso_code2`, `iso_code3`, `reserved1`) values (116, 'Lao People''s Democratic Republic', 'LA', 'LAO', 0);
INSERT INTO `countries` (`country_id`, `country_name`, `iso_code2`, `iso_code3`, `reserved1`) values (117, 'Latvia', 'LV', 'LVA', 0);
INSERT INTO `countries` (`country_id`, `country_name`, `iso_code2`, `iso_code3`, `reserved1`) values (118, 'Lebanon', 'LB', 'LBN', 0);
INSERT INTO `countries` (`country_id`, `country_name`, `iso_code2`, `iso_code3`, `reserved1`) values (119, 'Lesotho', 'LS', 'LSO', 0);
INSERT INTO `countries` (`country_id`, `country_name`, `iso_code2`, `iso_code3`, `reserved1`) values (120, 'Liberia', 'LR', 'LBR', 0);
INSERT INTO `countries` (`country_id`, `country_name`, `iso_code2`, `iso_code3`, `reserved1`) values (121, 'Libyan Arab Jamahiriya', 'LY', 'LBY', 0);
INSERT INTO `countries` (`country_id`, `country_name`, `iso_code2`, `iso_code3`, `reserved1`) values (122, 'Liechtenstein', 'LI', 'LIE', 0);
INSERT INTO `countries` (`country_id`, `country_name`, `iso_code2`, `iso_code3`, `reserved1`) values (123, 'Lithuania', 'LT', 'LTU', 0);
INSERT INTO `countries` (`country_id`, `country_name`, `iso_code2`, `iso_code3`, `reserved1`) values (124, 'Luxembourg', 'LU', 'LUX', 0);
INSERT INTO `countries` (`country_id`, `country_name`, `iso_code2`, `iso_code3`, `reserved1`) values (125, 'Macau', 'MO', 'MAC', 0);
INSERT INTO `countries` (`country_id`, `country_name`, `iso_code2`, `iso_code3`, `reserved1`) values (126, 'Macedonia', 'MK', 'MKD', 0);
INSERT INTO `countries` (`country_id`, `country_name`, `iso_code2`, `iso_code3`, `reserved1`) values (127, 'Madagascar', 'MG', 'MDG', 0);
INSERT INTO `countries` (`country_id`, `country_name`, `iso_code2`, `iso_code3`, `reserved1`) values (128, 'Malawi', 'MW', 'MWI', 0);
INSERT INTO `countries` (`country_id`, `country_name`, `iso_code2`, `iso_code3`, `reserved1`) values (129, 'Malaysia', 'MY', 'MYS', 0);
INSERT INTO `countries` (`country_id`, `country_name`, `iso_code2`, `iso_code3`, `reserved1`) values (130, 'Maldives', 'MV', 'MDV', 0);
INSERT INTO `countries` (`country_id`, `country_name`, `iso_code2`, `iso_code3`, `reserved1`) values (131, 'Mali', 'ML', 'MLI', 0);
INSERT INTO `countries` (`country_id`, `country_name`, `iso_code2`, `iso_code3`, `reserved1`) values (132, 'Malta', 'MT', 'MLT', 0);
INSERT INTO `countries` (`country_id`, `country_name`, `iso_code2`, `iso_code3`, `reserved1`) values (133, 'Marshall Islands', 'MH', 'MHL', 0);
INSERT INTO `countries` (`country_id`, `country_name`, `iso_code2`, `iso_code3`, `reserved1`) values (134, 'Martinique', 'MQ', 'MTQ', 0);
INSERT INTO `countries` (`country_id`, `country_name`, `iso_code2`, `iso_code3`, `reserved1`) values (135, 'Mauritania', 'MR', 'MRT', 0);
INSERT INTO `countries` (`country_id`, `country_name`, `iso_code2`, `iso_code3`, `reserved1`) values (136, 'Mauritius', 'MU', 'MUS', 0);
INSERT INTO `countries` (`country_id`, `country_name`, `iso_code2`, `iso_code3`, `reserved1`) values (137, 'Mayotte', 'YT', 'MYT', 0);
INSERT INTO `countries` (`country_id`, `country_name`, `iso_code2`, `iso_code3`, `reserved1`) values (138, 'Mexico', 'MX', 'MEX', 0);
INSERT INTO `countries` (`country_id`, `country_name`, `iso_code2`, `iso_code3`, `reserved1`) values (139, 'Micronesia, Federated States of', 'FM', 'FSM', 0);
INSERT INTO `countries` (`country_id`, `country_name`, `iso_code2`, `iso_code3`, `reserved1`) values (140, 'Moldova, Republic of', 'MD', 'MDA', 0);
INSERT INTO `countries` (`country_id`, `country_name`, `iso_code2`, `iso_code3`, `reserved1`) values (141, 'Monaco', 'MC', 'MCO', 0);
INSERT INTO `countries` (`country_id`, `country_name`, `iso_code2`, `iso_code3`, `reserved1`) values (142, 'Mongolia', 'MN', 'MNG', 0);
INSERT INTO `countries` (`country_id`, `country_name`, `iso_code2`, `iso_code3`, `reserved1`) values (143, 'Montserrat', 'MS', 'MSR', 0);
INSERT INTO `countries` (`country_id`, `country_name`, `iso_code2`, `iso_code3`, `reserved1`) values (144, 'Morocco', 'MA', 'MAR', 0);
INSERT INTO `countries` (`country_id`, `country_name`, `iso_code2`, `iso_code3`, `reserved1`) values (145, 'Mozambique', 'MZ', 'MOZ', 0);
INSERT INTO `countries` (`country_id`, `country_name`, `iso_code2`, `iso_code3`, `reserved1`) values (146, 'Myanmar', 'MM', 'MMR', 0);
INSERT INTO `countries` (`country_id`, `country_name`, `iso_code2`, `iso_code3`, `reserved1`) values (147, 'Namibia', 'NA', 'NAM', 0);
INSERT INTO `countries` (`country_id`, `country_name`, `iso_code2`, `iso_code3`, `reserved1`) values (148, 'Nauru', 'NR', 'NRU', 0);
INSERT INTO `countries` (`country_id`, `country_name`, `iso_code2`, `iso_code3`, `reserved1`) values (149, 'Nepal', 'NP', 'NPL', 0);
INSERT INTO `countries` (`country_id`, `country_name`, `iso_code2`, `iso_code3`, `reserved1`) values (150, 'Netherlands', 'NL', 'NLD', 0);
INSERT INTO `countries` (`country_id`, `country_name`, `iso_code2`, `iso_code3`, `reserved1`) values (151, 'Netherlands Antilles', 'AN', 'ANT', 0);
INSERT INTO `countries` (`country_id`, `country_name`, `iso_code2`, `iso_code3`, `reserved1`) values (152, 'New Caledonia', 'NC', 'NCL', 0);
INSERT INTO `countries` (`country_id`, `country_name`, `iso_code2`, `iso_code3`, `reserved1`) values (153, 'New Zealand', 'NZ', 'NZL', 0);
INSERT INTO `countries` (`country_id`, `country_name`, `iso_code2`, `iso_code3`, `reserved1`) values (154, 'Nicaragua', 'NI', 'NIC', 0);
INSERT INTO `countries` (`country_id`, `country_name`, `iso_code2`, `iso_code3`, `reserved1`) values (155, 'Niger', 'NE', 'NER', 0);
INSERT INTO `countries` (`country_id`, `country_name`, `iso_code2`, `iso_code3`, `reserved1`) values (156, 'Nigeria', 'NG', 'NGA', 0);
INSERT INTO `countries` (`country_id`, `country_name`, `iso_code2`, `iso_code3`, `reserved1`) values (157, 'Niue', 'NU', 'NIU', 0);
INSERT INTO `countries` (`country_id`, `country_name`, `iso_code2`, `iso_code3`, `reserved1`) values (158, 'Norfolk Island', 'NF', 'NFK', 0);
INSERT INTO `countries` (`country_id`, `country_name`, `iso_code2`, `iso_code3`, `reserved1`) values (159, 'Northern Mariana Islands', 'MP', 'MNP', 0);
INSERT INTO `countries` (`country_id`, `country_name`, `iso_code2`, `iso_code3`, `reserved1`) values (160, 'Norway', 'NO', 'NOR', 0);
INSERT INTO `countries` (`country_id`, `country_name`, `iso_code2`, `iso_code3`, `reserved1`) values (161, 'Oman', 'OM', 'OMN', 0);
INSERT INTO `countries` (`country_id`, `country_name`, `iso_code2`, `iso_code3`, `reserved1`) values (162, 'Pakistan', 'PK', 'PAK', 0);
INSERT INTO `countries` (`country_id`, `country_name`, `iso_code2`, `iso_code3`, `reserved1`) values (163, 'Palau', 'PW', 'PLW', 0);
INSERT INTO `countries` (`country_id`, `country_name`, `iso_code2`, `iso_code3`, `reserved1`) values (164, 'Panama', 'PA', 'PAN', 0);
INSERT INTO `countries` (`country_id`, `country_name`, `iso_code2`, `iso_code3`, `reserved1`) values (165, 'Papua New Guinea', 'PG', 'PNG', 0);
INSERT INTO `countries` (`country_id`, `country_name`, `iso_code2`, `iso_code3`, `reserved1`) values (166, 'Paraguay', 'PY', 'PRY', 0);
INSERT INTO `countries` (`country_id`, `country_name`, `iso_code2`, `iso_code3`, `reserved1`) values (167, 'Peru', 'PE', 'PER', 0);
INSERT INTO `countries` (`country_id`, `country_name`, `iso_code2`, `iso_code3`, `reserved1`) values (168, 'Philippines', 'PH', 'PHL', 0);
INSERT INTO `countries` (`country_id`, `country_name`, `iso_code2`, `iso_code3`, `reserved1`) values (169, 'Pitcairn', 'PN', 'PCN', 0);
INSERT INTO `countries` (`country_id`, `country_name`, `iso_code2`, `iso_code3`, `reserved1`) values (170, 'Poland', 'PL', 'POL', 0);
INSERT INTO `countries` (`country_id`, `country_name`, `iso_code2`, `iso_code3`, `reserved1`) values (171, 'Portugal', 'PT', 'PRT', 0);
INSERT INTO `countries` (`country_id`, `country_name`, `iso_code2`, `iso_code3`, `reserved1`) values (172, 'Puerto Rico', 'PR', 'PRI', 0);
INSERT INTO `countries` (`country_id`, `country_name`, `iso_code2`, `iso_code3`, `reserved1`) values (173, 'Qatar', 'QA', 'QAT', 0);
INSERT INTO `countries` (`country_id`, `country_name`, `iso_code2`, `iso_code3`, `reserved1`) values (174, 'Reunion', 'RE', 'REU', 0);
INSERT INTO `countries` (`country_id`, `country_name`, `iso_code2`, `iso_code3`, `reserved1`) values (175, 'Romania', 'RO', 'ROM', 0);
INSERT INTO `countries` (`country_id`, `country_name`, `iso_code2`, `iso_code3`, `reserved1`) values (176, 'Russian Federation', 'RU', 'RUS', 0);
INSERT INTO `countries` (`country_id`, `country_name`, `iso_code2`, `iso_code3`, `reserved1`) values (177, 'Rwanda', 'RW', 'RWA', 0);
INSERT INTO `countries` (`country_id`, `country_name`, `iso_code2`, `iso_code3`, `reserved1`) values (178, 'Saint Kitts and Nevis', 'KN', 'KNA', 0);
INSERT INTO `countries` (`country_id`, `country_name`, `iso_code2`, `iso_code3`, `reserved1`) values (179, 'Saint Lucia', 'LC', 'LCA', 0);
INSERT INTO `countries` (`country_id`, `country_name`, `iso_code2`, `iso_code3`, `reserved1`) values (180, 'Saint Vincent and the Grenadines', 'VC', 'VCT', 0);
INSERT INTO `countries` (`country_id`, `country_name`, `iso_code2`, `iso_code3`, `reserved1`) values (181, 'Samoa', 'WS', 'WSM', 0);
INSERT INTO `countries` (`country_id`, `country_name`, `iso_code2`, `iso_code3`, `reserved1`) values (182, 'San Marino', 'SM', 'SMR', 0);
INSERT INTO `countries` (`country_id`, `country_name`, `iso_code2`, `iso_code3`, `reserved1`) values (183, 'Sao Tome and Principe', 'ST', 'STP', 0);
INSERT INTO `countries` (`country_id`, `country_name`, `iso_code2`, `iso_code3`, `reserved1`) values (184, 'Saudi Arabia', 'SA', 'SAU', 0);
INSERT INTO `countries` (`country_id`, `country_name`, `iso_code2`, `iso_code3`, `reserved1`) values (185, 'Senegal', 'SN', 'SEN', 0);
INSERT INTO `countries` (`country_id`, `country_name`, `iso_code2`, `iso_code3`, `reserved1`) values (186, 'Seychelles', 'SC', 'SYC', 0);
INSERT INTO `countries` (`country_id`, `country_name`, `iso_code2`, `iso_code3`, `reserved1`) values (187, 'Sierra Leone', 'SL', 'SLE', 0);
INSERT INTO `countries` (`country_id`, `country_name`, `iso_code2`, `iso_code3`, `reserved1`) values (188, 'Singapore', 'SG', 'SGP', 0);
INSERT INTO `countries` (`country_id`, `country_name`, `iso_code2`, `iso_code3`, `reserved1`) values (189, 'Slovakia (Slovak Republic)', 'SK', 'SVK', 0);
INSERT INTO `countries` (`country_id`, `country_name`, `iso_code2`, `iso_code3`, `reserved1`) values (190, 'Slovenia', 'SI', 'SVN', 0);
INSERT INTO `countries` (`country_id`, `country_name`, `iso_code2`, `iso_code3`, `reserved1`) values (191, 'Solomon Islands', 'SB', 'SLB', 0);
INSERT INTO `countries` (`country_id`, `country_name`, `iso_code2`, `iso_code3`, `reserved1`) values (192, 'Somalia', 'SO', 'SOM', 0);
INSERT INTO `countries` (`country_id`, `country_name`, `iso_code2`, `iso_code3`, `reserved1`) values (193, 'South Africa', 'ZA', 'ZAF', 0);
INSERT INTO `countries` (`country_id`, `country_name`, `iso_code2`, `iso_code3`, `reserved1`) values (194, 'South Georgia', 'GS', 'SGS', 0);
INSERT INTO `countries` (`country_id`, `country_name`, `iso_code2`, `iso_code3`, `reserved1`) values (195, 'Spain', 'ES', 'ESP', 0);
INSERT INTO `countries` (`country_id`, `country_name`, `iso_code2`, `iso_code3`, `reserved1`) values (196, 'Sri Lanka', 'LK', 'LKA', 0);
INSERT INTO `countries` (`country_id`, `country_name`, `iso_code2`, `iso_code3`, `reserved1`) values (197, 'St. Helena', 'SH', 'SHN', 0);
INSERT INTO `countries` (`country_id`, `country_name`, `iso_code2`, `iso_code3`, `reserved1`) values (198, 'St. Pierre and Miquelon', 'PM', 'SPM', 0);
INSERT INTO `countries` (`country_id`, `country_name`, `iso_code2`, `iso_code3`, `reserved1`) values (199, 'Sudan', 'SD', 'SDN', 0);
INSERT INTO `countries` (`country_id`, `country_name`, `iso_code2`, `iso_code3`, `reserved1`) values (200, 'Suriname', 'SR', 'SUR', 0);
INSERT INTO `countries` (`country_id`, `country_name`, `iso_code2`, `iso_code3`, `reserved1`) values (201, 'Svalbard and Jan Mayen Islands', 'SJ', 'SJM', 0);
INSERT INTO `countries` (`country_id`, `country_name`, `iso_code2`, `iso_code3`, `reserved1`) values (202, 'Swaziland', 'SZ', 'SWZ', 0);
INSERT INTO `countries` (`country_id`, `country_name`, `iso_code2`, `iso_code3`, `reserved1`) values (203, 'Sweden', 'SE', 'SWE', 0);
INSERT INTO `countries` (`country_id`, `country_name`, `iso_code2`, `iso_code3`, `reserved1`) values (204, 'Switzerland', 'CH', 'CHE', 0);
INSERT INTO `countries` (`country_id`, `country_name`, `iso_code2`, `iso_code3`, `reserved1`) values (205, 'Syrian Arab Republic', 'SY', 'SYR', 0);
INSERT INTO `countries` (`country_id`, `country_name`, `iso_code2`, `iso_code3`, `reserved1`) values (206, 'Taiwan', 'TW', 'TWN', 0);
INSERT INTO `countries` (`country_id`, `country_name`, `iso_code2`, `iso_code3`, `reserved1`) values (207, 'Tajikistan', 'TJ', 'TJK', 0);
INSERT INTO `countries` (`country_id`, `country_name`, `iso_code2`, `iso_code3`, `reserved1`) values (208, 'Tanzania, United Republic of', 'TZ', 'TZA', 0);
INSERT INTO `countries` (`country_id`, `country_name`, `iso_code2`, `iso_code3`, `reserved1`) values (209, 'Thailand', 'TH', 'THA', 0);
INSERT INTO `countries` (`country_id`, `country_name`, `iso_code2`, `iso_code3`, `reserved1`) values (210, 'Togo', 'TG', 'TGO', 0);
INSERT INTO `countries` (`country_id`, `country_name`, `iso_code2`, `iso_code3`, `reserved1`) values (211, 'Tokelau', 'TK', 'TKL', 0);
INSERT INTO `countries` (`country_id`, `country_name`, `iso_code2`, `iso_code3`, `reserved1`) values (212, 'Tonga', 'TO', 'TON', 0);
INSERT INTO `countries` (`country_id`, `country_name`, `iso_code2`, `iso_code3`, `reserved1`) values (213, 'Trinidad and Tobago', 'TT', 'TTO', 0);
INSERT INTO `countries` (`country_id`, `country_name`, `iso_code2`, `iso_code3`, `reserved1`) values (214, 'Tunisia', 'TN', 'TUN', 0);
INSERT INTO `countries` (`country_id`, `country_name`, `iso_code2`, `iso_code3`, `reserved1`) values (215, 'Turkey', 'TR', 'TUR', 0);
INSERT INTO `countries` (`country_id`, `country_name`, `iso_code2`, `iso_code3`, `reserved1`) values (216, 'Turkmenistan', 'TM', 'TKM', 0);
INSERT INTO `countries` (`country_id`, `country_name`, `iso_code2`, `iso_code3`, `reserved1`) values (217, 'Turks and Caicos Islands', 'TC', 'TCA', 0);
INSERT INTO `countries` (`country_id`, `country_name`, `iso_code2`, `iso_code3`, `reserved1`) values (218, 'Tuvalu', 'TV', 'TUV', 0);
INSERT INTO `countries` (`country_id`, `country_name`, `iso_code2`, `iso_code3`, `reserved1`) values (219, 'Uganda', 'UG', 'UGA', 0);
INSERT INTO `countries` (`country_id`, `country_name`, `iso_code2`, `iso_code3`, `reserved1`) values (220, 'Ukraine', 'UA', 'UKR', 0);
INSERT INTO `countries` (`country_id`, `country_name`, `iso_code2`, `iso_code3`, `reserved1`) values (221, 'United Arab Emirates', 'AE', 'ARE', 0);
INSERT INTO `countries` (`country_id`, `country_name`, `iso_code2`, `iso_code3`, `reserved1`) values (222, 'United Kingdom', 'GB', 'GBR', 0);
INSERT INTO `countries` (`country_id`, `country_name`, `iso_code2`, `iso_code3`, `reserved1`) values (223, 'United States', 'US', 'USA', 0);
INSERT INTO `countries` (`country_id`, `country_name`, `iso_code2`, `iso_code3`, `reserved1`) values (224, 'United States Minor Outlying Islands', 'UM', 'UMI', 0);
INSERT INTO `countries` (`country_id`, `country_name`, `iso_code2`, `iso_code3`, `reserved1`) values (225, 'Uruguay', 'UY', 'URY', 0);
INSERT INTO `countries` (`country_id`, `country_name`, `iso_code2`, `iso_code3`, `reserved1`) values (226, 'Uzbekistan', 'UZ', 'UZB', 0);
INSERT INTO `countries` (`country_id`, `country_name`, `iso_code2`, `iso_code3`, `reserved1`) values (227, 'Vanuatu', 'VU', 'VUT', 0);
INSERT INTO `countries` (`country_id`, `country_name`, `iso_code2`, `iso_code3`, `reserved1`) values (228, 'Vatican City State (Holy See)', 'VA', 'VAT', 0);
INSERT INTO `countries` (`country_id`, `country_name`, `iso_code2`, `iso_code3`, `reserved1`) values (229, 'Venezuela', 'VE', 'VEN', 0);
INSERT INTO `countries` (`country_id`, `country_name`, `iso_code2`, `iso_code3`, `reserved1`) values (230, 'Viet Nam', 'VN', 'VNM', 0);
INSERT INTO `countries` (`country_id`, `country_name`, `iso_code2`, `iso_code3`, `reserved1`) values (231, 'Virgin Islands (British)', 'VG', 'VGB', 0);
INSERT INTO `countries` (`country_id`, `country_name`, `iso_code2`, `iso_code3`, `reserved1`) values (232, 'Virgin Islands (U.S.)', 'VI', 'VIR', 0);
INSERT INTO `countries` (`country_id`, `country_name`, `iso_code2`, `iso_code3`, `reserved1`) values (233, 'Wallis and Futuna Islands', 'WF', 'WLF', 0);
INSERT INTO `countries` (`country_id`, `country_name`, `iso_code2`, `iso_code3`, `reserved1`) values (234, 'Western Sahara', 'EH', 'ESH', 0);
INSERT INTO `countries` (`country_id`, `country_name`, `iso_code2`, `iso_code3`, `reserved1`) values (235, 'Yemen', 'YE', 'YEM', 0);
INSERT INTO `countries` (`country_id`, `country_name`, `iso_code2`, `iso_code3`, `reserved1`) values (236, 'Yugoslavia', 'YU', 'YUG', 0);
INSERT INTO `countries` (`country_id`, `country_name`, `iso_code2`, `iso_code3`, `reserved1`) values (237, 'Zaire', 'ZR', 'ZAR', 0);
INSERT INTO `countries` (`country_id`, `country_name`, `iso_code2`, `iso_code3`, `reserved1`) values (238, 'Zambia', 'ZM', 'ZMB', 0);
INSERT INTO `countries` (`country_id`, `country_name`, `iso_code2`, `iso_code3`, `reserved1`) values (239, 'Zimbabwe', 'ZW', 'ZWE', 0);