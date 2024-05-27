<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Display Data</title>
    <style>
        h1 {
            text-align: center;
        }
        .table {
            display: flex;
            justify-content: center;
            align-items: center;
        }
        table {
            width: 80%;
            border-collapse: collapse;
        }
        th, td {
            padding: 8px;
            text-align: center;
            border-bottom: 3px solid #ddd;
            padding: 15px;
        }
        th {
            background-color: #f2f2f2;
        }
        .button-name {
            align-items: center;
            appearance: none;
            background-color: #FCFCFD;
            border-radius: 4px;
            border-width: 0;
            box-sizing: border-box;
            color: #36395A;
            cursor: pointer;
            display: inline-flex;
            font-family: "JetBrains Mono", monospace;
            height: 48px;
            justify-content: center;
            line-height: 1;
            list-style: none;
            overflow: hidden;
            padding-left: 16px;
            padding-right: 16px;
            position: relative;
            text-align: left;
            text-decoration: none;
            transition: box-shadow .15s, transform .15s;
            user-select: none;
            -webkit-user-select: none;
            touch-action: manipulation;
            white-space: nowrap;
            will-change: box-shadow, transform;
            font-size: 18px;
            border: 1px solid black;
        }
        .button-name:hover {
            box-shadow: rgba(45, 35, 66, 0.3) 0 2px 8px, rgba(45, 35, 66, 0.2) 0 7px 13px -3px, #D6D6E7 0 -3px 0 inset;
            transform: translateY(-2px);
        }
        .button-name:active {
            box-shadow: #D6D6E7 0 3px 7px inset;
            transform: translateY(2px);
        }
    </style>
</head>
<body>
    <h1>Registered Users</h1>
    <div class="table">
        <table>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Password</th>
                <th>Course</th>
                <th>Modifying</th>
            </tr>
            <?php
            $db = require("../model/DB.php");
            $config = require('../config.php');
            $databaseConnection = new DatabaseConnection($config);
            $conn = $databaseConnection->getConnection();

            define('ENCRYPTION_KEY', 'e5f6d7e8c9b10f11e5f6d7e8c9b10f11');

            $sql = "SELECT * FROM users";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $decryptedPassword = openssl_decrypt($row["password"], 'AES-128-ECB', ENCRYPTION_KEY);

                    echo "<tr>";
                    echo "<td>" . $row["id"] . "</td>";
                    echo "<td>" . $row["name"] . "</td>";
                    echo "<td>" . $row["email"] . "</td>";
                    echo "<td>" . $decryptedPassword . "</td>";
                    echo "<td>" . $row["course"] . "</td>";
                    echo "<td><a href='../controller/edit_user.php?id=" . $row["id"] . "'><button role='button' class='button-name'>Edit</button></a> <a href='../controller/delete_user.php?id=" . $row["id"] . "'><button role='button' class='button-name'>Delete</button></a></td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='6'>0 results</td></tr>";
            }

            $conn->close();
            ?>
        </table>
    </div>
</body>
</html>
