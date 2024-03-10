<?php
session_start();

if (!isset($_SESSION['loggedin']) || !$_SESSION['loggedin']) {
    header("Location: feedbacks.php");
    exit;
}

include "database.php";

// Process feedback submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $feedback = $_POST['feedback'];
    $user_id = $_SESSION['user_id']; // Assuming user_id is stored in the session

    $stmt = $conn->prepare("INSERT INTO feedbacks (feedback, user_id, created_at) VALUES (?, ?, NOW())");
    $stmt->bind_param("si", $feedback, $user_id);
    $stmt->execute();
    $stmt->close();

    // Redirect to prevent form resubmission
    header("Location: feedbacks.php");
    exit;
}

// Retrieve existing feedbacks
$stmt = $conn->prepare("SELECT feedbacks.feedback, feedbacks.created_at, user.first_name, user.last_name FROM feedbacks JOIN user ON feedbacks.user_id = user.id ORDER BY feedbacks.created_at DESC");
$stmt->execute();
$result = $stmt->get_result();
$feedbacks = $result->fetch_all(MYSQLI_ASSOC);
$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feedback Page</title>
    <link rel="stylesheet" href="style.css">

</head>

<body>

    <!-- header -->
    <header>
        <h2 class="logo"> <i> Jenny </i> </h2>
        <nav class="navigation">
            <a href="index.php"> Home </a>
            <a href="about.html"> About </a>
            <a href="gallery.html"> Gallery </a>
            <a href="contact.html"> Contact </a>
            <a href="feedbacks.php"> Feedback </a>

            <a href="logout.php" class="btn btn-warning">Logout</a>
        </nav>
    </header>
    <section>

        <div class="transparent-box">
            <h2>Feedback Form</h2>
            <form action="feedbacks.php" method="post">
                <div class="form-group">
                    <label for="feedback">Feedback</label>
                    <textarea class="form-control" id="feedback" name="feedback" rows="3" placeholder="Enter Feedback" required></textarea>
                </div>
                <button type="submit" class="btn-primary">Submit Feedback</button>
            </form>
        </div>

        <div class="feedbacks-container">
            <div class="transparent-box ">
                <h2>Feedbacks</h2>
                <ul class="list-group">
                    <?php foreach ($feedbacks as $feedback): ?>
                        <li>
                            <p><strong><?php echo htmlspecialchars($feedback['first_name']) . ' ' . htmlspecialchars($feedback['last_name']); ?></strong></p>
                            <p><?php echo htmlspecialchars($feedback['feedback']); ?></p>
                            <small>Posted on <?php echo date('F j, Y, g:i a', strtotime($feedback['created_at'])); ?></small>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>

    </section>

    <footer>
        <p>© 2024 Jenny. All rights reserved.</p>
    </footer>

</body>

</html>
