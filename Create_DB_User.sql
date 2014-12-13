DROP USER 'cmscrud'@'localhost';
CREATE USER 'cmscrud'@'localhost' IDENTIFIED BY 'password';
GRANT SELECT, INSERT, UPDATE, DELETE ON cms.* TO 'cmscrud'@'localhost' IDENTIFIED BY 'password'; 