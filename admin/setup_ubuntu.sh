echo "Installing PHP extensions..."
sudo apt-get update
sudo apt-get install -y php-fileinfo php-gd php-curl php-zip php-xml
PROJECT_ROOT="/var/www/html"
WEB_USER="www-data"
echo "Setting ownership to $WEB_USER for $PROJECT_ROOT..."
sudo chown -R $WEB_USER:$WEB_USER $PROJECT_ROOT
echo "Setting directory permissions to 775..."
find $PROJECT_ROOT -type d -exec sudo chmod 775 {} \;
echo "Setting file permissions to 664..."
find $PROJECT_ROOT -type f -exec sudo chmod 664 {} \
echo "Ensuring assets/img is writable..."
sudo chmod -R 775 $PROJECT_ROOT/assets/img
echo "----------------------------------------------------"
echo "REMINDER: Update your php.ini file:"
echo "Location: /etc/php/[version]/fpm/php.ini (for Nginx) or /etc/php/[version]/apache2/php.ini (for Apache)"
echo ""
echo "Suggested settings:"
echo "upload_max_filesize = 64M"
echo "post_max_size = 64M"
echo "memory_limit = 256M"
echo "max_execution_time = 300"
echo "----------------------------------------------------"
echo "If using Nginx, update your server block config:"
echo "client_max_body_size 64M;"
echo "----------------------------------------------------"

echo "Setup complete! Please restart your web server (e.g., sudo systemctl restart apache2 or nginx)."
