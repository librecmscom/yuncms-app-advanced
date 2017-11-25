# Centos 7 Nginx + PHP 安装步骤 

Centos 7 下的 PHP7/Nginx/Memcached 安装步骤。

### 一、获取相关开源程序

#### 1、安装环境所需的程序库

```bash
yum -y update
yum -y remove mariadb*

yum -y install patch make cmake gcc gcc-c++ bison flex file libtool libtool-libs autoconf re2c \
libaio libcap glibc glib2 kernel-devel glibc-devel glib2-devel systemd ncurses ncurses-devel

yum -y install curl wget nano unzip diffutils ntp java-1.8.0-openjdk

yum -y install libjpeg libpng freetype libxml2 zlib bzip2 libidn gettext libxslt libedit libtidy gd libyaml

yum -y install libxml2-devel openssl-devel bzip2-devel curl-devel libjpeg-devel libpng-devel freetype-devel \
cyrus-sasl-devel gmp-devel libedit-devel libtidy-devel libxslt-devel readline-devel libidn-devel zlib-devel  \
gettext-devel gd-devel libyaml-devel systemd-devel

yum -y install whois bind-utils git mailx
yum -y install supervisor memcached
systemctl enable memcached.service
systemctl enable supervisord.service
systemctl enable rsyncd.service

sed -i 's#CACHESIZE="64"#CACHESIZE="256"#' /etc/sysconfig/memcached
```
#### 2、准备环境变量

```bash
echo -e "/lib64\n/usr/lib64\n/usr/local/lib64\n/lib\n/usr/lib\n/usr/local/lib\n`cat /etc/ld.so.conf`" > /etc/ld.so.conf
/sbin/ldconfig
```

#### 3、下载程序源码包

```bash
cd /usr/local/src
wget http://7xk96f.com1.z0.glb.clouddn.com/software/libiconv/libiconv-1.15.tar.gz
wget -O php-7.1.11.tar.gz http://cn2.php.net/get/php-7.1.11.tar.gz/from/this/mirror
wget http://7xk96f.com1.z0.glb.clouddn.com/software/mcrypt/libmcrypt-2.5.8.tar.gz
wget http://7xk96f.com1.z0.glb.clouddn.com/software/mcrypt/mcrypt-2.6.8.tar.gz
wget http://7xk96f.com1.z0.glb.clouddn.com/software/mhash/mhash-0.9.9.9.tar.gz
wget http://7xk96f.com1.z0.glb.clouddn.com/software/icu/icu4c-58_2-src.tgz
wget http://7xk96f.com1.z0.glb.clouddn.com/software/libmemcached/libmemcached-1.0.18.tar.gz
wget http://nginx.org/download/nginx-1.13.6.tar.gz
wget http://pecl.php.net/get/msgpack-2.0.2.tgz
wget http://pecl.php.net/get/igbinary-2.0.5.tgz
wget http://pecl.php.net/get/memcached-3.0.3.tgz
wget http://pecl.php.net/get/redis-3.1.4.tgz
wget http://pecl.php.net/get/yaml-2.0.2.tgz
wget http://pecl.php.net/get/mongodb-1.3.2.tgz
```

### 二、安装PHP 7（FastCGI模式）

#### 1、编译安装PHP 7 所需的支持库：

```bash
tar zxf libiconv-1.15.tar.gz && cd libiconv-1.15/
./configure --prefix=/usr/local --libdir=/usr/local/lib64 --enable-static
make && make install
cd ../

tar zxf libmcrypt-2.5.8.tar.gz && cd libmcrypt-2.5.8/
./configure --prefix=/usr/local --libdir=/usr/local/lib64 --enable-static
make && make install
ldconfig
cd libltdl/
./configure --prefix=/usr/local  --libdir=/usr/local/lib64 --enable-ltdl-install
make && make install
cd ../../

tar zxf mhash-0.9.9.9.tar.gz && cd mhash-0.9.9.9/
./configure --prefix=/usr/local --libdir=/usr/local/lib64
make && make install
cd ../

tar zxf mcrypt-2.6.8.tar.gz && cd mcrypt-2.6.8/
/sbin/ldconfig
./configure --prefix=/usr/local --libdir=/usr/local/lib64
make && make install
cd ../

tar zxf icu4c-58_2-src.tgz && cd icu/source/
./configure --prefix=/usr/local --libdir=/usr/local/lib64 --enable-static 
make && make install
cd ../../
/sbin/ldconfig

tar -zxvf libmemcached-1.0.18.tar.gz && cd libmemcached-1.0.18
./configure --prefix=/usr/local --libdir=/usr/local/lib64 --with-memcached
make && make install
cd ../

/sbin/ldconfig
```

#### 2、编译安装PHP（FastCGI模式）

```bash
tar zxf php-7.1.11.tar.gz && cd php-7.1.11/
./configure --prefix=/usr/local --libdir=/usr/local/lib64 --with-config-file-path=/usr/local/etc --with-config-file-scan-dir=/usr/local/etc/php \
--with-libxml-dir --with-openssl --with-kerberos --with-zlib --enable-bcmath --with-bz2 --enable-calendar --with-curl \
--enable-exif --enable-fpm --enable-ftp --with-png-dir --with-gd --with-jpeg-dir --enable-gd-native-ttf \
--with-icu-dir=/usr/local --enable-mbstring --enable-mbregex --enable-shmop --enable-soap --enable-sockets \
--enable-sysvmsg --enable-sysvsem --enable-sysvshm --enable-wddx --with-xmlrpc --with-libedit --with-iconv-dir=/usr/local \
--with-xsl --enable-zip --with-pcre-regex --with-pcre-jit --with-freetype-dir --enable-xml  --with-mysqli=mysqlnd \
--with-pdo-mysql=mysqlnd --with-pdo-sqlite --with-sqlite3 --disable-rpath --enable-inline-optimization --with-mcrypt \
--with-mhash --enable-pcntl --without-pear --with-gettext --enable-fileinfo --enable-intl --enable-opcache --enable-cli \
--with-gmp --with-tidy --with-pcre-dir --with-readline --with-fpm-systemd --with-zlib-dir --with-libdir=lib64
make ZEND_EXTRA_LIBS='-liconv'
make install

cp php.ini-production /usr/local/etc/php.ini
cp /usr/local/etc/php-fpm.conf.default /usr/local/etc/php-fpm.conf
cp sapi/fpm/php-fpm.service /usr/lib/systemd/system/php-fpm.service
systemctl enable php-fpm.service
cd ../
```

