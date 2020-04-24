User Agent Storinator
---------------------

This was a fairly simple one night programming project that I decided to work on for gathering User Agents for some of my other projects.

It's not meant to be fancy, but it works.

## Installation
* Clone this repository.
* Run `composer install`.
* Create a database for this, if you don't have plans to use it in an already present one.
* Import the `schema.sql` file in to the aforementioned database.
* Copy the `.env.local.example` file to `.env.local` and fill it out with the credentials.

This link is for my own testing of local devices, like the Nintendo Switch, that don't have access to a navigation bar present.
* [test](http://192.168.1.44/useragent/public/)
* [test2](http://192.168.1.20/useragent/public/)
