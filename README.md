 Sportradar Frontend exercise

 Overview
The Sports Event Calendar is a web application designed to help users view and manage sports events seamlessly. It features a responsive calendar view, the ability to filter events based on sport or date range, and the functionality to add new events dynamically. Built using JavaScript, Bootstrap, and PHP, the application ensures a smooth and visually appealing user experience.

 Features
- Interactive Calendar: View events by date, with filters for sport and date range.
- Event Details: Click on any event to view its details on a dedicated page.
- Add Events: Add new events directly from the "Add Event" page.
- Responsive Design: Fully optimized for desktop, tablet, and mobile devices.
- Dynamic Models: Seamlessly interact with modals for event details and no-event notifications.

Technologies Used
- PHP: Backend logic and session management.
- JavaScript: Frontend interactivity and dynamic calendar rendering.
- Bootstrap: Styling and responsive design.

 How to Run the Application

 Prerequisites
- [XAMPP](https://www.apachefriends.org/index.html) installed on your system.
- A modern web browser for testing and running the application.

 Installation
1. Clone the repository or download the project as a ZIP file and extract it.
   git clone <repository_url>
2. Move the project folder to the `htdocs` directory inside your XAMPP installation folder. For example:
   C:\xampp\htdocs\sports-event-calendar
3. Start the Apache server in the XAMPP Control Panel.

 Running the Application
1. Open a browser and navigate to:
   http://localhost/sports-event-calendar
2. Use the navigation bar to switch between:
   - Calendar Overview: View and filter events.
   - Add Event: Add a new event to the calendar.

 Assumptions and Decisions
 Assumptions
1. Session Management: Events added during a session are stored temporarily using PHP sessions and are not persistent.
2. JSON File Format: The `sportData.json` file contains predefined events with the following fields:
   - `homeTeam` and `awayTeam` (objects with `name` fields).
   - `dateVenue`, `timeVenueUTC`, `sport`, and `stage`.

 Decisions
1. Responsive Design: Built to ensure usability on small screens with features like sliders for the calendar and responsive navigation.
2. No Database: PHP sessions are used for temporary storage to avoid complexity and ensure portability.
3. Browser Compatibility: Focused on modern browsers for animations and responsiveness.

