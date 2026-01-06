Short laravel project to showcase the filter issue with the Scramble package.

The tests show that the api behaves as expected. However in the OpenAPI docs, the filter doesn't work.

Run the migration seeder: 
´php artisan migrate:fresh php artisan db:seed´

Start the server with ´php artisan serve´.

Visit ´http://127.0.0.1:8000/docs/api´ to use the documentation interface.

You can also use curl to send requests with or without filters: 

´curl -X GET http://127.0.0.1:8000/api/users´

´curl -X GET http://127.0.0.1:8000/api/users?filter%5Bid%5D%5B_eq%5D=1´ <br>
(weird syntax but brackets have to be encoded like ´([ → %5B, ] → %5D)´, so this request is the same as this one ´curl -X GET "http://127.0.0.1:8000/api/users?filter[id][_eq]=1"´)
