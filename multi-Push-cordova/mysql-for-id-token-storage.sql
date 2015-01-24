-- create table 'push' for save devices ID or TOKEN

CREATE TABLE IF NOT EXISTS `consumer_push` (
`push_id` int(255) NOT NULL,
  `push_tokenApple` longtext NOT NULL,
  `push_idGoogle` longtext NOT NULL,
  `push_device` longtext NOT NULL,
  `register_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=0 ;