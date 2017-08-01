mysql -uroot -e "CREATE DATABASE IF NOT EXISTS starname;"
mysql -uroot -e "DROP DATABASE IF EXISTS homestead;"
mysql -uroot -e "GRANT ALL PRIVILEGES ON *.* TO 'starname'@'%' IDENTIFIED BY 'starname'; FLUSH PRIVILEGES;"