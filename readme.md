Se você usa o xampp, configure o httpd.conf
Alias /api  "/Applications/XAMPP/xamppfiles/htdocs/ebook/backend/"
<Directory "/Applications/XAMPP/xamppfiles/htdocs/ebook/backend/">
    #Options Indexes FollowSymLinks
    # XAMPP
    #Options Indexes FollowSymLinks ExecCGI Includes
    AllowOverride All
    Options Indexes FollowSymLinks MultiViews
    Require all granted
</Directory>
