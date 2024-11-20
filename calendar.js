$(document).ready(function () {
    const calendar = $('#calendar');
    const currentMonth = $('#current-month');
    let date = new Date(); // Start with the current date

    // Event filters
    let filters = {
        sport: '',
        startDate: '',
        endDate: '',
    };

    // Apply filters to events
    function filterEvents(events) {
        return events.filter(event => {
            const eventDate = new Date(event.dateVenue);
            const sportMatches = filters.sport === '' || event.sport === filters.sport;
            const startDateMatches = filters.startDate === '' || eventDate >= new Date(filters.startDate);
            const endDateMatches = filters.endDate === '' || eventDate <= new Date(filters.endDate);

            return sportMatches && startDateMatches && endDateMatches;
        });
    }

    function renderCalendar() {
        const year = date.getFullYear();
        const month = date.getMonth();

        // Set the current month name
        const monthNames = [
            'January', 'February', 'March', 'April', 'May', 'June',
            'July', 'August', 'September', 'October', 'November', 'December'
        ];
        currentMonth.text(`${monthNames[month]} ${year}`);

        // Clear the calendar
        calendar.empty();

        // Add day names
        const dayNames = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
        dayNames.forEach(day => {
            calendar.append(`<div class="day-name">${day}</div>`);
        });

        // Get the first day of the month
        let firstDay = new Date(year, month, 1).getDay();
        firstDay = (firstDay === 0 ? 6 : firstDay - 1); // Adjust to start from Monday

        // Get total days in the month
        const daysInMonth = new Date(year, month + 1, 0).getDate();

        // Filter events
        const filteredEvents = filterEvents(events);

        // Generate empty cells for days before the first day
        for (let i = 0; i < firstDay; i++) {
            calendar.append('<div class="day empty"></div>');
        }

        // Generate day cells
        for (let day = 1; day <= daysInMonth; day++) {
            const dateStr = `${year}-${String(month + 1).padStart(2, '0')}-${String(day).padStart(2, '0')}`;
            const dayEvents = filteredEvents.filter(event => event.dateVenue === dateStr);

            let dayContent = `${day}`;
            if (dayEvents.length === 1) {
                const homeTeam = dayEvents[0].homeTeam ? dayEvents[0].homeTeam.name : "Unknown Team";
                const awayTeam = dayEvents[0].awayTeam ? dayEvents[0].awayTeam.name : "Unknown Team";
                dayContent += `<div>${homeTeam} vs. ${awayTeam}</div>`;
            } else if (dayEvents.length > 1) {
                dayContent += `<div class="event-dot"></div><div class="event-more">More...</div>`;
            }

            calendar.append(`<div class="day" data-events='${JSON.stringify(dayEvents)}'>${dayContent}</div>`);
        }

        bindEventClicks();
    }

    function bindEventClicks() {
        $('.day').off('click').on('click', function () {
            const dayEvents = $(this).data('events');

            // Show "No Events" modal for empty days
            if (!dayEvents || dayEvents.length === 0) {
                showNoEventModal();
            } else if (dayEvents.length === 1) {
                // Redirect to event details page for single events
                window.location.href = `eventDetails.php?event=${encodeURIComponent(JSON.stringify(dayEvents[0]))}`;
            } else {
                // Show modal for multiple events
                showEventModal(dayEvents);
            }
        });
    }

    function showNoEventModal() {
        $('#noEventModal').modal('show');
    }

    function showEventModal(events) {
        let modalContent = '<ul class="list-group">';
        events.forEach(event => {
            const homeTeam = event.homeTeam ? event.homeTeam.name : "Unknown Team";
            const awayTeam = event.awayTeam ? event.awayTeam.name : "Unknown Team";
            modalContent += `
                <li class="list-group-item">
                    <a href="eventDetails.php?event=${encodeURIComponent(JSON.stringify(event))}">
                        ${homeTeam} vs. ${awayTeam}
                    </a>
                </li>
            `;
        });
        modalContent += '</ul>';
        $('#eventModalBody').html(modalContent);
        $('#eventModal').modal('show');
    }

    // Event listeners for filter form
    $('#applyFilters').click(() => {
        filters.sport = $('#sportFilter').val();
        filters.startDate = $('#startDateFilter').val();
        filters.endDate = $('#endDateFilter').val();
        renderCalendar();
    });

    $('#resetFilters').click(() => {
        filters = { sport: '', startDate: '', endDate: '' };
        $('#sportFilter').val('');
        $('#startDateFilter').val('');
        $('#endDateFilter').val('');
        renderCalendar();
    });

    $('#prev-month').click(() => {
        date.setMonth(date.getMonth() - 1);
        renderCalendar();
    });

    $('#next-month').click(() => {
        date.setMonth(date.getMonth() + 1);
        renderCalendar();
    });

    renderCalendar();
});
