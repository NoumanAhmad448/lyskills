# For local developement
1. install xampp (Required PHP version -> 7.4.3) [Download Link](https://downloadsapachefriends.global.ssl.fastly.net/7.4.30/xampp-windows-x64-7.4.30-1-VC15-installer.exe?from_af=true)
2. Go to .env file and change the DB connection
3. You are following either of track for db data
    1. One
        1. run <b>usmansaleem234_lyskills_new.sql </b> and <b>user_ann_models.sql</b> file locally. These files are avaiable in the source code, path /
        2. Add primary key manually in every table or create a alter query and try changing table name and primary key column
    2. Second
        1. php artisan migrate
        2. Get dump from someone else and upload
4. composer install
5. npm install
6. php artisan serve --port=8081


# Dockerize Version
