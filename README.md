# Project Name

Brief project description goes here.

## Usage

- Regular installation with php artisan migrate and db:seed

For Windows (using XAMPP):

1. Open your php.ini file, usually located in the xampp\php\ folder.
2. Find the line ;extension=gd or ;extension=gd2 and remove the semicolon ; at the beginning of the line.
3. Save the file and restart your Apache server using the XAMPP control panel.
4. After installing and enabling the GD extension, the image conversions should work as expected.

For Ubuntu and other OS:

1. Run the following command in your terminal: **sudo apt-get update sudo apt-get install php-gd**.
2. This will install the GD extension and make it available for use in your application.