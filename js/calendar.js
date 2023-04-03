// DOM

if ("serviceWorker" in navigator) {
    navigator.serviceWorker.register("serviceworker.js").then(registration => {
        console.log("Serviceworker registered!");        
    }).catch(error => {
        console.log("ServiceWorker registration Failed!");
        console.log(error);
    })
} else {
    console.log("Geen serviceworker!");
}

let clickable;
const modal = document.getElementById("modal");
const closer = document.getElementById("close");
const left = document.getElementById("left");
const right = document.getElementById("right");
const eventButton = document.getElementById("event");
const pushButton = document.getElementById("push");

let events = JSON.parse(localStorage.getItem("events") || "[]");

getCurrentMonthDates();


function getCurrentMonthDates() {
    const april = ['27 mrt', '28 mrt', '29 mrt', '30 mrt', '31 mrt', '01 apr', '02 apr', '03 apr', '04 apr', 
    '05 apr', '06 apr', '07 apr', '08 apr', '09 apr', '10 apr', '11 apr', '12 apr', '13 apr', '14 apr', '15 apr', '16 apr', '17 apr', '18 apr', '19 apr', '20 apr', '21 apr', '22 apr', '23 apr', '24 apr', '25 apr', '26 apr', '27 apr', '28 apr', '29 apr', '30 apr'];

    april.forEach(showCurrentMonthDates);

    clickable = document.querySelectorAll(".day");
};

function showCurrentMonthDates(currentValue) {
    const wrapper = document.createElement("div");
    wrapper.classList.add("day");

    const dayDate = document.createElement("p");
    dayDate.classList.add("day-date");
    dayDate.innerHTML = currentValue.substr(0, 2);
    wrapper.appendChild(dayDate);

    const dayMonth = document.createElement("p");
    dayMonth.classList.add("day-month");
    dayMonth.innerHTML = currentValue.substr(3, 6);
    wrapper.appendChild(dayMonth);

    document.getElementById("days").appendChild(wrapper);
};

function makeNewEvent() {
    let newEvent = {};
    const errorMessage = "Alle velden moeten ingevuld worden.";

    const titleInput = document.getElementById("input-title").value;
    if (titleInput != '') {
        newEvent.title = titleInput;
    } else {
        return window.alert(errorMessage);
    };

    const startTimeInput = document.getElementById("input-starttime").value;
    if (startTimeInput != '') {
        newEvent.startTime = startTimeInput;
    } else {
        return window.alert(errorMessage);
    };

    const endTimeInput = document.getElementById("input-endtime").value;
    if (endTimeInput != '') {
        newEvent.endTime = endTimeInput;
    } else {
        return window.alert(errorMessage);
    };

    const dateInput = document.getElementById("input-date").value;
    if (dateInput != '') {
        newEvent.date = dateInput;
    } else {
        return window.alert(errorMessage);
    };

    events.push(newEvent);

    localStorage.setItem("events", JSON.stringify(events));
};

function showCorrectDate(i) {
    const dayDate = clickable[i].querySelector(".day-date").innerHTML;
    let dayMonth = clickable[i].querySelector(".day-month").innerHTML;
    if (dayMonth == 'mrt') {
        dayMonth = 'maart';
    } else if (dayMonth == 'apr') {
        dayMonth = 'april';
    }
    const currentDate = `${dayDate} ${dayMonth}`;

    const element = document.getElementById("modal-current-date");
    element.innerHTML = currentDate;
};

function showEvents(i) {

    const removeExistingElements = document.querySelectorAll(".event-single"); 
    for (let i = 0; i < removeExistingElements.length; i++) {
        removeExistingElements[i].remove();
    };

    let currentDay = clickable[i].querySelector(".day-date").innerHTML;
    let currentMonth = clickable[i].querySelector(".day-month").innerHTML;
    if (currentMonth == 'mrt') {
        currentMonth = '03';
    } else if (currentMonth == 'apr') {
        currentMonth = '04';
    };

    let toCheckAgainst = `2023-${currentMonth}-${currentDay}`;

    events.forEach(newEvent => {
        eventDate = newEvent.date;
        
        if (eventDate === toCheckAgainst) {
            const wrapper = document.createElement("div");
            wrapper.classList.add("event-single");

            const img = new Image();
            img.className = "event-single-svg";
            img.src = "svg/item-yellow.svg";
            wrapper.appendChild(img);

            const textWrapper = document.createElement("div");
            textWrapper.classList.add("event-single-text-wrapper")
        
            const eventTitle = document.createElement("p");
            eventTitle.classList.add("event-single-title");
            eventTitle.innerHTML = newEvent.title;
            textWrapper.appendChild(eventTitle);
        
            const eventTime = document.createElement("p");
            eventTime.classList.add("event-single-time");
            eventTime.innerHTML = `${newEvent.startTime} tot ${newEvent.endTime}`;
            textWrapper.appendChild(eventTime);

            wrapper.appendChild(textWrapper);
        
            document.getElementById("events").appendChild(wrapper);
        } else {
            return;
        }
    });
};


// Event listeners

for (let i = 0; i < clickable.length; i++) {
    clickable[i].addEventListener("click", function() {
        modal.style.display = "block";
        showCorrectDate(i);
        showEvents(i);
    }); 
};

closer.addEventListener("click", function() {
    modal.style.display = "none";
});

window.addEventListener("click", function(event) {
    if (event.target == modal) {
        modal.style.display = 'none';
    }
});

eventButton.addEventListener("click", function() {
    makeNewEvent();
    location.reload();
});

pushButton.addEventListener("click", function() {
    window.alert("Let op, we gaan over 10 minutes live op huddle!");
});