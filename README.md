<p align="center"><img src="https://github.com/simonhamp/cronikl/blob/main/resources/images/cronikl_github.jpg?raw=true" alt="Cronikl Logo"></p>

# Cronikl

Cronikl is a neat little app that lets you manage cron jobs with a simple UI, running commands on the schedule you define.

It was built as a working demonstration of the [NativePHP framework](https://nativephp.com/) of which I am one of the maintainers.

Cronikl is just a Laravel application that uses the [TALL stack](https://tallstack.dev/) running in the [Electron](https://www.electronjs.org/) variant of NativePHP.

**NB: You need to leave the app open for the scheduler to run your tasks.**

Cronikl currently supports macOS only, but Linux and Windows support is coming.

## Dist

Just want to install Cronikl? A production build will be available soon.

## Dev

### Installation

Clone this repository (or your fork of it) and run `composer install` to install the dependencies.

Then run `cp .env.example .env && php artisan key:generate` to create your `.env` file and generate an application key.

### Booting the dev build

Run `php artisan native:serve` to start the application.

## Learn NativePHP

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
