<p align="center">
  <img src="https://www.attendize.com/img/logo-dark.png" alt="Attendize"/>
  <img style='border: 1px solid #444;' src="https://attendize.com/img/screenshots/screen1.PNG" alt="Attendize"/>
</p>

<h1>Attendize</h1>
<p>
Open-source ticket selling and event management platform
</p>

https://www.attendize.com

> PLEASE NOTE: Attendize is in the early stages of development and therefore is likely to contain bugs and unfinished features.

> Please ask any questions/report bugs here: https://github.com/Attendize/Attendize/issues

Demo Event Page: http://attendize.website/e/799/attendize-test-event-w-special-guest-attendize
Demo Back-end Demo: http://attendize.website/signup



*Attendize* is an open-source event ticketing and event management application built using the Laravel PHP framework. Attendize was created to offer event organisers a simple solution to managing general admission events, without paying extortionate service fees.

### Current Features (v1.X.X)
---
 - Beautiful mobile friendly event pages
 - Easy attendee management - Refunds, Messaging etc.
 - Data export - attendees list to XLS, CSV etc.
 - Generate print friendly attendee list
 - Ability to manage unlimited organisers / events
 - Manage multiple organisers 
 - Real-time event statistics
 - Customizable event pages
 - Multiple currency support
 - Quick and easy checkout process
 - Customizable tickets - with QR codes, organiser logos etc.
 - Fully brandable - Have your own logos on tickets etc.
 - Affiliate tracking
    - track sales volume / number of visits generated etc.
 - Widget support - embed ticket selling widget into existing websites / WordPress blogs
 - Social sharing 
 - Support multiple payment gateways - Stripe, PayPal & Coinbase so far, with more being added
 - Support for offline payments
 - Refund payments - partial refund & full refunds
 - Ability to add service charge to tickets
 - Messaging - eg. Email all attendees with X ticket
 - Public event listings page for organisers
 - Ability to ask custom questions during checkout
 - Browser based QR code scanner for door management
    
### Roadmap
---
 - Theme support
 - Plugin Support
 - Localisation 
 - Increased test coverage
 - Laravel 5.4
 - IOS/Android check-in / door management apps
 - Coupon/discount code support
 - Support for more payment providers
 - WordPress Plug-in 

### Contribution
---
Feel free to fork and contribute. If you are unsure about adding a feature create a Github issue to ask for Feedback. 

### Installation
---
To get developing straight away use the pre-configured Docker environment and follow the steps below.
Docker needs to be installed on your machine for this to work. Follow the Docker installation steps for your environment here https://docs.docker.com/install

### Docker dev environment installation steps
---

1. Clone the codebase from Github 

```git clone https://github.com/Attendize/Attendize```

2. Change directory to the cloned codebase

```cd Attendize```

3. Make a copy of the laravel environment file. It can be useful to set APP_DEBUG=true to help you debug any issues you might have

```cp .env.example .env```

4. Set permissions correctly on storage and public/user_content folders

```chmod -R a+w storage```
```chmod -R a+w public/user_content```

5. Run the docker-compose build command 

```docker-compose build```

6. Run composer to pull in the various dependencies for the project

```docker run --rm -it -v $(pwd):/usr/share/nginx/html/attendize attendize_composer composer install```

7. Run the Laravel generate a key for the app

```docker run --rm -it -v $(pwd):/usr/share/nginx/html/attendize attendize_php php artisan key:generate```

8. Run docker-compose up to create the development environment. You can drop the -d flag to see output from the containers which is useful for debugging. 

```docker-compose up -d```

At this point you should be able to browse to 

```http://localhost:8080```.
 
You can follow the web instructions to continue installing Attendize. If you are comfortableon the command line you can run Step 9 below. 

9. Run the command to create the various database tables

```  
docker-compose run php php artisan attendize:install
```

Attendize should now be available at `http://localhost:8080` and maildev at `http://localhost:1080`


### Manual Installation
---
Attendize should run on most pre-configured LAMP or LEMP environments as long as certain requirements are adhered to. 

#### Requirements

##### PHP Version and Extension
PHP >= 5.5.9
OpenSSL PHP Extension
PDO PHP Extension
Mbstring PHP Extension
Tokenizer PHP Extension
Fileinfo PHP Extension
GD PHP Extension

##### MySQL
MySQL version 5.6 and 5.7 have been tested

##### Apache and Nginx
Most versions should work. Check the troubleshooting guide below for correct Nginx and Apache configurations. 

### Troubleshooting

#### If you have an old version of Attendize installed you can destroy your old environments using the commands below. Please take note that if you have a pre-existing MySQL 

#### Most problems can be fixed my making sure the following files and folders are writable:

Storage/app/
Storage/framework/
Storage/logs/
Storage/cache/
public/user_content/
bootstrap/cache/
.env
Always check the log in Storage/logs as it will likely show you what the problem is.

#### Trouble generating PDF tickets? / Checkout failing

Attendize uses Wkhtml2PDF to generate tickets. If you are getting errors while generating PDFs make sure all the driver files in vendor\nitmedia\wkhtml2pdf\src\Nitmedia\Wkhtml2pdf\lib executable.

Also make sure the setting for WKHTML2PDF_BIN_FILE is correct in the .env file. The acceptable options are:

wkhtmltopdf-0.12.1-OS-X.i386 - Mac OS X 10.8+ (Carbon), 
32-bitwkhtmltopdf-amd64 - Linux (Debian Wheezy), 
64-bit, for recent distributions (i.e. glibc 2.13 or later)
wkhtmltopdf-i386 - Linux (Debian Wheezy), 32-bit, for recent distributions (i.e. glibc 2.13 or later)

#### TokenMismatchException error
This error can occur when the session expires, try refreshing the page.

#### Installer not showing up?
Try navigating to your-site.com/public/. If that works and your-site.com/ doesn't, it means your server configuration needs to be updated.

##### Apache
Make sure the mod_rewrite module is enabled and the .htaccess file is being recognised.

##### Nginx
On Nginx, use the following directive in your site configuration:
location / {
  try_files $uri $uri/ /index.php?$query_string;
}

##### Seeing 'Maximum function nesting level of '100' reached' error?
This appears to occur when xdebug is enabled. 

Adding:
xdebug.max_nesting_level = 200
to php.ini and restarting apache should solve the issue.


License
---

Attendize is open-sourced software licensed under the Attribution Assurance License. See [https://www.attendize.com/licence.php](https://www.attendize.com/licence.php) for further details. We also have white-label licence options available.

Contributors 
---

* Brett B ([Github](https://github.com/bretto36))
* G0dLik3 ([Github](https://github.com/G0dLik3))
* Honoré Hounwanou ([Github](http://github.com/mercuryseries)) <mercuryseries@gmail.com>
* James Campbell ([Github](https://github.com/jncampbell))
* JapSeyz ([Github](https://github.com/JapSeyz))
* Mark Walet ([Github](https://github.com/markwalet))
