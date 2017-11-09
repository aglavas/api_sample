# Laravel PHP Framework (5.3) Api sample
`Require PHP >= 5.6.4`

## Install project

Navigate to your AMPS system and clone the project

```text

git clone https://github.com/mrgarbage/api_sample.git
```

## Setup project

After cloning it is necessary to install dependencies

```text

cd api_sample

# Install PHP packages
composer install

# Install node modules
npm install

```

Rename .env.example to .env. After that generate app key.

```text
php artisan key:generate
```

Populate .env file with your data. Database, mail and S3 sections must be populated, for api sample to work.
Database section is for connecting to database.
Mail for connecting to mail server and to send emails.
S3 is for connecting to AWS S3 storage, it is used to upload images in this project.

For setting up database:
```text
php artisan migrate
```

For populating database with default values:
```text
php artisan db:seed
```


Now it is needed to make virtual host pointing to public folder of the project.
It is needed mostly for the next step, but it is also a good practice

Create Swagger API documentation index file
```text
# Generate Swagger index file
php artisan swagger:init
```

After this command is run it is needed to enter virtual host domain, so it can set Swagger path.
File index-swagger.yaml is generated in resources/assests/swagger directory. Also swagger.json file in public directory
is generated. This file is main documentation file from which whole console is generated.

This command needs to be run only once, on setting project up.

If you make any changes on swagger documentation files it is necessary to call gulp or gulp watch command, so it can regenerate swagger.json file.

To access Swagger console go to:
```text
localhost/docs/dist
```

For authentication in Swagger console, go to login route and authenticate. Route will return JWT token in token key.
Token needs to be pasted in Authorize tab in upper right corner of console. It should be concatenated with keyword "bearer".
So final format looks like this:

```text
bearer token_value
```

This should be pasted in value under Authorize tab. Doing so swagger will automatically include JWT token in Authorization header
on every request.

### Important notice

Some routes will throw validation error. This is because Swagger currently doesn't support some features like arrays.
Routes itself are tested and correct.
