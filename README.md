<a href="https://github.com/LiamPhillips139/effecttask"> <h1 align="center">Effect Backend Task</h1></a>

## About 

Tech stack (Tailwindcss, Vue, Laravel, Inertia)

The purpose of this project was to provide simple functionality for reading pdf documents using aws textract through the aws-php-sdk. Upon document upload, validation is performed to check the file is of the right type (pdf) and then triggers the textract client to process the file and store the relevant data in the sql database. 

This project used inertiajs and laravel to serve a vue component to the frontend the '/'' endpoint triggers a page controller which uses Inertia to render the vue page. The '/documents/upload' endpoint is used for document upload logic. 

## Installation 

1. Clone this repo
    ```sh
    git clone https://github.com/LiamPhillips139/effecttask.git
    ```

2. Go to the project root directory
    ```sh
    cd solution
    ```

3. Copy .env.example file to .env file
    ```sh
    cp .env.example .env
    ```

4. Rename DB_DATABASE in .env file to the desired name of your database
    ```sh
    DB_DATABASE=effecttask
    ```

5. Update aws credentials in .env file (iam user must have textract permission)
    ```sh
    AWS_ACCESS_KEY_ID=access_key
    AWS_SECRET_ACCESS_KEY=secret_key
    ```

6. Install PHP dependencies
    ```sh
    composer install
    ```

7. Generate application key
    ```sh
    php artisan key:generate
    ```

8. Install front-end dependencies
    ```sh
    npm install && npm run build
    ```

9. Run database migrations 
    ```sh
    php artisan migrate
    ```

10. Run server
    ```sh 
    php artisan serve
    ```

11. Visit localhost:8000 in your browser

12. Choose a pdf by clicking the input field and upload

13. View database documents table from terminal or GUI (tableplus, Sequel pro, etc...)

## Testing

1. To test the application run command below

    ```sh
    php artisan test
    ```

