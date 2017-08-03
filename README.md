AMS:

Softwares you need :

Install git tools from https://git-scm.com/download/win

Install nodejs and npm from https://nodejs.org/en/

Download Source Code:

Command Line Way : git clone https://github.com/aihtshamali/AMS

Other Way : donwload the zip of source code and unzip by clicking on clone here https://github.com/aihtshamali/AMS

open command line (cmd) , navigate to project directory and run

composer install

(composer must be installed and path must be set)

(optional)->the in the same directory run npm install (nodejs and npm must be set and path must be set)

create a copy of .env.example and paste it as .env (both should be in project root)

now run this command from project directory

php artisan key:generate (this will generate application key)

open .env and around line 9 - 15 update database credentails. You must create an empty database from phpmyadmin before this step.


BOOOOOOOOOOOOOOOOOOOM you did it. Please let me know if you have issue.
