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


# Server Configurations
nano /var/log/nginx/test-django.error.log debug;
nano  /var/log/nginx/test-django.access.log

nano /etc/uwsgi/test_django.log
nano /etc/uwsgi/sites/test_django.ini
systemctl status uwsgi.service
systemctl restart uwsgi

netstat -na|grep LISTEN |grep :81
cd /run/uwsgi

public_html/test-django.lyskills.com/

nano /etc/systemd/system/uwsgi.service
nano  /etc/nginx/nginx.conf
