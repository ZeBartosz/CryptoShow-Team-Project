# CryptoShow-Team-Project
Welcome to the Cryptographic Devices Web Application! This PHP-based application provides a platform for users to explore, review, and discuss various cryptographic devices and technologies. Whether you are a security expert, a student learning about cryptography, or just a technology enthusiast, this application serves as a resource to help you understand and evaluate cryptographic tools.

# Getting Started
These instructions will get you a copy of the project up and running on your local machine for development and testing purposes.

# Prerequisites
What you need to install the software:

- PHP 8.2 or higher
- MariaDB 10.11.5
- Apache 2.0 or higher
- (P3T-Environment)

# Installing 
A step-by-step series of examples that tell you how to get a development environment running:

1. Install servers on local C: drive (Install using .bat file)
2. Make sure provided php.ini file in sql folder is placed into correct directory C:/User/php/
3. Extract the whole project into p3t/public_php/ folder and make sure you have not changed the main directory folder name
4. Make sure you cut and paste contents of includes folder into phpappfolder/includes/ folder in your p3t after installing your P3T Environment
5. Start the servers (Apache, MariaDB);
6. Open MariaDB client 'root', paste all the commands from create_db.sql file going line by line
7. Before you execute the last line in the create_db.sql file make sure you created at least one user to give him admin permissions
8. Point to browser at http://localhost:6789/ or http://127.0.0.1:6789/
9. When done make sure to shutdown MariaDB and Apache servers to prevent file corruption
