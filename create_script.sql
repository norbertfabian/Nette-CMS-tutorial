CREATE TABLE IF NOT EXISTS `article` (
`article_id` int(11) NOT NULL,
  `title` varchar(255) COLLATE utf8_czech_ci DEFAULT NULL,
  `content` text COLLATE utf8_czech_ci,
  `url` varchar(255) COLLATE utf8_czech_ci DEFAULT NULL,
  `description` varchar(255) COLLATE utf8_czech_ci DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;


INSERT INTO `article` (`article_id`, `title`, `content`, `url`, `description`) VALUES
(1, 'Úvod', '<p>Vítejte na našem webu!</p>\r\n\r\n<p>Tento web je postaven na <strong>jednoduchém redakčním systému v Nette frameworku</strong>. Toto je úvodní článek, načtený z databáze.</p>', 'uvod', 'Úvodní článek na webu v Nette v PHP'),
(2, 'Stránka nebyla nalezena', '<p>Litujeme, ale požadovaná stránka nebyla nalezena. Zkontrolujte prosím URL adresu.</p>', 'chyba', 'Stránka nebyla nalezena.');

ALTER TABLE `article`
ADD PRIMARY KEY (`article_id`), ADD UNIQUE KEY `url` (`url`);

ALTER TABLE `article`
MODIFY `article_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;