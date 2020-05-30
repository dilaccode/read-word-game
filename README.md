# [Test SITE Local](http://localhost/)  |   [Test SITE online](http://52.185.134.172/)
# Word with source code, database
## 1. Software and Clone
- [Download all](https://drive.google.com/uc?id=1iRfLp6JRmmy9NRNoEEYwU9v_uedabUuy&export=download)  |   [Photoshop CC 2015 64bit](https://drive.google.com/uc?id=1d0b1FFqzVlqmArztTldSASrrSJ9PYoP1&export=download)
- Clone use **GitClone.bat** [on folder software]
- Set up 2 sites apache
    - add to last file **C:\xampp\apache\conf\extra\httpd-vhosts.conf**
```html
<VirtualHost *:80>
    ServerAdmin webmaster@dummy-host.example.com
    DocumentRoot "C:/xampp/htdocs/CLIENT"
    ServerName localhost:80
#    ServerAlias www.dummy-host.example.com
    ErrorLog "logs/CLIENT-error.log"
    CustomLog "logs/CLIENT-access.log" common
</VirtualHost>

<VirtualHost *:81>
    ServerAdmin webmaster@dummy-host2.example.com
    DocumentRoot "C:/xampp/htdocs/SERVER"
    ServerName localhost:81
#   ServerAlias www.dummy-host.example.com
    ErrorLog "logs/SERVER-error.log"
    CustomLog "logs/SERVER-access.log" common
</VirtualHost>
```
    - add to **C:\xampp\apache\conf\httpd.conf** after **Listen 80**:
```html
Listen 81
```
    - **Restart Apache**

## 2. Commit and Push (Window | CMD bat)
```bat
C:\xampp\htdocs\GitPush
```
## 3. Backup code, database
```bat
C:\xampp\htdocs\GitBackup
```
## 4. Sync VPS
```bash
cd /var/www/html; bash gitsync
```
# Relate project
- [word click on mean](https://github.com/dilaccode/word)
- [Word count idea](https://github.com/quangcongvn/word-count)

# Development Mode
> now setting on App/Config/Constant.php IS_DEVELOPMENT_MODE
CodeIgniter.php line 483... **but slow**
// define('ENVIRONMENT', 'development');

# simple_helper
**store all custom function use for all project**
- path: App/Helper/simple_helper.php
- add to  App/Controller/BaseController.php for **auto load** and **use any controller**
```php
    protected $helpers = ['simple_helper'];
```
