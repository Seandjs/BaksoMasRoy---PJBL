<?php 
$conn = mysqli_connect("localhost", "root", "", "baksomasroyy");

if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

function registrasi($data) {
    global $conn;

    $username = strtolower(stripslashes($data["username"]));
    $email = strtolower(stripslashes($data["email"]));
    $password = mysqli_real_escape_string($conn, $data["password"]);
    $password2 = mysqli_real_escape_string($conn, $data["password2"]);

    //ini cek usn/email alr dipakai or not
    $result = mysqli_query($conn, "SELECT * FROM user WHERE username = '$username' OR email ='$email'");
    if(mysqli_fetch_assoc($result)) {
        echo "<script>
               alert('username atau email sudah terdaftar!')
               </script";
        return false;
    }

    //cek konfrm pw
    if ($password !== $password2) { 
        echo "<script>
                 alert('Konfirmasi password tidak sesuai!');
              </script>";
        return false;
    }

    //enkripsi pw
    $password = password_hash($password, PASSWORD_DEFAULT);

    //ini masukin ke db
    mysqli_query($conn,"INSERT INTO user VALUES ('', '$username', '$email', '$password')");

    return mysqli_affected_rows($conn);
}
