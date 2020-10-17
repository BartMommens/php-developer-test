# PHP developer test
## Instructions
Using NASA’s “Astronomy Picture of the Day” API, build a webpage that lists the picture of the day for the last 30 days.

### How to get this thing up and running:   
1.  Download this project (duh)
2.  composer install
3.  .env file will be missing : copy .env.example as .env
4.  Enter all your mysql data in the .env file 
5.  create the database in you mysql host
6.  php artisan key:generate (Generate new project key)
7.  php artisan migrate (sets up the database)
8.  php artisan pictures:fill (collects pictures from nasa's apod service and fills database wait for completion)
9.  php artisan pictures:getpod (this is optional it will get the latest APOD) 
10. php artisan schedule:work

### Step 10 :
This starts a cronjob that checks the APOD service every hour to get the latest APOD picture. 
Due to the fact that we don't know at what exact time the new APOD is published the server will get it automatically.
Also saves a buttload of requests x__X
