Make sure PHP 8 is installed on your computer, change directory into the project folder and execute
```bash
composer install
```
Then run the development server for the API using
```bash
php artisan serve
```

Next go into the frontend folder and execute
```bash
npm install
```
Then run the development server for the frontend using
```bash
npm run dev
```
To access API documentation attach /docs/api along with URL used by the Laravel server e.g.
```bash
http://127.0.0.1:8001/docs/api
```