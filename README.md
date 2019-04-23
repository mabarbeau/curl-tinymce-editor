# curl-tinymce-editor

PHP | Composer | MVC | Javascript | TinyMCE

This appliaction is uses php cURL to scrape a website and load it into a TinyMCE editor.
 
## Setup Instructions

## 1. Install Apache 

## 2. Clone the repo
Needs to be deployed to web root. 
`git clone https://github.com/mabarbeau/curl-tinymce-editor.git && cd curl-tinymce-editor` 

## 3. Install Composer
`php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
php -r "if (hash_file('sha384', 'composer-setup.php') === '48e3236262b34d30969dca3c37281b3b4bbe3221bda826ac6a9a62d6444cdb0dcd0615698a5cbe587c3f0fe57a54d8f5') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
php composer-setup.php
php -r "unlink('composer-setup.php');"`

## 4. Install application dependencies with Composer
`php composer.phar install`
