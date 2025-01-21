function gettheDate() {
    const months = [
        "stycznia", "lutego", "marca", "kwietnia", "maja", "czerwca",
        "lipca", "sierpnia", "września", "października", "listopada", "grudnia"
    ];
    const Todays = new Date();
    const day = Todays.getDate();
    const month = months[Todays.getMonth()];
    const year = Todays.getFullYear();
    const TheDate = `${day} ${month} ${year}`;
    document.getElementById("data").innerHTML = TheDate;
}

let timerID = null;
let timerRunning = false;

function stopclock() {
    if (timerRunning) clearTimeout(timerID);
    timerRunning = false;
}

function startclock() {
    stopclock();
    gettheDate();
    showtime();
}

function showtime() {
    const now = new Date();
    const hours = now.getHours();
    const minutes = now.getMinutes();
    const seconds = now.getSeconds();
    const timeValue =
        `${hours < 10 ? "0" : ""}${hours}:${minutes < 10 ? "0" : ""}${minutes}:${seconds < 10 ? "0" : ""}${seconds}`;
    document.getElementById("zegarek").innerHTML = timeValue;
    timerID = setTimeout(showtime, 1000);
    timerRunning = true;
}
