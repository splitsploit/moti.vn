MOTI.VN

![image](https://user-images.githubusercontent.com/25485764/138134078-cfb89056-b4eb-4959-8fc1-20c5a01a3346.png)

![image](https://user-images.githubusercontent.com/25485764/138133706-98b641c8-fe28-48e4-a7f9-6c99e7e4b458.png)

![image](https://user-images.githubusercontent.com/25485764/138134680-34d3848e-d3b4-4a23-ab14-a6321d507f35.png)

![image](https://user-images.githubusercontent.com/25485764/138135090-f92f98c6-d781-4f17-855c-113c10470b23.png)

![image](https://user-images.githubusercontent.com/25485764/138135238-bcb4a0d8-8b0d-4961-8096-047cc8d69bc5.png)

## How to use:

- Clone the repository with __git clone__
- Update database credentials in __.env__
- Run __composer install__ (or __php composer.phar install__)
- Run __php artisan key:generate__
- Run __php artisan migrate --seed__ (it has some seeded data for your testing/__php artisan migrate:reset__) or __php artisan migrate:refresh --seed__
- Run __npm install__
- Run __sudo npm install --global cross-env__ (if have an error)
- Run __npm start__ (Start server localhost:8000)

- That's it: launch the main URL.
- Admin's credentials: __admin@admin.com__ - __password__
- Staff's credentials: __staff@staff.com__ - __password__
- Internship's credentials: __internship@internship.com__ - __password__
- Start MySQL and run __/usr/local/mysql/bin/mysql -u root -p12345678__   and __SET PASSWORD = PASSWORD('12345678');__
- When add new table and add default data seeder: __php artisan migrate__ and __php artisan db:seed --class=ConfigurationsSeeder__

## Clear all cache:

php artisan config:cache && php artisan cache:clear

# CONNECT EC2 AWS & GIT PULL

    cd /var/www/html/moti/ && git pull

# SETUP ENVIRONMENT FOR PRODUCTIVE:

(EC2, Ubuntu, Nginx, PHP, MySQL)

### EC2 AWS

Create new instance
Edit inbound rules > add new rules > Select HTTP > Select Anywhere

### ROOT:

    sudo su

### UPDATE DENPENCY:

    apt-get update

### NPM

    apt install npm

### PHP 7.4:

#### For Ubuntu 20.04:

    apt install -y php-mbstring php-xml php-fpm php-zip php-common php-fpm php-cli unzip curl nginx
    apt install php php-cli php-fpm php-json php-common php-mysql php-zip php-gd php-mbstring php-curl php-xml php-pear php-bcmath

#### For Ubuntu 18.04/16.04:

    apt install software-properties-common
    add-apt-repository ppa:ondrej/php
    apt-get update
    apt -y install php7.4
    apt-get install nginx php7.4-fpm
    apt-get install php7.4-mysql

### NGINX:

    add-apt-repository ppa:nginx/stable
    apt-get update
    apt-get install nginx
    sudo systemctl start nginx
    service nginx status

### COMPOSER:

    curl -s https://getcomposer.org/installer | php
    sudo mv composer.phar /usr/local/bin/composer
    composer diagnose

### MYSQL:

    apt-get install mysql-server
    systemctl status mysql
    mysql_secure_installation (optional)
    mysql

    mysql>CREATE USER 'moti_root'@'localhost' IDENTIFIED BY '*****';
    mysql>GRANT ALL PRIVILEGES ON * . * TO 'moti_root'@'localhost';
    mysql>FLUSH PRIVILEGES;
    mysql>CREATE DATABASE moti;
    mysql>exit;

### LARAVEL/SOURCECODE:

    cd /var/www/html

    SSH KEY (optional)
    ssh-keygen -t rsa -b 4096 -C "hongquyen196@gmail.com"
    vi ~/.ssh/id_rsa.pub

    git clone git@github.com:hongquyen196/moti.git

    cp .env.testing .env
    composer install --ignore-platform-reqs
    php artisan key:generate

### PERMISSION FOLDER LARAVEL:

    chmod -R 755 /var/www/html/moti
    chown -R www-data:www-data /var/www/html/moti
    chown -R www-data:www-data /var/www/html/moti/storage/framework
    chown www-data storage/logs/

### NGINX CONFIG FOR LARAVEL:

    vi /etc/nginx/sites-available/moti

    server {
        listen 80;
        server_name _;
        root /var/www/html/moti/public;

        add_header X-Frame-Options "SAMEORIGIN";
        add_header X-XSS-Protection "1; mode=block";
        add_header X-Content-Type-Options "nosniff";

        index index.php;

        charset utf-8;

        location / {
            try_files $uri $uri/ /index.php?$query_string;
        }

        location = /favicon.ico { access_log off; log_not_found off; }
        location = /robots.txt  { access_log off; log_not_found off; }

        error_page 404 /index.php;

        location ~ \.php$ {
            fastcgi_pass unix:/var/run/php/php7.4-fpm.sock;
            fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
            include fastcgi_params;
        }

        location ~ /\.(?!well-known).* {
            deny all;
        }
    }

    ln -s /etc/nginx/sites-available/moti /etc/nginx/sites-enabled/
    rm /etc/nginx/sites-enabled/default
    nginx -t
    service nginx restart (systemctl restart nginx)

### CHECK GREP PHP:

    ps aux | grep php

### CONFIG DATABASE .ENV

    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=moti
    DB_USERNAME=moti_root
    DB_PASSWORD=*****

### GENERATING DATABASE DATA DEFAULT:

    php artisan migrate:fresh --seed

### REFERENCE:

https://github.com/namttdh/yt-ec2-laravel/

### How to debug php laravel

Config /private/etc/php.ini

    [Zend]
    zend_extension=/usr/lib/php/extensions/no-debug-non-zts-20180731/xdebug.so
    xdebug.remote_enable=1
    xdebug.remote_handler=dbgp
    xdebug.remote_mode=req
    xdebug.remote_host=127.0.0.1
    xdebug.remote_port=9000

Add .vscode/launch.json

    {
        // Use IntelliSense to learn about possible attributes.
        // Hover to view descriptions of existing attributes.
        // For more information, visit: https://go.microsoft.com/fwlink/?linkid=830387
        "version": "0.2.0",
        "configurations": [
            {
                "name": "Listen for XDebug",
                "type": "php",
                "request": "launch",
                "port": 9000
            },
            {
                "name": "Launch currently open script",
                "type": "php",
                "request": "launch",
                "program": "${file}",
                "cwd": "${fileDirname}",
                "port": 9000
            }
        ]
    }

### How to use Docker compose:

    cd ~

    git clone https://github.com/hongquyen196/moti.git

    cd moti/

    cp .env.testing .env 

    vi .end (Set value server ID into DB_HOST)

    sudo su

    docker run --rm -v $(pwd):/app composer install --ignore-platform-reqs

    docker-compose up --build

    docker-compose exec app php artisan key:generate

    docker-compose exec app php artisan config:cache

    docker-compose exec app php artisan cache:clear

    docker-compose exec db bash

    mysql -u root -p

    mysql> GRANT ALL ON moti.* TO 'moti_admin'@'%' IDENTIFIED BY '*****';
    mysql> FLUSH PRIVILEGES;
    mysql> EXIT;

Refer:

- https://docs.docker.com/engine/install/ubuntu/#install-using-the-repository
- https://www.digitalocean.com/community/tutorials/how-to-set-up-laravel-nginx-and-mysql-with-docker-compose

### Configure HTTPS for production

Update .env

    APP_ENV=production
    APP_URL=https://moti.vn

### Backup & restore database:

    ssh root@139.180.216.199

    cd /var/www/html/moti/.bash/

Backup

    ./mysqlbackup.sh

Restore

    ./mysqlrestore.sh

### Get the backup file

    scp root@139.180.216.199:/var/www/html/moti/database/backups/mysqldb_2022-08-27.sql .

(If got an error Permission denied (public key). We need to add a public key from the local machine into /home/root/.ssh/known_hosts).

For docker:

    cat mysqldb_2021-04-04.sql | docker exec -i db /usr/bin/mysql -u root --password=12345678 moti

### Crontab

    chmod 755 /var/www/html/moti/.bash/mysqlbackup.sh

    crontab -e

Add 1 line into file and save:

    0 1 * * * /var/www/html/moti/.bash/mysqlbackup.sh

Show crontab:

    crontab -l


## Im not own this apps. Im just cloned from hongquyen196. Big thanks to owner