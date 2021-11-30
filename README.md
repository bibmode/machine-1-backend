# MACHINE 1 PROBLEM - IT107

<div align="center">
  <h3>
    This is a problem to add new users to mysql database with chosen grants. The user can also log in to see the privileges given to him/her.
  </h3>
</div>

## Table of contents

- [Overview](#overview)
  - [The challenge](#the-challenge)
- [1. Adding new user](#adding-new-user)
  - [SQL commands](#sql-commands-1)
- [2. Login user and show grants](#login-user-and-show-grants)
  - [Login page](#login-page)
  - [User page](#user-page)
  - [SQL commands](#sql-commands-2)
- [User Database](#user-database)
- [My process](#my-process)
  - [Built with](#built-with)
  - [What I learned](#what-i-learned)
  - [Useful resources](#useful-resources)
- [Acknowledgments](#acknowledgments)

**Note: Delete this note and update the table of contents based on what sections you keep.**

## Overview

### The challenge:
- Perform the adding of user/s to SQL database with limited privileges (own choice) via web-based interface.
- Develop a web-based login page for the authentication of users before the system's access.
- Create a webpage that will display the user's assigned privileges every after successful entry to the system.


## Adding new user:

[![screencapture-localhost-3000-2021-11-30-23-01-28.png](https://i.postimg.cc/NjC9stnX/screencapture-localhost-3000-2021-11-30-23-01-28.png)](https://postimg.cc/DSsy69nf)
 
 ### SQL commands 1:
 -This is a snippet from the add-user.php file [here](https://github.com/bibmode/machine-1-backend/blob/main/server/add-user.php)

```
  $username = htmlspecialchars(trim($data->username));
  $password = htmlspecialchars(trim($data->password));
  $host = htmlspecialchars(trim($data->host));
  $grants = htmlspecialchars(trim($data->grants));

  $query = "CREATE USER :username@:host IDENTIFIED BY :password";

  $stmt = $conn->prepare($query);

  $stmt->bindValue(':username', $username, PDO::PARAM_STR);
  $stmt->bindValue(':password', $password, PDO::PARAM_STR);
  $stmt->bindValue(':host', $host, PDO::PARAM_STR);

  if ($stmt->execute()) {

    $query2 = "GRANT $grants ON * . * TO $username@$host";

    $stmt2 = $conn->prepare($query2);

    $stmt2->execute();

    echo json_encode([
      'success' => 1,
      'message' => 'added user to system.'
    ]);
    exit;
  }
 ```


## Login user and show grants:

 ### login page
[![screencapture-localhost-3000-2021-11-30-23-18-16.png](https://i.postimg.cc/Fzgtp9Sn/screencapture-localhost-3000-2021-11-30-23-18-16.png)](https://postimg.cc/Cn16Lpmj)

 ### user page
[![screencapture-localhost-3000-genebeeeb-2021-11-30-23-20-12.png](https://i.postimg.cc/yYV2BCcs/screencapture-localhost-3000-genebeeeb-2021-11-30-23-20-12.png)](https://postimg.cc/NLzd7Vdz)
 
 ### SQL commands 2:
 -This is a snippet from the get-grants.php file [here](https://github.com/bibmode/machine-1-backend/blob/main/server/get-grants.php)
 
```
  $username = htmlspecialchars(trim($data->username));
  $host = htmlspecialchars(trim($data->host));
  $password = htmlspecialchars(trim($data->password));

  $mysqli = new mysqli($host, $username, $password);

  if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: " . $mysqli->connect_error;
    exit();
  }

  $result = $mysqli->query("SHOW GRANTS for $username@$host");

  while ($row = mysqli_fetch_array($result)) {
    echo json_encode($row[0]);
  }
```

## User database:
 - This is the final database with the new user added
[![screencapture-localhost-phpmyadmin-index-php-2021-11-30-23-29-17.jpg](https://i.postimg.cc/HsNx7zpc/screencapture-localhost-phpmyadmin-index-php-2021-11-30-23-29-17.jpg)](https://postimg.cc/bsQ87QSp)

## My process

### Built with

- [PHP](https://www.php.net/) - For connecting the backend to the frontend
- [MySQL](https://www.mysql.com/) - Database service
- [Apache](https://httpd.apache.org/) - For HTTP server
- [React](https://reactjs.org/) - Front frontend javascript library/framework
- [Material UI](https://mui.com/) - CSS components library 
- [Formik](https://formik.org/) - Form handling library
- [Yup](https://github.com/jquense/yup) - Form validation library

### What I learned

In the process of this project, I learned a lot of things. Here are some of them:
- Creating new user in mysql using php
- Getting user grants from mysql database

### Useful resources

- [PHP Cheat Sheet](https://overapi.com/php) - List of all PHP methods.
- [Learning About Electronics](http://www.learningaboutelectronics.com/PHP/) - This is a wonderful resource of PHP tutorials


## Acknowledgments

Thank you to Sir Mark Phil B. Pacot, our IT107 professor, who gave this project as our assignment.
