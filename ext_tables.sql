#
# Table structure for table 'tx_redirectsearch_search'
#
CREATE TABLE tx_redirectsearch_search (
	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,
	tstamp int(11) DEFAULT '0' NOT NULL,
	crdate int(11) DEFAULT '0' NOT NULL,
	cruser_id int(11) DEFAULT '0' NOT NULL,
	sorting int(10) DEFAULT '0' NOT NULL,
	deleted tinyint(4) DEFAULT '0' NOT NULL,
	hidden tinyint(4) DEFAULT '0' NOT NULL,
	hotkey tinytext,
	url tinytext,
	marker tinyint(3) DEFAULT '0' NOT NULL,
	usetsmarker tinyint(3) DEFAULT '0' NOT NULL,
    tsmarker text,
	useadvanced tinyint(3) DEFAULT '0' NOT NULL,
	advanced tinytext,
	
	PRIMARY KEY (uid),
	KEY parent (pid)
);
