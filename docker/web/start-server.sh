#!/bin/bash
echo alias a=\'php artisan\' >> /etc/bash.bashrc
echo alias queue=\'php artisan queue:work\' >> /etc/bash.bashrc
echo alias u=\'php /var/www/html/upgrade\' >> /etc/bash.bashrc
source /etc/bash.bashrc
service php7.1-fpm start
service ssh start
service supervisor start
supervisorctl reread
supervisorctl update
supervisorctl start agoyu-queue:*
nginx