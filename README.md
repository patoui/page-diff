# 🖼️ Page differences 

This is an example of how to leverage Laravel Dusk to generate screenshots, set a baseline, and perform visual regression testing.

## 🚀 Usage

1. Clone the repository
2. Run `composer install`
3. Run `php artisan dusk:install`
4. Run `php artisan serve`
5. Run `php artisan dusk`
6. Run `php artisan dusk:baseline`, this will copy the current screenshots to the baseline directory
7. Run `php artisan dusk:difference 1`, this will compare the current screenshots with the baseline. 1 on the end is the threshold, if the difference is greater than 1%, the test will fail.

There should be no failures. Next, make changes to `welcome.blade.php`, `about.blade.php`, or `other.blade.php`.

* Run `php artisan dusk`
* Run `php artisan dusk:difference 1`

The above should have output the percentage difference in changes on the page and screenshots of the difference, they can be found in `tests/Browser/differences`.
