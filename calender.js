const calendarEl = document.getElementById('calendar');
const monthYearEl = document.getElementById('monthYear');
const modalEl = document.getElementById('eventModal');
let currentDate = new Date();

function renderCalender(date = new Date()) {
    // Clear the existing calendar
    calendarEl.innerHTML = '';

    const month = date.getMonth();
    const year = date.getFullYear();
    const today = new Date();

    const totalDays = new Date(year, month + 1, 0).getDate();
    const firstDayOfMonth = new Date(year, month, 1).getDay();

    //   Display the current month and year
    monthYearEl.textContent = date.toLocaleDateString('default', { 'en-US': { month: 'long', year: 'numeric' } });
    const weekDays = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
    weekDays.forEach(day => {
        const dayEl = document.createElement('div');
        dayEl.className = 'day-name';
        dayEl.textContent = day;
        calendarEl.appendChild(dayEl);
    });

    // Create the calendar days
    for (let i = 0; i < firstDayOfMonth; i++) {
        const dayEl = document.createElement('div');
        calendarEl.appendChild(dayEl);
    }

    for (let day = 1; day <= totalDays; day++) {
        const dateStr = `${year}-${String(month + 1).padStart(2, '0')}-${String(day).padStart(2, '0')}`;
        const cell = document.createElement('div');
        cell.className = 'day';

        if (day === today.getDate() && month === today.getMonth() && year === today.getFullYear()) {
            cell.classList.add('today');
        }

        const dateEl = document.createElement('div');

        dateEl.className = 'date-number';
        dateEl.textContent = day;
        cell.appendChild(dateEl);

        const eventToday = events.filter(e => e.date === dateStr);
        const eventBox = document.createElement('div');
        eventBox.className = 'events';

        // Render events
        eventsToday.forEach(event => {
            const ev = document.createElement('div');
            ev.className = 'event';

            const courseEl = document.createElement('div');
            courseEl.className = 'course';
            courseEl.textContent = event.title.split(' - ')[0];

            const instructorEl = document.createElement('div');
            instructorEl.className = 'instructor';
            instructorEl.textContent = '🏫 ' + event.title.split(' - ')[1];

            const timeEl = document.createElement('div');
            timeEl.className = 'time';
            timeEl.textContent = '🕒 ' + event.start_time + ' - ' + event.end_time;

            ev.appendChild(courseEl);
            ev.appendChild(instructorEl);
            ev.appendChild(timeEl);
            eventBox.appendChild(ev);
        });

        // Overlay buttons
        const overlay = document.createElement('div');
        overlay.className = 'day-overlay';

        const addButton = document.createElement('button');
        addButton.className = 'overlay-btn';
        addButton.textContent = '+ Add';
        addButton.onclick = e => {
            e.stopPropagation();
            openModalForAdd(dateStr);
        };
        overlay.appendChild(addButton);

        if (eventToday.length > 0) {
            // overlay.style.display = 'flex';
            const editButton = document.createElement('button');
            editButton.className = 'overlay-btn';
            editButton.textContent = 'Edit';
            editButton.onclick = e => {
                e.stopPropagation();
                openModalForEdit(eventsToday);
            };
            overlay.appendChild(editButton);
        }

        cell.appendChild(overlay);
        cell.appendChild(eventBox);
        calendarEl.appendChild(cell);
    }
}

// Add Event Modal Logic
function openModalForAdd(dateStr) {
    document.getElementById('formAction').value = 'add';
    document.getElementById('eventId').value = '';
    document.getElementById('deleteEventId').value = '';
    document.getElementById('courseName').value = '';
    document.getElementById('instructorName').value = '';
    document.getElementById('startDate').value = dateStr;
    document.getElementById('endDate').value = dateStr;
    document.getElementById('startTime').value = '09:00';
    document.getElementById('endTime').value = '17:00';

    const selector = document.getElementById('eventSelector');
    const wrapper = document.getElementById('eventSelectorWrapper');

    if (selector && wrapper) {
        selector.innerHTML = '';
        wrapper.style.display = 'none';
    }

    modalEl.style.display = 'flex';
}

// Edit event modal logic
function openModalForEdit(eventsOnDate) {
   
}