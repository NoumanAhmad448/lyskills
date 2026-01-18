<h3 align="center">
Lyskills
</h3>
<p align="center">
    A platform for learning and practicing skills
</p>

<div align="center">

<a href="https://github.com/NoumanAhmad448/lyskills/stargazers">
    <img src="https://img.shields.io/github/stars/hiyouga/LLaMA-Factory?style=social" alt="GitHub Repo stars"/>
</a>
<a href="https://github.com/NoumanAhmad448/lyskills/commits/master">
    <img src="https://img.shields.io/github/last-commit/NoumanAhmad448/lyskills" alt="GitHub last commit"/>
</a>
<a href="https://github.com/NoumanAhmad448/lyskills/graphs/contributors">
    <img src="https://img.shields.io/github/contributors/hiyouga/LLaMA-Factory?color=orange" alt="GitHub contributors"/>
</a>
<a href="https://github.com/NoumanAhmad448/lyskills/pulls">
    <img src="https://img.shields.io/badge/PRs-welcome-blue" alt="GitHub pull request"/>
</a>
</div>
</div>

A **Video-Based Learning Management System (LMS)** is a specialized platform designed to deliver, manage, and track educational courses and training programs primarily through video content. It is widely used in online education, corporate training, and skill development to provide an engaging and flexible learning experience.


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
## Docker Support
Run following commands for docker setup
```
docker compose build --no-cache
docker compose up -d
```
and then
```
127.0.0.1:8081
```
in the browser.
``` We also support deploying docker in your remote server. For more information, please review```
```
ftp_live_deployment.lyskills.yml
```

## Development Guildlines

1. Add all global setting constants in `custom_lib .blade.php`
2. custom javascript functions in `common_functions.js`
3. show loader on user request `profile.js` and search for `hide loader` & `show loader`
4. server logs `server_logs` function in `helper.php`
5. server configuration `php_config` function in `helper.php`

6. Add all global setting constants in `custom_lib .blade.php`
7. custom javascript functions in `common_functions.js`
8. show loader on user request `profile.js` and search for `hide loader` & `show loader`
9. server logs `server_logs` function in `helper.php`
10. server configuration `php_config` function in `helper.php`
11. All php related dates or carbon classes is in ```LyskillsCarbon```

```
8. Checkout storage on server
```

df -hi

```
9. cloudflare setup for extra security
[Todo list after registeration](./cloudflare.todo.md)

## Local Setup (For Development)
1. install xampp (Required PHP version -> 8.1) [Download Link](https://downloadsapachefriends.global.ssl.fastly.net/7.4.30/xampp-windows-x64-7.4.30-1-VC15-installer.exe?from_af=true)
2. download node from https://github.com/coreybutler/nvm-windows/releases and use 20.0
2. Copy

file and change the DB connection

1. Create a database <b>db</b>
2. You need to follow of either mentioned path
    1. One
        1. run
            1. db.sql
            2. <b>user_ann_models.sql</b>
               file locally. These files are avaiable in the source code, path /
        2. Add primary key manually in every table or create a alter query and try changing table name and primary key column
    2. Second
        1. php artisan migrate
        2. Get dump from someone else and upload
3. Create following folders
```
mkdir -p /home/nomilyskills/public_html/storage/app 
mkdir -p /home/nomilyskills/public_html/storage/framework/cache
mkdir -p /home/nomilyskills/public_html/storage/framework/sessions 
mkdir -p /home/nomilyskills/public_html/storage/framework/views
mkdir -p /home/nomilyskills/public_html/storage/logs
```
4. Run
```

composer install

```
5. Run
```

npm install

```
6. Finally😍😍😍 Run
```

php artisan serve --port=8081

```

```

# Comprehensive Deployment Guidelines for Lyskills

This guide provides step-by-step instructions for deploying the **Lyskills** Laravel project to a server. It covers everything from preparing the project locally to configuring the server and verifying the deployment.

---

## **1. Pre-Deployment Preparation**

### **1.1. Verify Local Environment**

