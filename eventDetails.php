<?php
// Start session for data sharing
session_start();

// Get event data passed via query parameters
$eventData = isset($_GET['event']) ? json_decode($_GET['event'], true) : null;

if (!$eventData) {
    echo "<h1>Invalid Event Details</h1>";
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<?php include 'nav.php'; ?>
    <div class="container mt-5">
        <h1 class="text-center">Event Details</h1>
        <div class="card mt-4">
            <div class="card-body">
            <h3 class="card-title">
                <?php echo ($eventData['homeTeam']['name'] ?? 'Unknown Team') . " vs. " . ($eventData['awayTeam']['name'] ?? 'Unknown Team'); ?>
            </h3>
                <p><strong>Date:</strong> <?php echo $eventData['dateVenue']; ?></p>
                <p><strong>Time:</strong> <?php echo $eventData['timeVenueUTC']; ?></p>
                <p><strong>Sport:</strong> <?php echo $eventData['sport']; ?></p>
                <p><strong>Stage:</strong> <?php echo $eventData['stage']['name'] ?? 'N/A'; ?></p>
                </div>
        </div>
        <a href="index.php" class="btn btn-primary mt-4">Back to Calendar</a>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
