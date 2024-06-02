## Development
1. Turn on xampp
2. PHP server
```
php artisan serve --port=8080
```
3. Turn on npm server
```
npm run watch
```

## Development Guildlines
1. Add all global setting constants in ```custom_lib .blade.php```
2. custom javascript functions in ```common_functions.js```
3. show loader on user request ```profile.js``` and search for ```hide loader``` & ```show loader```
4. server logs ```server_logs``` function in ```helper.php```
5. server configuration ```php_config``` function in ```helper.php```
6. whm password
```
4mEK10gw5n9d5BtEWN
```
7. DB password
```
BurraqLyskillsEngineering65$
```
8. Checkout storage on server
```
df -hi
```
9. cloudflare setup for extra security

## Local Setup (Development)
1. install xampp (Required PHP version -> 8.1) [Download Link](https://downloadsapachefriends.global.ssl.fastly.net/7.4.30/xampp-windows-x64-7.4.30-1-VC15-installer.exe?from_af=true)
2. download node 16.18.0
2. Go to .env file and change the DB connection
3. Create a database <b>usmansaleem234_lyskills_new</b>
4. You need to follow of either mentioned path
    1. One
        1. run
           1. usmansaleem234_lyskills_new.sql
           2.  <b>user_ann_models.sql</b>
        file locally. These files are avaiable in the source code, path /
        3. Add primary key manually in every table or create a alter query and try changing table name and primary key column
    2. Second
        1. php artisan migrate
        2. Get dump from someone else and upload
5. composer install
6. npm install
7. php artisan serve --port=8081

## Troubleshooting
.env file
```
nano /home/usmansaleem234/public_html/.env
```
laravel logs
```
cd /home/usmansaleem234/public_html/storage/logs
```

create symbolink/link/shortcut in differnt folder
*PS: * bash is original path, /bin/sh is target path
```
sudo ln -sf bash /bin/sh
```

check if mysql server is running or not
```
ss -ae | grep mysql
```

mysql configuration file finder
```
which mysqld
```
```
/usr/sbin/mysqld --verbose --help | grep -A 1 "Default options"
```

mysql config
```
nano /etc/my.cnf
```
find mysql log file path
```
my_print_defaults --mysqld | grep log-error
```

or
```
mariadbd --print-defaults
```
[more](https://mariadb.com/kb/en/error-log/#finding-the-error-log)

```
nano /var/lib/mysql/server1.nctest.net.err
```
OR detailed mysql logs by default PS: to find find datadir & hostname. Full path will be datadir/hostname.err
```
nano /var/lib/mysql/server1.lyskills.com.err
```
General logs
```
nano /var/lib/mysql/err.log
```

delete multiple lines in nano
```
use CTRL+Shift+6 to mark the beginning of your block
move cursor with arrow keys to end of your block, the text will be highlighted.
use CTRL+K to cut/delete block.
```

hostname finder
```
hostname
```
value
```
server1.lyskills.com
```
datadir finder
```
mysql -uusmansaleem234_lyskills_root5 -p -e 'SHOW VARIABLES WHERE Variable_Name LIKE "%dir"'
```
OR login to mysql and run the following
```
select @@datadir;
```
OR
```
mysqld --verbose --help | grep ^datadir
```

mysql connection
```
mysql -h 127.0.0.1 -P 3306 -u usmansaleem234_lyskills_root5 -p
```
password
```
BurraqLyskillsEngineering65$
```

mysql configuration
```
systemctl daemon-reload && systemctl restart mysql
```
```
systemctl status mysql
```
or

```
journalctl -xe
```
```
systemctl start mysql
```

```
nano /etc/my.cnf
```
change group ownership/permission
```
chgrp user_name file/folder
```
change user ownership/permission
```
chown user_name file/folder
```
change permission
```
chmod 666/777/+rwx/-rwx/+rw/-rw/ file/folder
```


```
mysql -h 203.161.43.113 -P 3306 -u usmansaleem234_lyskills_root5 -p
```
Laravel cache clear
```
cd /home/usmansaleem234/public_html &&
php artisan config:clear
```
```
cd /home/usmansaleem234/public_html &&
php artisan config:cache
```


### How to change WHM password
1. Go VPS by logging to namecheap > dashboard > Go to domain > open VPS
2. Root/Admin password
3. change (wait for 10-15 minutes)
4. new password should pop up



### Change s3 bucket
1. https://laravel-news.com/using-aws-s3-for-laravel-storage
POV: To find the URL, upload something in bucket and open it in new tab

How to fix 'The file failed to upload.' error using any validation for image upload - Laravel 5.7 
1. Login to WHM > search ``` PHP INI editor``` > Choose php81 > update the setting according to cpanel ``` INI editor```

### apache server
1. apache status
```
 systemctl status httpd
```
apache configuration file validation command
```
apachectl configtest
```
```
nano conf/httpd.conf
```

apache configration command
```
apachectl -V | grep SERVER_CONFIG_FILE
```

php configration file location for apache server
```
php --ini
```

```
nano /opt/cpanel/ea-php80/root/etc/php.ini

```
namecheap
Refer [namecheap](./namecheap.issues.md)
<br/>
issues [lyskills issues](./issues.server.md)



## Fresh Laravel Project
```Back Up on the server```
1. Fetch SSH connections
2. Verify PHP version, composer version && node JS
3. Verify apache/nginx version
4. Verify mysql connection
5. Create FTP access
6. Local setup laravel
7. Change .htaccess/php.ini/user.ini configuration in the main folder of laravel
8. Setup PHP configuration from PHP INI editor on the server
9. Setup Git & Github repo
10. Update ```script``` in
```
ftp_live_deployment.lyskills.yml
```