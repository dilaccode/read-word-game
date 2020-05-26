# [Test SITE Local](http://localhost/)  |   [Test SITE online](http://52.185.134.172/)
# Sync VPS
```bash
cd /var/www/html; bash gitsync
```
# Software
[download all vscode](https://www.dropbox.com/sh/sqtmrit7bmr8auu/AABm4R-uSwsFZZF2L0ERUahKa?dl=1)
 | [download all netbean](https://drive.google.com/uc?id=1ULRt6LHCkVi_3WMvv9QZ-Ee2TqiMFiHU&export=download)
# HOW CONNECT GITHUB - VSCODE
## setting account
1. open terminal
2. run command:<br>
```bash
git config --global user.email "congtk1992@gmail.com" & git config --global user.name "dilaccode"
```
## clone code, db to XAMPP folder
run command on Terminal (any location):<br>
```bash
cd c:\ & RMDIR "C:\xampp\htdocs" /S /Q & MKDIR C:\xampp\htdocs & cd C:\xampp\htdocs & git clone https://github.com/dilaccode/word-like-game.git . & C:\xampp\mysql\bin\mysql.exe --user=root --password= --host=localhost --port=3306 < "C:\xampp\htdocs\database\word_database.sql"
```
run again if **fail**
# database , backup work
bk database,  commit code, db to git
```bash
C:\xampp\mysql\bin\mysqldump.exe --user=root --password= --host=localhost --port=3306 --result-file="C:\xampp\htdocs\database\word_database.sql" --databases "word" & git add -A & git commit -m "work backup: code, db" & git push
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
