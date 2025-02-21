#!/usr/bin/env bash
mysql -u root -p -e "DROP DATABASE IF EXISTS usmansaleem234_lyskills_new_testing;
CREATE DATABASE usmansaleem234_lyskills_new_testing;
GRANT ALL PRIVILEGES ON usmansaleem234_lyskills_new_testing.* TO 'your_db_user'@'localhost';" 