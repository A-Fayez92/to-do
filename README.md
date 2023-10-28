# Simple Todo List Using TALL Stack (Tailwind, Alpine, Laravel, Livewire)
This is a simple to do app built using TALL stack, it's a simple CRUD app that allows you to create, update, delete and mark tasks as completed.

The Dashboard is built using Filament Admin Panel, it allows you to manage users, Todos and Tasks and it's fully customizable.

The App Also provides multiple Mail service provides, you can add your own mail service provider in the and activate it in the Admin Panel.


## Requirements
* Docker
 You can install docker from [HERE](https://docs.docker.com/get-docker/)


## Installation
* #### Clone The Repo 
```
git clone https://github.com/A-Fayez92/to-do.git
```
* #### Navigate to the project directory
```
cd to-do
```
* #### Install Composer Packages
```
docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v $(pwd):/var/www/html \
    -w /var/www/html \
    laravelsail/php81-composer:latest \
    composer install --ignore-platform-reqs
```
* #### Copy .env and set your DB Credentials

    No worries, the app will work with the default credentials, but you can change them if you want.

* #### Run Docker Containers
```
vendor/bin/sail up 
```
* #### Generate AppKey
```
vendor/bin/sail artisan key:generate

```
* #### Migrate And Seed the Database
```
vendor/bin/sail artisan migrate:fresh --seed
```
* #### Install NPM Packages
```
vendor/bin/sail npm install
```
* #### Build Assets
```
vendor/bin/sail npm run dev
```
* #### Don't forget to run the queue
```
vendor/bin/sail artisan queue:listen redis --queue=emails
```
* #### Now You can Access the APP
```
http://localhost
```
* #### You can access the admin dashboard from
```
http://localhost/admin
```
* #### Use the following Credentials to access the app and the admin dashboard
```
Email: test@example.com
Password: password
```
