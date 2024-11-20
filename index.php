<?php
session_start();

$jsonFile = 'sportData.json';
$jsonData = json_decode(file_get_contents($jsonFile), true);

if (!isset($jsonData['data']) || !is_array($jsonData['data'])) {
    die('Invalid JSON data structure.');
}

$events = $jsonData['data'];
if (isset($_SESSION['events'])) {
    $events = array_merge($events, $_SESSION['events']);
}
?>
<script>
    const events = <?php echo json_encode($events); ?>;
</script>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sports Event Calendar</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<?php include 'nav.php'; ?>
    <div class="container">
        <h1 class="text-center my-4">Sports Event Calendar</h1>
        <div id="calendar-nav" class="d-flex justify-content-between align-items-center mb-3">
            <button id="prev-month" class="btn btn-outline-primary animate-btn">&larr;</button>
            <h2 id="current-month" class="mb-0"></h2>
            <button id="next-month" class="btn btn-outline-primary animate-btn">&rarr;</button>
        </div>
        <form id="filterForm" class="row mb-4">
            <div class="col-lg-4 col-md-6 mb-3">
                <label for="sportFilter" class="form-label">Filter by Sport</label>
                <select id="sportFilter" class="form-control">
                    <option value="" selected>All Sports</option>
                    <?php
                    $sports = [];
                    foreach ($events as $event) {
                        if (!in_array($event['sport'], $sports)) {
                            $sports[] = $event['sport'];
                        }
                    }
                    foreach ($sports as $sport): ?>
                        <option value="<?php echo htmlspecialchars($sport); ?>"><?php echo htmlspecialchars($sport); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-lg-4 col-md-6 mb-3">
                <label for="startDateFilter" class="form-label">Start Date</label>
                <input type="date" id="startDateFilter" class="form-control">
            </div>
            <div class="col-lg-4 col-md-6 mb-3">
                <label for="endDateFilter" class="form-label">End Date</label>
                <input type="date" id="endDateFilter" class="form-control">
            </div>
            <div class="col-12 text-center">
                <button type="button" id="applyFilters" class="btn btn-primary animate-btn">Apply Filters</button>
                <button type="button" id="resetFilters" class="btn btn-secondary animate-btn">Reset Filters</button>
            </div>
        </form>
        <div id="calendar" class="calendar"></div>
    </div>
    <div class="modal fade" id="eventModal" tabindex="-1" aria-labelledby="eventModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="eventModalLabel">Select an Event</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="eventModalBody"></div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="noEventModal" tabindex="-1" aria-labelledby="noEventModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="noEventModalLabel">No Events</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">There are no events on this day.</div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="calendar.js"></script>
</body>
</html>
