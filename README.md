# [Test SITE Local](http://localhost/)  |   [Test SITE online](http://52.185.134.172/)
# Word with source code, database
## 1. Software and Clone
- [Download all Netbean](https://drive.google.com/uc?id=1qbVaKpnXFbOQiIkqT_51VwRTiK-cEsJe&export=download)
- Clone use **GitClone.bat** [on folder software]
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
