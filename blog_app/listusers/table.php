
<!DOCTYPE html>
<html>
<head>
  <title>List Users</title>
  <style>
    table {
      border-collapse: collapse;
      width: 100%;
    }
    
    th, td {
      padding: 8px;
      text-align: left;
      border-bottom: 1px solid #ddd;
    }
  </style>
</head>
<body>
  <h1>List Users</h1>
  <table>
    <tr>
      <th>No</th>
      <th>First Name</th>
      <th>Last Name</th>
      <th>User Name</th>
      <th>Email</th>
      <th>Role<th>

    </tr>

    <?php 
    include '../config/db_connection.php';

    $UsersQuery =" SELECT * FROM users";
    $UsersResult = mysqli_query($db_connect, $UsersQuery);

    $UserNo = 1;

    if(mysqli_num_rows($UsersResult) > 0){
      while($Users = mysqli_fetch_assoc($UsersResult)){
        $FName = $Users['Fname'];
        $LName = $Users['Lname'];
        $Username = $Users['username'];
        $Email = $Users['email'];
        $Role = $Users['role'];

        echo "<tr>";
        echo "<td>{$UserNo}</td>";
        echo "<td>{$FName}</td>";
        echo "<td>{$LName}</td>";
        echo "<td>{$Username}</td>";
        echo "<td>{$Email}</td>";
        echo "<td>{$Role}</td>";
        $UserNo ++;
      }
    
  }
    ?>
    <tr>
      <!-- <td><?php  ?></td> -->
      <!-- <td><?php  ?></td> -->
      <!-- <td><?php  ?></td> -->
      <!-- <td><?php  ?></td> -->
      <!-- <td><?php  ?></td> -->
    
      
    </tr>

  </table>
</body>
</html>
