Create file name .htaccess
RewriteEngine On

RewriteBase /payment/
RewriteCond $1 !^(index\.php)
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule ^(.*)$ index.php/$1 [L] 
