CREATE TABLE IF NOT EXISTS `notifications` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `datetime` datetime DEFAULT NULL,
  `smsText` varchar(255) DEFAULT NULL,
  `smsLength` int(11) DEFAULT NULL,
  `objecten` varchar(255) DEFAULT NULL,
  `senderId` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1;

CREATE TABLE IF NOT EXISTS `subscriptions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `telefoonnummer` varchar(255) DEFAULT NULL,
  `object` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1;

CREATE TABLE IF NOT EXISTS `subscriptions_log` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `telefoonnummer` varchar(255) DEFAULT NULL,
  `objecten` TEXT DEFAULT NULL,
  `datetime` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1;

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(255) DEFAULT NULL,
  `passwordHash` varchar(255) DEFAULT NULL,
  `hashAlgorithm` varchar(255) DEFAULT NULL,
  `accessToken` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1;
