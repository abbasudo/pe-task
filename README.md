# pe-task
payever task for magento 2
## installation
download the soruce code and pase it in `app` directory

then run the this commands :
```sh
bin/magento module:enable Test_Task
```
```sh
php bin/magento setup:upgrade
```
```sh
bin/magento cache:flush
```
## usage
in admin panel tho configs of the plugin are located at `stores > configiration > test > task`
