<?php
function emptyInputRegistration($name, $email, $uid, $pwd, $pwdRepeat) {
  if (empty($name) || empty($email) || empty($uid) || empty($pwd) || empty($pwdRepeat)) {
    return true;
  }
  return false;
}

function invalidUid($uid) {
  $UidRegEx = "/^[a-z0-9]+$/";

  if (preg_match(($UidRegEx), $uid)) {
    return false;
  }
  return true;
}

function uidExists($conn, $uid) {
  $sql = "SELECT * FROM users WHERE usersUid = ?;";

  if (!$stmt = $conn->prepare($sql)) {
    return true;
  }

  $stmt->bind_param("s", $uid);
  $stmt->execute();

  $resultData = $stmt->get_result();

  if ($row = $resultData -> fetch_assoc()) {
    return $row;
  }

  $stmt->close();
}

function invalidEmail($email) {
  $emailRegEx = "/^[a-z0-9!%?_-]+(?:\.[a-z0-9!%?_-]+)*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?$/i";

  if (preg_match($emailRegEx, $email)) {
    return false;
  }
  return true;
}

function emailExists($conn, $email) {
  $sql = "SELECT * FROM users WHERE usersEmail = ?;";

  if (!$stmt = $conn->prepare($sql)) {
    return true;
  }

  $stmt->bind_param("s", $email);
  $stmt->execute();

  $resultData = $stmt->get_result();

  if ($row = $resultData -> fetch_assoc()) {
    return $row;
  }

  $stmt->close();
}

function createUser($conn, $name, $email, $uid, $pwd) {
  $sql = "INSERT INTO users (usersFullName, usersEmail, usersUid, usersPwd) VALUES (?, ?, ?, ?)";

  if (!$stmt = $conn->prepare($sql)) {
    return true;
  }

  $hashedPwd = password_hash($pwd, PASSWORD_DEFAULT);

  $stmt->bind_param("ssss", $name, $email, $uid, $hashedPwd);
  $stmt->execute();
  $stmt->close();

  header("location: ../registration.php?errors=zero");
  exit();
}

function loginUser($conn, $emailORuid, $pwd) {

  $emailExists = emailExists($conn, $emailORuid);
  $uidExists = uidExists($conn, $emailORuid);

  if($emailExists && $loginMatch = matchPassword($emailExists, $pwd)){
    session_start();
    $_SESSION["loggeduid"] = $emailExists["usersUid"];
    $_SESSION["loggedno"] = $emailExists["usersNo"];

    header("location: ../index.php");
    exit();

  }
  else if($uidExists && $loginMatch = matchPassword($uidExists, $pwd)){
    session_start();
    $_SESSION["loggeduid"] = $uidExists["usersUid"];
    $_SESSION["loggedno"] = $uidExists["usersNo"];

    header("location: ../index.php");
    exit();

  }

  else {
    header("location: ../login.php?errors=unmatchedPasswords");
    exit();
  }

}

function matchPassword($emailORuidExists, $pwd){

  $hashedPwd = $emailORuidExists["usersPwd"];

  if (password_verify($pwd, $hashedPwd) === false) {
    return FALSE;
  }
  else if (password_verify($pwd, $hashedPwd) === true) {
    return TRUE;
  }
}


function uploadPic($conn, $owner, $isPrivate, $filePath, $title="", $desc="", $tags="") {
  $sql = "INSERT INTO pics (picsOwner, picsPrivate, picsPath, picsTitle, picsDesc, picsTags) VALUES (?, ?, ?, ?, ?, ?)";

  if (!$stmt = $conn->prepare($sql)) {
    return true;
  }

  $stmt->bind_param("sissss", $owner, $isPrivate, $filePath, $title, $desc, $tags);
  $stmt->execute();
  $stmt->close();

  header("location: ../gallery.php?errors=zero");
  exit();
}

function editPic($conn, $picsNo, $isPrivate, $title="", $desc="", $tags="") {
  $sql = "UPDATE pics SET picsPrivate = ?, picsTitle = ?, picsDesc = ?, picsTags = ? WHERE picsNo = $picsNo";

  if (!$stmt = $conn->prepare($sql)) {
    return true;
  }

  $stmt->bind_param("isss", $isPrivate, $title, $desc, $tags);
  $stmt->execute();
  $stmt->close();

  header("location: ../galleryImage.php?errors=zero&picsNo=".$picsNo);
  exit();
}

function deletePic($conn, $picsNo) {

  $sql = "SELECT * FROM pics WHERE picsNo = ?";
  if (!$stmt = $conn->prepare($sql)) {
    return true;
  }

  $stmt->bind_param("s", $picsNo);
  $stmt->execute();
  $result = $stmt -> get_result();
  $stmt->close();

  $row = $result -> fetch_assoc();
  $filePath = $row["picsPath"];
  unlink("../uploads/".$filePath);


  $sql = "UPDATE pics SET picsPath = '', picsTitle = '', picsDesc = '', picsTags = '', picsStatus = 'deleted' WHERE picsNo = $picsNo";
  $conn -> query($sql);

  header("location: ../gallery.php?errors=zero");
  exit();
}

function addComment($conn, $picsNo, $currentUserUid, $commentText) {
  $sql = "INSERT INTO comments (commentsPicsNo, commentsAuthor, commentsText) VALUES (?, ?, ?)";

  if (!$stmt = $conn->prepare($sql)) {
    return true;
  }

  $stmt->bind_param("iss", $picsNo, $currentUserUid, $commentText);
  $stmt->execute();
  $stmt->close();

  header("location: ../galleryImage.php?errors=zero&picsNo=".$picsNo);
  exit();
}