1. **PHP Version**: Ensure PHP 8.1 or higher is installed.
    ```bash
    php -v
    ```

```

```

2. **Composer**: Install Composer and verify its version.
    ```bash
    composer --version
    ```
    ```bash
    composer --version
    ```
3. **Node.js**: Install Node.js and verify its version.
    ```bash
    node -v
    npm -v
    ```
    ```bash
    node -v
    npm -v
    ```

### **1.2. Prepare the Laravel Project**

1. **Update `.env` File**:

    - Configure the `.env` file with the correct database credentials, app URL, and other environment-specific settings.
    - Example:
      `env APP_URL=http://your_website.com DB_HOST=127.0.0.1 DB_DATABASE=lyskills_db DB_USERNAME=web_server_lyskills_root5 DB_PASSWORD=your_password`
      `Skip this step if you are using ftp_live_deployment.lyskills.yml for CI/CD pipeline deployment. Ensure all secrets are set in the github repo secrets.`

    - Configure the `.env` file with the correct database credentials, app URL, and other environment-specific settings.
    - Example:
      `env APP_URL=http://your_website.com DB_HOST=127.0.0.1 DB_DATABASE=lyskills_db DB_USERNAME=web_server_lyskills_root5 DB_PASSWORD=your_password`
      `Skip this step if you are using ftp_live_deployment.lyskills.yml for CI/CD pipeline deployment. Ensure all secrets are set in the github repo secrets.`

2. **Clear Laravel Cache**:
   Run the following commands to clear the cache and optimize the project:

    ```bash
    php artisan config:clear
    php artisan cache:clear
    php artisan view:clear
    php artisan route:clear
    php artisan optimize
    ```

    ```bash
    php artisan config:clear
    php artisan cache:clear
    php artisan view:clear
    php artisan route:clear
    php artisan optimize
    ```

3. **Install Dependencies**:
   Install Composer and Node.js dependencies:
    ```bash
    composer install --no-dev --optimize-autoloader
    npm install
    npm run production
    ```
    ```bash
    composer install --no-dev --optimize-autoloader
    npm install
    npm run production
    ```

---

## **2. Server Configuration**

### **2.1. Verify Server Requirements**

1. **PHP Version**: Ensure the server has PHP 8.1 or higher.
    ```bash
    php -v
    ```
    ```bash
    php -v
    ```
2. **Apache/Nginx**: Verify the web server is running.
    ```bash
    systemctl status httpd  # For Apache
    systemctl status nginx  # For Nginx
    ```
    ```bash
    systemctl status httpd  # For Apache
    systemctl status nginx  # For Nginx
    ```
3. **MySQL**: Ensure MySQL is installed and running.
    ```bash
    systemctl status mysql
    ```
    ```bash
    systemctl status mysql
    ```

### **2.2. Create FTP Access**

1. In cPanel, go to **FTP Accounts**.
2. Create a new FTP account with access to the domain's root directory (e.g., `/home/web_server/public_html`).

---

## **3. Upload the Project to the Server**

### **3.1. Connect via FTP**

1. Use an FTP client like **FileZilla**.
2. Enter the following details:
    - **Host**: `your_website.com` or the server IP.
    - **Username**: `your_ftp_username` (e.g., `lyskills_user@your_website.com`).
    - **Password**: Your FTP password.
    - **Port**: `21` (default FTP port).
    - **Host**: `your_website.com` or the server IP.
    - **Username**: `your_ftp_username` (e.g., `lyskills_user@your_website.com`).
    - **Password**: Your FTP password.
    - **Port**: `21` (default FTP port).
3. Upload the Laravel project files to the server's root directory (e.g., `/home/web_server/public_html`).

### **3.2. Set File Permissions**

Set the correct permissions for the Laravel project:

```bash
chmod -R 755 /home/web_server/public_html
chmod -R 775 /home/web_server/public_html/storage
chmod -R 775 /home/web_server/public_html/bootstrap/cache
```

---

## **4. Configure the Server**

### **4.1. Update Apache Configuration**

