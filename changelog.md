# Changelog

## 1.0.0 - November 17, 2026
The first official release of Backdrop Template Manager for Backdrop 2.0. It lets themes register custom templates on the `backdrop/templates/register` action and lists them in the template drop-down.

* Requires PHP 7.4, `backdrop-dev/framework` ^2.0 and `backdrop-dev/tools` ^1.0, which the package uses but didn't declare.
* The templates collection is now a container singleton, so it can be resolved by other code.
* Added parameter and return types, a strict subtype check, and fixed the repository links.
* Added dependency free tests (`php tests/run.php`) and a GitHub Action that lints and runs them on PHP 7.4 to 8.3.
