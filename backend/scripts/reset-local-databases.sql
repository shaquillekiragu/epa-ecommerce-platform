-- Drops and recreates the local databases used by this Yii2 app.
-- Run with: mysql -u root -p < backend/scripts/reset-local-databases.sql

DROP DATABASE IF EXISTS `ecom_platform_db`;
CREATE DATABASE `ecom_platform_db`
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

DROP DATABASE IF EXISTS `ecom_platform_db_test`;
CREATE DATABASE `ecom_platform_db_test`
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;