#### 3、编译安装PHP扩展模块
```bash

tar zxf msgpack-2.0.2.tgz && cd msgpack-2.0.2
phpize
./configure 
make && make install
cd ../


tar zxf igbinary-2.0.5.tgz && cd igbinary-2.0.5
phpize
./configure
make && make install
cd ../


tar zxf memcached-3.0.3.tgz && cd memcached-3.0.3
phpize
./configure --enable-memcached --enable-memcached-igbinary --enable-memcached-json --enable-memcached-msgpack --with-libdir=lib64
make && make install
cd ../


tar zxf redis-3.1.4.tgz && cd  redis-3.1.4
phpize
./configure --enable-redis --enable-redis-igbinary 
make && make install
cd ../


tar zxf yaml-2.0.2.tgz && cd yaml-2.0.2
phpize
./configure
make && make install
cd ../


tar zxf mongodb-1.3.2.tgz && cd mongodb-1.3.2
phpize
./configure --enable-mongodb
make && make install
cd ../

mkdir -p /usr/local/etc/php
echo -e "[PHP]\nextension=msgpack.so" >> /usr/local/etc/php/msgpack.ini
echo -e "[PHP]\nextension=igbinary.so" >> /usr/local/etc/php/igbinary.ini
echo -e "[PHP]\nextension=memcached.so" >> /usr/local/etc/php/memcached.ini
echo -e "[PHP]\nextension=redis.so" >> /usr/local/etc/php/redis.ini
echo -e "[PHP]\nextension=yaml.so" >> /usr/local/etc/php/yaml.ini
echo -e "[PHP]\nextension=mongodb.so" >> /usr/local/etc/php/mongodb.ini

php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
php composer-setup.php --install-dir=/usr/local/bin --filename=composer
php -r "unlink('composer-setup.php');"


```

### 三、安装Nginx

```bash
tar zxf nginx-1.13.6.tar.gz && cd nginx-1.13.6/
./configure --prefix=/usr/local --conf-path=/usr/local/etc/nginx/nginx.conf --error-log-path=/var/log/nginx/error.log \
--http-client-body-temp-path=/var/lib/nginx/body --http-fastcgi-temp-path=/var/lib/nginx/fastcgi \
--http-log-path=/var/log/nginx/access.log --http-proxy-temp-path=/var/lib/nginx/proxy \
--lock-path=/run/lock/nginx.lock --pid-path=/run/nginx.pid --with-http_ssl_module --with-http_v2_module \
--with-http_image_filter_module --with-http_slice_module --with-http_xslt_module --with-http_realip_module \
--with-http_stub_status_module --with-pcre --with-pcre-jit --with-http_flv_module --with-http_mp4_module \
--with-http_addition_module --with-threads --with-http_secure_link_module --with-http_degradation_module \
--with-http_ssl_module --with-http_gzip_static_module --without-mail_imap_module --without-mail_pop3_module \
--without-mail_smtp_module --without-http_uwsgi_module --without-http_scgi_module --without-select_module \
--with-http_sub_module --with-cc-opt='-O2'

make && make install
cd ../
mkdir /var/log/nginx
mkdir /var/lib/nginx

echo -e "<?php\nphpinfo();\n?>" > /usr/local/html/xcr.php

ln -s /usr/local/etc/nginx/sites-available/default.conf /usr/local/etc/nginx/sites-enabled/default.conf


ln -s /usr/local/etc/nginx/sites-available/gen8.conf /usr/local/etc/nginx/sites-enabled/gen8.l68.net.conf
ln -s /usr/local/etc/nginx/sites-available/ubnt.conf /usr/local/etc/nginx/sites-enabled/ubnt.l68.net.conf
ln -s /usr/local/etc/nginx/sites-available/esxi.conf /usr/local/etc/nginx/sites-enabled/esxi.l68.net.conf
```

### 四、安装 Memcached

```bash
yum -y install memcached

sed -i 's#CACHESIZE="64"#CACHESIZE="128"#' /etc/sysconfig/memcached
```

### 四、收尾

#### 1、添加www用户

```bash
/usr/sbin/groupadd www
//不创建Home
/usr/sbin/useradd -M -g www www

##创建home
/usr/sbin/useradd -m -g www tintsoft

/usr/sbin/useradd -m -g www l68

//不创建Home
/usr/sbin/useradd -M -g www www
```

#### 2、优化内核

```bash
#for aliyun
cat >>/etc/security/limits.conf<<eof
* soft nproc 65535
* hard nproc 65535
eof

#other
cat >>/etc/security/limits.conf<<eof
* soft nproc 655350
* hard nproc 655350
* soft nofile 655350
* hard nofile 655350
eof

echo "fs.file-max=655350" >> /etc/sysctl.conf
```

### 3、设置开机启动

```bash
systemctl enable memcached.service
systemctl enable nginx.service
systemctl enable php-fpm.service
```