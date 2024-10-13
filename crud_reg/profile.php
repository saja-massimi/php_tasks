<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="./profile.css" rel="stylesheet">
</head>

<body>
    <?php

    require 'db_connection.php';
    session_start();
    $username = $_SESSION['user'];
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['profile_pic'])) {
        $uploadDir = 'uploads/';
        $uploadFile = $uploadDir . basename($_FILES['profile_pic']['name']);
        $imageFileType = strtolower(pathinfo($uploadFile, PATHINFO_EXTENSION));

        $check = getimagesize($_FILES['profile_pic']['tmp_name']);

        if ($check !== false) {
            if ($_FILES['profile_pic']['size'] < 2000000) {
                if (in_array($imageFileType, ['jpg', 'png', 'jpeg', 'gif'])) {
                    if (move_uploaded_file($_FILES['profile_pic']['tmp_name'], $uploadFile)) {
                        $_SESSION['profile_pic'] = $uploadFile;

                        try {
                            $dbConn = getDBConnection();


                            $sql = "UPDATE users SET profilePic = :profilePic WHERE name = :username";
                            $stmt = $dbConn->prepare($sql);
                            $stmt->execute([
                                ':profilePic' => $_SESSION['profile_pic'],
                                ':username' => $username
                            ]);
                        } catch (PDOException $e) {
                            echo "Error: " . $e->getMessage();
                        }

                        header("Location: profile.php");
                        exit;
                    } else {
                        echo "Sorry, there was an error uploading your file.";
                    }
                } else {
                    echo "Only JPG, JPEG, PNG & GIF files are allowed.";
                }
            } else {
                echo "Your file is too large.";
            }
        } else {
            echo "File is not an image.";
        }
    }

    if (isset($_FILES['cv_file'])) {
        $uploadDir = 'uploads/cvs/';
        $uploadFile = $uploadDir . basename($_FILES['cv_file']['name']);
        $fileType = strtolower(pathinfo($uploadFile, PATHINFO_EXTENSION));

        if (in_array($fileType, ['pdf', 'doc', 'docx'])) {
            if ($_FILES['cv_file']['size'] < 5000000) { // Max size 5MB

                if (move_uploaded_file($_FILES['cv_file']['tmp_name'], $uploadFile)) {
                    $_SESSION['cv_file'] = $uploadFile;

                    try {
                        $dbConn = getDBConnection();
                        $userId = $_SESSION['user_id'];

                        // Update the CV file path for the current user
                        $sql = "UPDATE users SET cv = :cvFile WHERE name = :username";
                        $stmt = $dbConn->prepare($sql);
                        $stmt->execute([
                            ':cvFile' => $_SESSION['cv_file'],
                            ':username' => $username

                        ]);
                    } catch (PDOException $e) {
                        echo "Error: " . $e->getMessage();
                    }

                    echo "CV uploaded successfully.";
                    header("Location: profile.php");
                    exit;
                } else {
                    echo "Sorry, there was an error uploading your CV.";
                }
            } else {
                echo "Your CV file is too large.";
            }
        } else {
            echo "Only PDF, DOC, and DOCX files are allowed for CV.";
        }
    }

 

    ?>

    <div class="container mt-5">
        <div class="row">
            <!-- Profile Picture Section -->
            <div class="col-md-3 border-right">
                <div class="d-flex flex-column align-items-center text-center p-3 py-5">
                    <img id="profilePic" class="rounded-circle mt-5" width="150px" src="<?php echo isset($_SESSION['profile_pic']) ? $_SESSION['profile_pic'] : 'https://st3.depositphotos.com/15648834/17930/v/600/depositphotos_179308454-stock-illustration-unknown-person-silhouette-glasses-profile.jpg'; ?>">
                    <span class="font-weight-bold mt-3"><?php echo $_SESSION['user'] ?></span>
                    <span class="text-black-50"><?php echo $_SESSION['user_email'] ?></span>

                    <div class="mt-3">
                        <form id="profilePicForm" method="POST" enctype="multipart/form-data">
                            <label for="uploadProfilePic" class="form-label">Change Profile Picture</label>
                            <input class="form-control" type="file" id="uploadProfilePic" name="profile_pic" accept="image/*" style="display: none;">
                            <button class="btn btn-primary mt-2" type="button" onclick="document.getElementById('uploadProfilePic').click();">Upload New Picture</button>
                            <button class="btn btn-success mt-2" type="submit">Save Picture</button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Profile Settings Section -->
            <div class="col-md-5 border-right">
                <div class="p-3 py-5">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h4 class="text-right">Profile Settings</h4>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-12">
                            <label class="labels">Name</label>
                            <input type="text" class="form-control" placeholder="First name" value="<?php echo $_SESSION['user'] ?>">
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-12">
                            <label class="labels">Email</label>
                            <input type="text" class="form-control" value="<?php echo $_SESSION['user_email'] ?>">
                        </div>
                    </div>
                    <div class="mt-5 text-center">
                        <button class="btn btn-primary profile-button" type="button">Save Profile</button>
                    </div>
                </div>
            </div>

            <!-- CV Upload Section -->
            <div class="col-md-4">
                <div class="p-3 py-5">
                    <div class="col-md-12">
                        <label class="labels">Attach CV</label>
                        <form method="POST" enctype="multipart/form-data">
                            <input class="form-control" type="file" id="formFile" name="cv_file" accept=".pdf, .doc, .docx">
                            <button class="btn btn-success mt-3" type="submit">Upload CV</button>
                        </form>
                    </div>
                </div>
            </div>


        </div>
    </div>

    <script>
        document.getElementById('uploadProfilePic').addEventListener('change', function(event) {
            const [file] = event.target.files;
            if (file) {
                document.getElementById('profilePic').src = URL.createObjectURL(file);
            }
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>