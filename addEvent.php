<?php
session_start();

// Load teams and stages from the JSON file
$jsonFile = 'sportData.json';
$jsonData = json_decode(file_get_contents($jsonFile), true);

// Extract unique team names
$teams = [];
foreach ($jsonData['data'] as $event) {
    if (isset($event['homeTeam']['name']) && !in_array($event['homeTeam']['name'], $teams)) {
        $teams[] = $event['homeTeam']['name'];
    }
    if (isset($event['awayTeam']['name']) && !in_array($event['awayTeam']['name'], $teams)) {
        $teams[] = $event['awayTeam']['name'];
    }
}

// Extract unique stages
$stages = [];
foreach ($jsonData['data'] as $event) {
    if (isset($event['stage']['name']) && !in_array($event['stage']['name'], $stages)) {
        $stages[] = $event['stage']['name'];
    }
}

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $newEvent = [
        'dateVenue' => $_POST['eventDate'],
        'timeVenueUTC' => $_POST['eventTime'],
        'homeTeam' => ['name' => $_POST['homeTeam']],
        'awayTeam' => ['name' => $_POST['awayTeam']],
        'sport' => $_POST['sport'],
        'stage' => ['name' => $_POST['stage']]
    ];

    // Save the new event to the session
    if (!isset($_SESSION['events'])) {
        $_SESSION['events'] = [];
    }
    $_SESSION['events'][] = $newEvent;

    // Redirect to the main calendar
    header('Location: index.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Event</title>
    <link rel="stylesheet" href="styles.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<?php include 'nav.php'; ?>
    <div class="container mt-5">
        <h1 class="text-center mb-4">Add New Event</h1>
        <form method="post" action="" class="row g-3">
            <div class="col-md-6">
                <label for="eventDate" class="form-label">Date</label>
                <input type="date" class="form-control" id="eventDate" name="eventDate" required>
            </div>
            <div class="col-md-6">
                <label for="eventTime" class="form-label">Time</label>
                <input type="time" class="form-control" id="eventTime" name="eventTime" required>
            </div>
            <div class="col-md-6">
                <label for="homeTeam" class="form-label">Home Team</label>
                <select class="form-control" id="homeTeam" name="homeTeam" required>
                    <option value="" disabled selected>Select a team</option>
                    <?php foreach ($teams as $team): ?>
                        <option value="<?php echo htmlspecialchars($team); ?>"><?php echo htmlspecialchars($team); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-6">
                <label for="awayTeam" class="form-label">Away Team</label>
                <select class="form-control" id="awayTeam" name="awayTeam" required>
                    <option value="" disabled selected>Select a team</option>
                    <?php foreach ($teams as $team): ?>
                        <option value="<?php echo htmlspecialchars($team); ?>"><?php echo htmlspecialchars($team); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-6">
                <label for="sport" class="form-label">Sport</label>
                <input type="text" class="form-control" id="sport" name="sport" placeholder="Enter the sport" required>
            </div>
            <div class="col-md-6">
                <label for="stage" class="form-label">Stage</label>
                <select class="form-control" id="stage" name="stage" required>
                    <option value="" disabled selected>Select a stage</option>
                    <?php foreach ($stages as $stage): ?>
                        <option value="<?php echo htmlspecialchars($stage); ?>"><?php echo htmlspecialchars($stage); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-12 text-center mt-3">
                <button type="submit" class="btn btn-primary">Add Event</button>
                <a href="index.php" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

