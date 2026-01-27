// public/assets/app.js

// Wacht tot de volledige HTML geladen is, zodat alle elementen bestaan voordat we ze ophalen.
document.addEventListener("DOMContentLoaded", () => {
    // Fallback naar lege array
    const rooms = Array.isArray(window.ROOMS) ? window.ROOMS : [];

    // Fallback naar lege array
    const allEvents = Array.isArray(window.EVENTS) ? window.EVENTS : [];

    // Container waar de zaal-knoppen in gerenderd worden
    const roomsListEl = document.getElementById("roomsList");

    // Hidden input waar we de gekozen room id in stoppen (zodat je het kan submitten)
    const roomIdInput = document.getElementById("roomIdInput");

    // UI-element waar de gekozen room naam/capaciteit getoond wordt
    const selectedRoomNameEl = document.getElementById("selectedRoomName");

    // Form velden en de reserve button
    const titleInput = document.getElementById("titleInput");
    const startInput = document.getElementById("startInput");
    const endInput = document.getElementById("endInput");
    const reserveBtn = document.getElementById("reserveBtn");

    /**
     * Zet het formulier aan/uit.
     * - enabled=true: user kan invullen en reserveren.
     * - enabled=false: alles disabled (pas na kiezen van een zaal).
     */
    function setFormEnabled(enabled) {
        if (titleInput) titleInput.disabled = !enabled;
        if (startInput) startInput.disabled = !enabled;
        if (endInput) endInput.disabled = !enabled;
        if (reserveBtn) reserveBtn.disabled = !enabled;
    }

    // Haalt de "selected" highlight weg van alle zaal-rows.

    function clearSelectionUI() {
        if (!roomsListEl) return;
        roomsListEl.querySelectorAll(".room_row").forEach((el) => {
            el.classList.remove("is-selected");
        });
    }

    // Reset de gekozen zaal:

    function resetSelection() {
        if (roomIdInput) roomIdInput.value = "";
        if (selectedRoomNameEl) selectedRoomNameEl.textContent = "Geen";
        clearSelectionUI();
        setFormEnabled(false);
    }

    /**
     * Render de zaal-lijst als knoppen.
     * list verwacht items zoals: { id, name }
     */
    function renderRoomsList(list) {
        // Als er geen container is, return
        if (!roomsListEl) return;

        // Maak de lijst leeg voordat we opnieuw renderen (voorkomt duplicates).
        roomsListEl.innerHTML = "";

        // Als er geen zalen zijn: message + selection reset.
        if (list.length === 0) {
            roomsListEl.textContent = "Geen zalen gevonden.";
            resetSelection();
            return;
        }

        // Wrapper div zorgt voor makkelijke css styling
        const wrap = document.createElement("div");
        wrap.className = "rooms_list";

        // Voor elke room maken we een button aan.
        list.forEach((r, idx) => {
            const btn = document.createElement("button");
            btn.type = "button";
            btn.className = "room_row";

            // Kleuren zoals wireframe
            if (idx === 0) btn.classList.add("is-brown");
            else if (idx === 1) btn.classList.add("is-cyan");
            else btn.classList.add("is-navy");

            // Linkerkant van de row: zaalnaam + capaciteit
            const left = document.createElement("span");
            left.className = "room_left";
            left.textContent = `${r.name} (${r.capacity} zitplaatsen)`;

            // Rechterkant van de row: label (in jouw wireframe "Ruilen")
            const right = document.createElement("span");
            right.className = "room_right";
            right.textContent = "Ruilen";

            // Zet spans in de button
            btn.appendChild(left);
            btn.appendChild(right);


            var x = document.getElementById("reserveForm");
            let z = 2;
            if (z === 2) {
                x.style.display = "none";
            }
            btn.addEventListener("click", () => {
                clearSelectionUI();
                btn.classList.add("is-selected");

                // Gekozen zaal id opslaan (nodig voor submit) en click to show reservering
                let y = roomIdInput.value;
                if (roomIdInput) roomIdInput.value = String(r.id);


                if (x.style.display === "block") {

                    if (y === (r.id))
                        x.style.display = "none";
                    else {
                        x.style.display = "block";
                    }
                } else {
                    x.style.display = "block";
                }

                // Tekst tonen bij "selected room"
                if (selectedRoomNameEl) {
                    selectedRoomNameEl.textContent = `${r.name} (${r.capacity} zitplaatsen)`;
                }

                // Form aanzetten zodat je titel/start/eind kan invullen
                setFormEnabled(true);
            });


            // Voeg de button toe aan de wrapper
            wrap.appendChild(btn);
        });

        // Voeg wrapper toe aan de DOM
        roomsListEl.appendChild(wrap);
    }

    // INIT: zet form uit totdat er een zaal geselecteerd is
    setFormEnabled(false);

    // Render zaal lijst op basis van rooms array
    renderRoomsList(rooms);

    // Forceer "geen selectie" status (ook handig bij refresh)
    resetSelection();


    // Calendar (FullCalendar)



    // Element waar de kalender in moet komen
    const calEl = document.getElementById("calendar");

    // Als er geen calendar element is, stoppen we hier
    if (!calEl) return;

    // Check of FullCalendar script echt geladen is
    if (typeof FullCalendar === "undefined") {
        calEl.textContent = "FullCalendar niet geladen.";
        return;
    }

    // Maak de FullCalendar instance aan
    const calendar = new FullCalendar.Calendar(calEl, {
        // Start view;
        initialView: "timeGridWeek",



        locale: "nl",

        // Header toolbar uit (wij gebruiken eigen knoppen/tabs)
        headerToolbar: false,

        // Laat een "nu" lijn zien in de agenda
        nowIndicator: true,

        // Eerst getoonde dag in de agenda
        firstDay: 1,

        // Geen all-day balk
        allDaySlot: false,

        // Kalender vult de container hoogte
        height: "100%",

        // Zorgt dat rijen uren uitrekken
        expandRows: true,

        // Tijd-range die zichtbaar is in de kalender
        slotMinTime: "09:00:00",
        slotMaxTime: "16:30:00",

        // Interval per slot
        slotDuration: "00:30:00",

        // Labels links ook per 30 minuten
        slotLabelInterval: "00:30:00",

        // Dag headers: alleen weekday
        dayHeaderFormat: {weekday: "long"},

        // Events data
        events: allEvents
    });

    // Render de kalender op de pagina
    calendar.render();

    // Tabs / View-switch buttons


    // Buttons om view te wisselen (maand/week/dag)
    const btnMonth = document.getElementById("btnViewMonth");
    const btnWeek = document.getElementById("btnViewWeek");
    const btnDay = document.getElementById("btnViewDay");

    // Zet de actieve tab styling:
    // haalt is-active weg bij alle knoppen
    // zet is-active op de gekozen knop

    function setActive(btn) {
        [btnMonth, btnWeek, btnDay].forEach((b) => b && b.classList.remove("is-active"));
        btn && btn.classList.add("is-active");
    }

    // Month view knop: wissel naar maand grid + maak selectie leeg
    if (btnMonth) {
        btnMonth.addEventListener("click", () => {
            calendar.changeView("dayGridMonth");
            setActive(btnMonth);
            resetSelection();
        });
    }

    // Week view knop: wissel naar week tijd-grid + selectie leeg
    if (btnWeek) {
        btnWeek.addEventListener("click", () => {
            calendar.changeView("timeGridWeek");
            setActive(btnWeek);
            resetSelection();
        });
    }

    // Day view knop: wissel naar dag tijd-grid + selectie leeg
    if (btnDay) {
        btnDay.addEventListener("click", () => {
            calendar.changeView("timeGridDay");
            setActive(btnDay);
            resetSelection();
        });
    }
});
