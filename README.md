**To use PHP 7 for project**

`
<IfModule mime_module>
  AddHandler application/x-httpd-ea-php73 .php .php7 .phtml
</IfModule>
`

**To use php7 in cli**

`/opt/cpanel/ea-php73/root/usr/bin/php`


to set php7 global 


> mkdir bin
> 

> ln -s /usr/local/bin/ea-php73 bin/php
> 

> vim .bashrc

#Put the following code on bottom
export PATH="/home/[usuario]/bin:$PATH"


**SSH Godigitalshop server
`ssh godigitalshop@godigitalshop.com`
