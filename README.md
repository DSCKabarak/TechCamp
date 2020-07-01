*Attendize* is an open-source ticketing and event management application built using the Laravel PHP framework. Attendize allows event organisers to sell tickets to their events and manage attendees without paying service fees to third party ticketing companies.

<p align="center">
  <img src="http://attendize.website/assets/images/logo-dark.png" alt="Attendize"/>
  <img style='border: 1px solid #444;' src="https://www.attendize.com/images/screenshots/screen1.PNG" alt="Attendize"/>
</p>

# Attendize
Open-source ticket selling and event management platform

> Please report bugs here: https://github.com/Attendize/Attendize/issues. Detailed bug reports are more likely to be looked at. Simple creating an issue and saying "it doesn't work" is not useful. Providing some steps to reproduce your problem as well as details about your operating system, PHP version etc can help.

> Take a look http://www.attendize.com/troubleshooting.html and follow the http://www.attendize.com/getting_started.html guide to make sure you have configured attendize correctly.  

Documentation Website: http://www.attendize.com<br />
Demo Event Page: http://attendize.website/e/799/attendize-test-event-w-special-guest-attendize<br />
Demo Back-end Demo: http://attendize.website/signup<br />

## Current Features (v2.X.X)
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
 - Elegant dashboard for easy management.

## Minimum Requirements

Attendize should run on most pre-configured LAMP or LEMP environments as long as certain requirements are adhered to. Attendize is based on the [Laravel Framework](https://laravel.com/)

**PHP Requirements**
1. PHP >= 7.1.3
2. OpenSSL PHP Extension 
3. PDO PHP Extension 
4. Mbstring PHP Extension 
5. Tokenizer PHP Extension 
6. Fileinfo PHP Extension 
7. GD PHP Extension

**MySQL Requirements**
1. MySQL version 5.7 or higher required

## Contributing
Feel free to fork and contribute. If you are unsure about adding a feature, create a Github issue to ask for Feedback. Read the [contribution guidelines](CONTRIBUTING.md)

## Submitting an issue
If you encounter a bug in Attendize, please first search the list of current open [Issues on the GitHub repository](https://github.com/Attendize/Attendize/issues). You may add additional feedback on an existing bug report. If the issue you're having has not yet been reported, please open a new issue. There is a template available for new issues. Please fill out all information requested in the template so we can help you more easily.

Please note: support is not offered from the project maintainers through GitHub. Paid support is available by [purchasing a license](http://www.attendize.com/license.html).

## Installation
To get developing straight away use the [Pre-configured Docker Environment](http://www.attendize.com/getting_started.html#running-attendize-in-docker-for-development)<br />
To do a manual installation use the [Manual Installation Steps](http://www.attendize.com/getting_started.html#manual-installation)

## Testing
To run the application tests, you can run the following from your project root:

```sh
# If the testing db does not exist yet, please create it
touch database/database.sqlite
# Run the test suite
./vendor/bin/phpunit
```

This will run the feature tests that hits the database using the `sqlite` database connection.

## Troubleshooting
If you are having problems please read the [troubleshooting guide](http://www.attendize.com/troubleshooting.html) 

## License
Attendize is open-sourced software licensed under the Attribution Assurance License. See [http://www.attendize.com/license.html](http://www.attendize.com/license.html) for further details. We also have white-label license options available.

## Code of Conduct
The Attendize community operates a [Code of Conduct](CODE_OF_CONDUCT.md) to ensure everyone is able to participate comfortably, equally and safely.