## Telegram Health Tracker Bot

HealthTrackerBot, a Telegram bot, streamlines health monitoring with features like user registration, daily health logs,
and custom reminders. Users easily input data and receive weekly summaries, promoting a hassle-free approach to
maintaining a healthy lifestyle. The bot's interactive design, featuring buttons and inline queries, ensures a
user-friendly experience for efficient and personalized health tracking.

## Installation

This document assumes that you are already familiar with the installation of laravel application.
If you are new to laravel feel free to follow
this [tutorial](https://devmarketer.io/learn/setup-laravel-project-cloned-github-com/)
or any other installation videos/tutorials from the internet.

#### Telegram bot setup

Update the following environment variables in your `.env` file:

- `TELEGRAM_BOT_TOKEN`: Your telegram bot token
- `TELEGRAM_BOT_USERNAME`: Your telegram bot username
- `TELEGRAM_ADMINS`: (optional) Your telegram admin ids separated by comma.

## Local development

This application utilizes telegram webhook to receive updates. So we need to set up telegram to send its updates to our
local development server.

We are going to use `ngrok` to set up webhook to point to our local server.

- Run `php artisan serve`: Runs local laravel development server on port 8000 by default.
- Run `ngrok http 8000`: Creates https url that points to our local server.
- Copy https url from `ngrok`.
- Run `php artisan command:config-telegram-webhook`: Command for viewing, adding and removing telegram webhook.
- Select `Register webhook` and paste the https url from `ngrok`.

Now our local server is ready for receiving webhook updates directly from telegram.

## Registering telegram commands

In order to view, register and remove commands of telegram bot,
use the command `php artisan command:config-telegram-commands` and choose respective options.

## Logging

All the telegram generated logs are found on the route `/log-viewer`. This is publicly accessible by default. Make sure
to limit its access when running in production. Feel free to set up log channels and log levels
confuguration on the `.env` file.

## Testing

Create a separate database called `telegram` which is accessible with the same credentials as the main database.

Then run `php artisan test` to run the available tests, as well as your own tests. Detailed configuration can be updated
on file `phpunit.xml`.

## Deployment

This project can be hosted on any standard apache, nginx, php-fpm enabled servers.

Platforms dedicated to hosting laravel applications include Laravel Forge, Cpanel and others.

For serverless deployment on AWS lambda, Laravel Vapor or Bref can be used.

Configure `cronjob` entry for laravel inorder to receive reminders.

## Libraries

- `arcanedev/log-viewer` for displaying logs in web view.
- `longman/telegram-bot` for handling telegram api.


