<?php
session_start();

if ($_SESSION['role'] == 'guest' || !isset($_SESSION['role'])) {
    header('Location: ../authentication/unauthorized');
    exit();
}

include __DIR__ . '/../include/db.php';
include __DIR__ . '/../include/pagination.php';

$feedback = '';
$announcementData = [];

$recordsPerPage = 10;
$page = isset($_GET["page"]) ? (int) $_GET["page"] : 1;
$offset = ($page - 1) * $recordsPerPage;

// Process form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        $action = $_POST['action'];

        if ($action === 'add') {
            $title = $_POST['title'];
            $message = $_POST['message'];
            $important = isset($_POST['important']) ? 1 : 0;
            $user_id = $_SESSION['user_id'];

            $stmt = $conn->prepare("INSERT INTO announcements (title, message, important, created_by) VALUES (:title, :message, :important, :user_id)");
            $stmt->bindParam(':title', $title, PDO::PARAM_STR);
            $stmt->bindParam(':message', $message, PDO::PARAM_STR);
            $stmt->bindParam(':important', $important, PDO::PARAM_INT);
            $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);

            if ($stmt->execute()) {
                $_SESSION['feedback'] = 'Announcement added successfully!';
            } else {
                $_SESSION['feedback'] = 'Error adding announcement.';
            }
        } elseif ($action === 'edit') {
            $id = $_POST['announcement_id'];
            $title = $_POST['title'];
            $message = $_POST['message'];
            $important = isset($_POST['important']) ? 1 : 0;

            $stmt = $conn->prepare("UPDATE announcements SET title = :title, message = :message, important = :important WHERE announcement_id = :id");
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->bindParam(':title', $title, PDO::PARAM_STR);
            $stmt->bindParam(':message', $message, PDO::PARAM_STR);
            $stmt->bindParam(':important', $important, PDO::PARAM_INT);

            if ($stmt->execute()) {
                $_SESSION['feedback'] = 'Announcement updated successfully!';
            } else {
                $_SESSION['feedback'] = 'Error updating announcement.';
            }
        } elseif ($action === 'delete') {
            $id = $_POST['announcement_id'];

            $stmt = $conn->prepare("DELETE FROM announcements WHERE announcement_id = :id");
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);

            if ($stmt->execute()) {
                $_SESSION['feedback'] = 'Announcement deleted successfully!';
            } else {
                $_SESSION['feedback'] = 'Error deleting announcement.';
            }
        }

        // Redirect after POST to prevent form resubmission
        header('Location: announcements' . (isset($_GET['page']) ? '?page=' . $_GET['page'] : ''));
        exit();
    }
}

// Check for feedback in session
if (isset($_SESSION['feedback'])) {
    $feedback = $_SESSION['feedback'];
    unset($_SESSION['feedback']); // Clear the feedback message
}

