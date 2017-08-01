#Set Up in Local Development

## Install Xcode

```$ xcode-select --install```

## Install Homebrew

```
$ ruby -e "$(curl -fsSL https://raw.githubusercontent.com/Homebrew/install/master/install)"
$ brew doctor
$ brew update
$ brew upgrade
```
## Install PHP-FPM
```
$ brew tap homebrew/dupes
$ brew tap homebrew/php
$ brew install php71 --without-apache --with-fpm --with-mysql
$ brew install php71-mcrypt
```
## Start, Stop and Restart php-fpm
```
$ sudo brew services start php71
$ vsudo brew services stop php71
$ sudo brew services reload php71
```

## Setup PHP CLI binary
 ### If you use the default Bash shell:
 ``` 
 echo 'export PATH="/usr/local/sbin:$PATH"' >> ~/.bash_profile && . ~/.bash_profile
 ```
## Install MySQL
```
$ brew install mysql
$ mysql_secure_installation
```

## Install Nginx
```
$ brew install nginx
$ ln -sfv /usr/local/opt/nginx/*.plist ~/Library/LaunchAgents 
```

## Install Composer 
```
$ curl -sS https://getcomposer.org/installer | php
$ mv composer.phar /usr/local/bin/composer

```

## nginx.conf
```
$ mkdir -p /usr/local/etc/nginx/logs
$ mkdir -p /usr/local/etc/nginx/sites-available
$ mkdir -p /usr/local/etc/nginx/sites-enabled
$ mkdir -p /usr/local/etc/nginx/conf.d
$ mkdir -p /usr/local/etc/nginx/ssl
$ sudo mkdir -p /var/www
$ sudo chown :staff /var/www
$ sudo chmod 775 /var/www

```
## Change nginx.conf
```
$ rm /usr/local/etc/nginx/nginx.conf
$ curl -L https://gist.github.com/frdmn/7853158/raw/nginx.conf -o /usr/local/etc/nginx/nginx.conf
```

## Load PHP-FPM
```
$ curl -L https://gist.github.com/frdmn/7853158/raw/php-fpm -o /usr/local/etc/nginx/conf.d/php-fpm
```
## Sample virtualhost
```
curl -L https://gist.github.com/frdmn/7853158/raw/sites-available_default -o /usr/local/etc/nginx/sites-available/default

``` 