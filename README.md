# MACHINE 1 PROBLEM - IT107

<div align="center">
  <h3>
    This is a problem to add new users to mysql database with chosen grants. The user can also log in to see the privileges given to him/her.
    </br>
  </br>
    <a href="https://www.youtube.com/watch?v=YZBp2fa34uA">Video Demo</a>
  </h3>
</div>

## Table of contents

- [Overview](#overview)
  - [The challenge](#the-challenge)
- [1. Adding new user](#adding-new-user)
  - [SQL for new database user](#sql-for-new-database-user)
  - [SQL for new global user](#sql-for-new-global-user)
- [2. Login user and show grants](#login-user-and-show-grants)
  - [Login page](#login-page)
  - [User page](#user-page)
  - [SQL commands](#sql-commands-2)
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
- The user can set one or more grants on a specific database or over all databases as a global user. If all grants are selected, the grants will automatically grant ALL PRIVILEGES to the new user made.

[![screencapture-localhost-3000-2021-12-02-04-26-20.png](https://i.postimg.cc/KcgvMJPg/screencapture-localhost-3000-2021-12-02-04-26-20.png)](https://postimg.cc/kDqmrNhn)

### SQL for new database user:
 -This is a code snippet to add new user with database specific privileges from the database-user.php file [here](https://github.com/bibmode/machine-1-backend/blob/main/server/database-user.php)

```
  $query = "CREATE USER :username@:host IDENTIFIED BY :password";

  $stmt = $conn->prepare($query);

  $stmt->bindValue(':username', $username, PDO::PARAM_STR);
  $stmt->bindValue(':password', $password, PDO::PARAM_STR);
  $stmt->bindValue(':host', $host, PDO::PARAM_STR);

  if ($stmt->execute()) {

    $query2 = "GRANT $grants ON $database.* TO $username@$host";

    $stmt2 = $conn->prepare($query2);

    if ($stmt2->execute()) {
      echo json_encode([
        'success' => 1,
        'message' => 'added user to system.'
      ]);
      exit;
    }
 ```
 
 ### SQL for new global user:
 -This is a code snippet to add new user with global privileges from the global-user.php file [here](https://github.com/bibmode/machine-1-backend/blob/main/server/global-user.php)

```
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
[![screencapture-localhost-3000-2021-12-02-04-14-11.png](https://i.postimg.cc/dV6143SM/screencapture-localhost-3000-2021-12-02-04-14-11.png)](https://postimg.cc/xXkndf2g)

 ### user page
[![screencapture-localhost-3000-blackpink-2021-12-02-04-14-52.png](https://i.postimg.cc/ncYchMxs/screencapture-localhost-3000-blackpink-2021-12-02-04-14-52.png)](https://postimg.cc/rKsLhVKc)
 
 ### SQL commands 2:
 -This is a snippet code to get user priviledges on login from the get-grants.php file [here](https://github.com/bibmode/machine-1-backend/blob/main/server/get-grants.php)
 
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
- [MySQL Administration: Managing Users and Privileges](https://www.universalclass.com/articles/computers/mysql-administration-managing-users-and-privileges.htm) - Article about mysql user grants


## Acknowledgments

Thank you to Sir Mark Phil B. Pacot, our IT107 professor, who gave this project as our assignment.