// Fetch announcements
$stmt = $conn->prepare("SELECT a.*, u.forename, u.surname 
                       FROM announcements a
                       LEFT JOIN users u ON a.created_by = u.user_id
                       ORDER BY a.created_at DESC 
                       LIMIT :limit OFFSET :offset");
$stmt->bindValue(':limit', $recordsPerPage, PDO::PARAM_INT);
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
$stmt->execute();
$announcementData = $stmt->fetchAll(PDO::FETCH_ASSOC);

$totalRecordsQuery = $conn->query("SELECT COUNT(*) As total FROM announcements");
$totalRecords = $totalRecordsQuery->fetch(PDO::FETCH_ASSOC)['total'];
$totalPages = ceil($totalRecords / $recordsPerPage);

$conn = null;
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Merriweather:ital,opsz,wght@0,18..144,300..900;1,18..144,300..900&display=swap" />
    <link rel="stylesheet" href="../assets/styles.css">
    <script src="../assets/scripts.js"></script>
    <title>Manage Announcements</title>
</head>

<body>
    <?php include "../include/admin_navbar.php"; ?>
    <div class="blur-layer-3"></div>
    <div class="manage-default">
        <h1><a class="title" href="../admin/dashboard">LuckyNest</a></h1>
        <div class="content-container">
            <h1>Manage Announcements</h1>
            <?php if ($feedback): ?>
                <div class="feedback-message" id="feedback_message"><?php echo $feedback; ?></div>
                <script>
                    // Auto-hide feedback message after 5 seconds
                    setTimeout(function () {
                        document.getElementById('feedback_message').style.display = 'none';
                    }, 5000);
                </script>
            <?php endif; ?>

            <div class="button-center">
                <button onclick="LuckyNest.toggleForm('add-form')" class="update-add-button">Add Announcement</button>
            </div>

            <div id="add-form" class="add-form">
                <button type="button" class="close-button" onclick="LuckyNest.toggleForm('add-form')">✕</button>
                <h2>Add New Announcement</h2>
                <form method="POST"
                    action="announcements<?php echo isset($_GET['page']) ? '?page=' . $_GET['page'] : ''; ?>">
                    <input type="hidden" name="action" value="add">
                    <label for="title">Title:</label>
                    <input type="text" id="title" name="title" required>
                    <label for="message">Message:</label>
                    <textarea id="message" name="message" rows="5" required></textarea>
                    <div class="checkbox-container">
                        <input type="checkbox" id="important" name="important">
                        <label for="important">Mark as Important</label>
                    </div>
                    <button type="submit" class="update-button">Add Announcement</button>
                </form>
            </div>

            <h2>Announcement List</h2>
            <table border="1">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Title</th>
                        <th>Message</th>
                        <th>Important</th>
                        <th>Created By</th>
                        <th>Created At</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($announcementData as $announcement): ?>
                        <tr class="<?php echo $announcement['important'] ? 'important-announcement' : ''; ?>">
                            <td><?php echo $announcement['announcement_id']; ?></td>
                            <td><?php echo $announcement['title']; ?></td>
                            <td><?php echo substr($announcement['message'], 0, 50) . (strlen($announcement['message']) > 50 ? '...' : ''); ?>
                            </td>
                            <td><?php echo $announcement['important'] ? 'Yes' : 'No'; ?></td>
                            <td><?php echo $announcement['forename'] . ' ' . $announcement['surname']; ?></td>
                            <td><?php echo date('Y-m-d H:i:s', strtotime($announcement['created_at'])); ?></td>
                            <td>
                                <button
                                    onclick="LuckyNest.toggleForm('edit-form-<?php echo $announcement['announcement_id']; ?>')"
                                    class="update-button">Edit</button>
                                <!-- Edit Form -->
                                <div id="edit-form-<?php echo $announcement['announcement_id']; ?>" class="edit-form">
                                    <button type="button" class="close-button"
                                        onclick="LuckyNest.toggleForm('edit-form-<?php echo $announcement['announcement_id']; ?>')">✕</button>
                                    <form method="POST"
                                        action="announcements<?php echo isset($_GET['page']) ? '?page=' . $_GET['page'] : ''; ?>"
                                        style="display:inline;">
                                        <h2>Edit Announcement</h2>
                                        <input type="hidden" name="action" value="edit">
                                        <input type="hidden" name="announcement_id"
                                            value="<?php echo $announcement['announcement_id']; ?>">
                                        <label for="title_<?php echo $announcement['announcement_id']; ?>">Title:</label>
                                        <input type="text" id="title_<?php echo $announcement['announcement_id']; ?>"
                                            name="title" value="<?php echo htmlspecialchars($announcement['title']); ?>"
                                            required>
                                        <label
                                            for="message_<?php echo $announcement['announcement_id']; ?>">Message:</label>
                                        <textarea id="message_<?php echo $announcement['announcement_id']; ?>"
                                            name="message" rows="5"
                                            required><?php echo htmlspecialchars($announcement['message']); ?></textarea>
                                        <div class="checkbox-container">
                                            <input type="checkbox"
                                                id="important_<?php echo $announcement['announcement_id']; ?>"
                                                name="important" <?php echo $announcement['important'] ? 'checked' : ''; ?>>
                                            <label for="important_<?php echo $announcement['announcement_id']; ?>">Mark as
                                                Important</label>
                                        </div>
                                        <div class="button-group">
                                            <button type="submit" class="update-button">Update</button>
                                            <button type="button" class="update-button"
                                                onclick="if(confirm('Are you sure you want to delete this announcement?')) document.getElementById('delete-form-<?php echo $announcement['announcement_id']; ?>').submit(); return false;">Delete</button>
                                        </div>
                                    </form>

                                    <form id="delete-form-<?php echo $announcement['announcement_id']; ?>" method="POST"
                                        action="announcements<?php echo isset($_GET['page']) ? '?page=' . $_GET['page'] : ''; ?>"
                                        style="display:none;">
                                        <input type="hidden" name="action" value="delete">
                                        <input type="hidden" name="announcement_id"
                                            value="<?php echo $announcement['announcement_id']; ?>">
                                    </form>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <?php
            $url = 'announcements';
            echo generatePagination($page, $totalPages, $url);
            ?>
            <br>
        </div>
        <div id="form-overlay"></div>
    </div>
</body>

</html>