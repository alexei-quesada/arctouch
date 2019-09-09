# arctouch
arctouch test

Architecture:
* Was used Symfony 4.3 Framwork + MySQL 5.6 database 
* Was used Twig template + Boostrap 4 for the front-end development
* Was used Symfony datafixtures functionality to create the initial data load

Assumptions:
1- Were developed the login/register functionalities and the respective pages/links in order to fulfill the following requirement:
  "Finally, only users with the "Administrator" role should be able to see the full report, and only authenticated users can RSVP to events"
  
2- Was assumed that the user data (name, email) is collected in the moment of registration. In consequence this information is used at the moment of RSVP (getting necessary info from session)

3- Were created 3 different events. Two of them within 20 miles radius from ArchTouch, and other more than 20 miles away.


Build instructions
1- You need to set the MySQL user:password in .env file
2- Open a console in project directory
3- run -> php bin\console doctrine:database:create
4- run -> php bin\console doctrine:schema:update --force
5- run -> php bin\console doctrine:fixtures:load -n

After initial load there will be 3 users in database:
- Administrator  admin@email.com    pass:admin (ROLE_ADMIN)
- Alexei         alexei@email.com   pass:alexei (ROLE_USER)
- Ana            ana@email.com      pass:ana (ROLE_USER)

-The system allows to register new users
