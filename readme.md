# Real Broker Connection

### Requirements
* PHP 7.1
* Postgres >= 9.5 with PGCrypto and Postgis 
* NGINX
* Composer
* Node

**Required Services**

* Facebook: [https://developers.facebook.com](https://developers.facebook.com) is used to enable social logins via Socialite
* Pusher: [https://pusher.com/](https://pusher.com/) is used for real time messaging between customers
* Braintree: [https://www.braintreepayments.com/](https://www.braintreepayments.com/) is used for payment processing and subscriptions
* Google Maps API: [https://developers.google.com/maps/](https://developers.google.com/maps/) is used for geocoding and mapping
* Mailtrap: **DEVELOPMENT ONLY** [https://mailtrap.io/](https://mailtrap.io/) used for testing email in development only
* Mailgun: **PRODUCTION ONLY** [https://www.mailgun.com/](https://www.mailgun.com/) used for sending email in production only
* ngrok: **DEVELOPMENT ONLY** [https://ngrok.com/](https://ngrok.com/) used for testing braintree webhooks to work in local development

### Included Libraries

**Production**

* Laravel 5.4: [https://laravel.com/docs/5.4](https://laravel.com/docs/5.4)
* Socialite: [https://github.com/laravel/socialite](https://github.com/laravel/socialite)
* Cashier: [https://laravel.com/docs/5.4/billing](https://laravel.com/docs/5.4/billing)
* Pusher PHP Server: [https://github.com/pusher/pusher-http-php](https://github.com/pusher/pusher-http-php)
* Bouncer: [https://github.com/JosephSilber/bouncer](https://github.com/JosephSilber/bouncer)
* Fractal: [https://github.com/spatie/laravel-fractal](https://github.com/spatie/laravel-fractal)
* JWT-Auth: [https://github.com/tymondesigns/jwt-auth](https://github.com/tymondesigns/jwt-auth)

**Development**

* Debugbar: [https://github.com/barryvdh/laravel-debugbar](https://github.com/barryvdh/laravel-debugbar)
* IDE Helper: [https://github.com/barryvdh/laravel-ide-helper](https://github.com/barryvdh/laravel-ide-helper)
* Clockwork: [https://github.com/itsgoingd/clockwork](https://github.com/itsgoingd/clockwork)
* Clockwork CLI: [https://github.com/ptrofimov/clockwork-cli](https://github.com/ptrofimov/clockwork-cli)


## Environment Setup
### Shared Setup
1. Signup for a [Braintree sandbox account](https://www.braintreepayments.com/sandbox)
    - Create 2 plans (Note: The value in the Plan ID field is what will be displayed on the invoice.)
        - Monthly - 59.00/mo 
        - Yearly - 590.00/mo 
    - Create an add-on called `plan-credit` with an amount of `1` (Cashier Requirement)
    - Create a custom field in Settings > Processing > Custom Fields 
        Name: `Description`, API Name: `description`, Options: `Store and Pass Back` (Cashier requirement)
1. Get a [Google Maps API key](https://developers.google.com/maps/documentation/javascript/get-api-key)
1. Create a Facebook Login app for web in the [Facebook Developer Portal](https://developers.facebook.com) 
1. Create a [Pusher Account](https://pusher.com/)
1. Jump to: 
    - [Development Setup](#markdown-header-development-setup)
    - [Production Setup](#markdown-header-production-setup)
1. Ensure that Postgres has the crypto and postgis extensions install
```bash
create extension pgcrypto;
create extension postgis;
```

### Development Setup

1. Create a [Mailtrap account](https://mailtrap.io/)
1. create an entry in your `/etc/hosts` file for `127.0.0.1    app.dev www.app.dev`
1. Copy `.env.example` to `.env` and use it as a guide to fill in the required information for each service that you created
    an account for.
1. Install [Docker](https://www.docker.com/docker-mac)
1. Clone [https://bitbucket.org/radixbay/realbroker-stack/src/408b5d5f3648?at=master](https://bitbucket.org/radixbay/realbroker-stack/src/408b5d5f3648?at=master)
1. Inside the folder for the phase 2 project:
    - Create a folder called `code`
    - Clone the phase 2 project into that code directory [https://bitbucket.org/radixbay/realbroker-phase-2](https://bitbucket.org/radixbay/realbroker-phase-2)
        `git clone git clone git@bitbucket.org:radixbay/realbroker-phase-2.git ./code`
    - Install all project dependencies for the phase 2 project by running the following inside the code directory
        `npm install` and `composer install`
    - Migrate and seed the database:
        `php artisan migrate` and `php artisan db:seed`
1. Inside the docker-stack folder
    - Run `docker-compose up`
1. The app will be reachable at `http://app.dev`
1. Connect to postgres at localhost:5432 User: postgres, Pass: postgres
1. Enable ngrok tunneling if you want to test Braintree callbacks
    - `ngrok tls app.dev:443` 
    - Paste the generated url into the braintree sandbox webook config

### Production Setup

1. Signup for a [Braintree sandbox account](https://www.braintreepayments.com/sandbox)
1. Get a [Google Maps API key](https://developers.google.com/maps/documentation/javascript/get-api-key)
1. Create a Facebook Login app for web in the [Facebook Developer Portal](https://developers.facebook.com) 
1. Create a [Pusher Account](https://pusher.com/)
1. Create a [Mailgun Account](https://www.mailgun.com/)
1. Install postgres with pgcrypto and postgis extensions
1. Clone this project into the web root
1. Install composer dependencies
1. Configure .env file to connect to the above services
1. Run the migrations
    - `php artisan migrate`
1. Seed the database with roles and braintree plans
    - Bouncer: `php artisan bouncer:seed`
    - Braintree: `php artisan braintree:sync-plans`
1. Create Admin user `php artisan admin:create`
1. Setup service cron to run the artisan command on a regular schedule
    - `* * * * * php /path-to-your-project/artisan schedule:run >> /dev/null 2>&1`
