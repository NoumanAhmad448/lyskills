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

# For Local developement
1. install xampp (Required PHP version -> 8.1) [Download Link](https://downloadsapachefriends.global.ssl.fastly.net/7.4.30/xampp-windows-x64-7.4.30-1-VC15-installer.exe?from_af=true)
2. download node 16.18.0
2. Go to .env file and change the DB connectio
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
mysql connection
```
mysql -h 127.0.0.1 -P 3306 -u usmansaleem234_lyskills_root5 -p
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


how to change WHM password
1. Go VPS by logging to namecheap > dashboard > Go to domain > open VPS
2. Root/Admin password
3. change (wait for 10-15 minutes)
4. new password should pop up



change s3 bucket
1. https://laravel-news.com/using-aws-s3-for-laravel-storage
POV: To find the URL, upload something in bucket and open it in new tab

How to fix 'The file failed to upload.' error using any validation for image upload - Laravel 5.7 
1. Login to WHM > search ``` PHP INI editor``` > Choose php81 > update the setting according to cpanel ``` INI editor```

apache server
1. apache status
```
 systemctl status httpd
```
apache configuration file validation command
```
apachectl configtest
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