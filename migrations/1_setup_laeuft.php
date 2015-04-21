<?php

class SetupLaeuft extends DBMigration {

    function up() {

        // Create printer table
        DBManager::get()->exec("CREATE TABLE `laeuft` (
  `laeuft_id` varchar(32) NOT NULL DEFAULT '',
  `user_id` varchar(32) NOT NULL DEFAULT '',
  PRIMARY KEY (`laeuft_id`),
  KEY (`user_id`)
)");
    }

    function down() {
        DBManager::get()->exec("DROP TABLE IF EXISTS `laeuft`");
    }

}
