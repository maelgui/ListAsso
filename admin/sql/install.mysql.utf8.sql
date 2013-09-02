DROP TABLE IF EXISTS `#__listasso`;

CREATE TABLE `#__listasso` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ville` int(11) NOT NULL,
  `type` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `contact` varchar(255) NOT NULL,
  `website` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=0 ;


DROP TABLE IF EXISTS `#__ville`;

CREATE TABLE IF NOT EXISTS `#__ville` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=0 ;


INSERT INTO `#__listasso` (`ville`, `type`, `name`, `contact`) VALUES
        ('1', 'BASKET', 'Montfort Basket Club', 'mbc@hgf.com'),
        ('1', 'HANDball', 'Brocelihand', 'mbc@hgf.com');

INSERT INTO `#__ville` (`name`) VALUES
        ('hgfd');