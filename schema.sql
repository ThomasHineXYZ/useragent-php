/**
 * User Agent schema
 */

-- Disable foreign key checks until all schema has been created.
SET FOREIGN_KEY_CHECKS=0;

CREATE TABLE `user_agents` (
  `user_agent` varchar(256) NOT NULL COMMENT 'The entire user agent.',
  `device_type` varchar(7) NOT NULL COMMENT 'What type of device it is.',
  `languages` longtext CHARACTER SET utf8mb4 NOT NULL COMMENT 'List of supported languages.' CHECK (json_valid(`languages`)),
  `platform` varchar(16) NOT NULL COMMENT 'What software platform this is on.',
  `browser` varchar(16) NOT NULL COMMENT 'The name of the browser if it''s known.'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='List of stored user agents';

-- Enable foreign key checks.
SET FOREIGN_KEY_CHECKS=1;
# EOF
