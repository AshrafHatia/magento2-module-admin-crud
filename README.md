# magento2-module-admin-crud

⚓ a Magento 2 module of admin crud.

>Module for Magento Crud at admin side with Grid

🔥 ***Features*** 🔥

✔️ : **Data Item Grid**

✔️ : **Image Upload**

✔️ : **Store view filter**

✔️ : **custom URL key for data item**

✔️ : **set image size from backend**

✔️ : **List item pagination/pager**

✔️ : **Frontend whole content is dynamic.**



![Alt text](ss/img1.png?raw=true "preview")

![Alt text](ss/img2.png?raw=true "preview")

![Alt text](ss/img3.png?raw=true "preview")

![Alt text](ss/img4.png?raw=true "preview")

## 🤖 Installation


> ***The extension must be installed via composer.*** 

> **To proceed, run these commands in your terminal:**

```bash
composer require ashrafhatia/magento-module-admin-crud
php bin/magento module:enable Ashraf_Crud
php bin/magento setup:upgrade
php bin/magento setup:di:compile
php bin/magento setup:static-content:deploy
php bin/magento indexer:reindex
php bin/magento cache:clean
php bin/magento cache:flush
```

## 📦 Usage

```python

Frontend : 

list of Data Items : 

Magento_Root_Directory/mg24/magecrud

or

www.domain.com//mg24/magecrud

Backend :

go to magento admin dashboard
Grid open : -> Marketing Tab ->  Ashraf > Crud Data

Module Configuration open : -> Marketing Tab > Ashraf > Configuration 
```
## ☎ Contact Us

[📧 Mail](mailto:ashraf.magento@gmail.com ) : ashraf.magento@gmail.com 

[https://ashrafhatia.github.io/](https://ashrafhatia.github.io)


## 🔗 Contributing
Pull requests are welcome. For major changes, please open an issue first to discuss what you would like to change.

Please make sure to update tests as appropriate.

## 📜 License
[MIT](https://github.com/AshrafHatia/magento2-module-admin-crud/blob/master/LICENSE.txt)