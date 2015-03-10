cnBeta1.com
---

a clean and modern cnBeta

# 安装
本项目基于这个项目 [https://github.com/andrewelkins/Laravel-4-Bootstrap-Starter-Site](https://github.com/andrewelkins/Laravel-4-Bootstrap-Starter-Site)， 请参考上面的安装方法。


---
以下是开发时的笔记，当时试图兼容SAE所以考虑了很多memcache支持。后来发现兼容SAE太麻烦实在没必要，所以推荐使用redis就好，无视代码中Memcache的部分。

# PHP Module Required:

* php-mcrypt (required by laravel)
* php-memcache (if using MemcacheCacher, optional)
* php-tidy (used when clean fetched html content, optional)


# Other Dependency:
Redis or Memcache


## Naming Convention

### Methods:
* sync(): fetch and save
* loadData(): load data to public instance variable
* getData(): return data

### Constants:
* _KEY: key for caching
