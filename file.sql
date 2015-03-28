CREATE TABLE `file` (
 `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
 `path` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Full path to file',
 `alt` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'alt',
 `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'title',
 PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci