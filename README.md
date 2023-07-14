<p align="center"><img src="https://raw.githubusercontent.com/simonhamp/cronikl/main/resources/images/cronikl.png" width="400" alt="Cronikl Logo"></p>

# Cronikl

Cronikl is a functional NativePHP application built as a demonstration of the NativePHP framework.

It's a Laravel application that uses the Electron variant of NativePHP.

It's also a neat little app that lets you manage cron jobs with a simple UI, running commands on the schedule you define.

**NB: This app is not a robust cron manager (yet). It's a demonstration of working with NativePHP. You need to leave the
app open for the scheduler to run your tasks.**

Currently works on macOS. Linux and Windows support incoming.

## Installation

Clone the repository and run `composer install` to install the dependencies.

Then run `cp .env.example .env && php artisan key:generate` to create your `.env` file and generate an application key.

## Running the app

Run `php artisan native:serve` to start the application.

## Learning NativePHP

NativePHP is fairly new but already has lots of [documentation](https://nativephp.com/docs)

## Credits

Cronikl was built in a day by [Simon Hamp](https://simonhamp.me/) 😅

The lovely 😍 Cronikl logo was designed by [Dan Matthews](https://danmatthews.me)

## Sponsors

If you would like to sponsor Cronikl's development, please visit my [GitHub Sponsors page](https://github.com/sponsors/simonhamp).

## Contributing

Cronikl is an open-source project and contributions are welcome! Feel free to open an issue or submit a pull request if you have a way to improve the app.

## License

Cronikl is open-source software licensed under the [MIT license](https://opensource.org/licenses/MIT).
