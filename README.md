# Test SITE:
- [Local Client](http://localhost/)    |    [Local Server](http://localhost:81/)
- [Online Client](http://45.77.38.76)    |    [Online Server](http://45.77.38.76:81)

# Word with source code, database
## 1. Software and Clone
- [Download all](https://drive.google.com/uc?id=1bpVEBTk80tPh-MaTYIWyhUzr9wu1jRAD&export=download)  |   [Photoshop CC 2015 64bit](https://drive.google.com/uc?id=1d0b1FFqzVlqmArztTldSASrrSJ9PYoP1&export=download)
- Clone use **GitClone.bat** [on folder software]
- [Download Unity 2019.4.0f1 + Android](https://drive.google.com/uc?id=17qdiyAAFQ39CQrQrwJl_xltP8rGUdA30&export=download)

## Command
1. Commit and Push (Window | CMD bat)
```bat
C:\xampp\htdocs\GitPush
```
2. Backup code, database
```bat
C:\xampp\htdocs\GitBackup
```
3. Sync VPS
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

# Sound page
- [Words sound](https://dictionary.cambridge.org/)
- [Nice sound more - text to sound](https://ttsmp3.com/)
- [Nice sound - text to voice](http://fromtexttospeech.com/)