1. Edit the Apache configuration file:
    ```bash
    nano /etc/httpd/conf/httpd.conf
    ```
    ```bash
    nano /etc/httpd/conf/httpd.conf
    ```
2. Ensure the `DocumentRoot` points to the Laravel project's `public` directory:
    ```apache
    DocumentRoot "/home/web_server/public_html/public"
    ```
    ```apache
    DocumentRoot "/home/web_server/public_html/public"
    ```
3. Restart Apache:
    ```bash
    systemctl restart httpd
    ```
    ```bash
    systemctl restart httpd
    ```

### **4.2. Update PHP Configuration**

1. Edit the PHP configuration file:
    ```bash
    nano /opt/cpanel/ea-php80/root/etc/php.ini
    ```
    ```bash
    nano /opt/cpanel/ea-php80/root/etc/php.ini
    ```
2. Ensure the following settings are configured:
    ```ini
    upload_max_filesize = 8G
    post_max_size = 8G
    memory_limit = 8G
    ```
    ```ini
    upload_max_filesize = 8G
    post_max_size = 8G
    memory_limit = 8G
    ```

---

## **5. Database Setup**

### **5.1. Import the Database**

1. Connect to MySQL:
    ```bash
    mysql -h 127.0.0.1 -P 3306 -u web_server_lyskills_root5 -p
    ```
    ```bash
    mysql -h 127.0.0.1 -P 3306 -u web_server_lyskills_root5 -p
    ```
2. Create a new database (if not already created):
    ```sql
    CREATE DATABASE lyskills_db;
    ```
    ```sql
    CREATE DATABASE lyskills_db;
    ```
3. Import the database dump:
    ```bash
    mysql -u web_server_lyskills_root5 -p lyskills_db < /path/to/dump.sql
    ```
   
### **5.2. Verify Database Connection**

Ensure the `.env.example` file has the correct database credentials:

```env
DB_HOST=127.0.0.1
DB_DATABASE=lyskills_db
DB_USERNAME=web_server_lyskills_root5
DB_PASSWORD=your_password
```

---

## **6. Verify the Deployment**

### **6.1. Test the Website**

1. Open your browser and navigate to `http://your_website.com`.
2. Verify that the Laravel application loads correctly.

### **6.2. Check Laravel Logs**

If there are issues, check the Laravel logs:

```bash
nano /home/web_server/public_html/storage/logs/laravel.log
```

---

## **Post-Deployment Tasks**

### **7.1. Set Up Cron Jobs**

Set up a cron job for Laravel's scheduler:

1. Open the crontab:
    ```bash
    crontab -e
    ```
    ```bash
    crontab -e
    ```
2. Add the following line:
    ```bash
    * * * * * php /home/web_server/public_html/artisan schedule:run >> /dev/null 2>&1
    ```

### **7.2. Configure Queue Workers**

If using queues, start the queue worker:

```bash
php /home/web_server/public_html/artisan queue:work --daemon
```

---

## **8. Troubleshooting**

### **8.1. File Upload Issues**

-   Ensure `upload_max_filesize` and `post_max_size` are increased in `php.ini`.
-   Verify file permissions for the `storage` directory.

-   Ensure `upload_max_filesize` and `post_max_size` are increased in `php.ini`.
-   Verify file permissions for the `storage` directory.

### **8.2. MySQL Connection Issues**

-   Verify MySQL credentials in `.env`.
-   Ensure the MySQL service is running:

    ```bash
    systemctl status mysql
    ```

-   Verify MySQL credentials in `.env`.
-   Ensure the MySQL service is running:
    ```bash
    systemctl status mysql
    ```

### **8.3. Apache Configuration Errors**

-   Check for syntax errors:
    ```bash
    apachectl configtest
    ```
-   Ensure the `mod_rewrite` module is enabled.

-   Check for syntax errors:
    ```bash
    apachectl configtest
    ```
-   Ensure the `mod_rewrite` module is enabled.

By following these comprehensive deployment guidelines, you can successfully deploy the **Lyskills** Laravel project to the server.