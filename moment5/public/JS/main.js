"use strict"

//Variabler
let courseEl = document.getElementById('courses');
let addCoursebtn = document.getElementById('addCourse');
let codeInput = document.getElementById('code');
let nameInput = document.getElementById('name');
let progressionInput = document.getElementById('progression');
let coursesyllabusInput = document.getElementById('coursesyllabus');


//Händelselyssnare
window.addEventListener('load', getCourses);
addCoursebtn.addEventListener('click', addCourse);


//funktioner
function getCourses() {
    courseEl.innerHTML = '';

    fetch('http://localhost/Moment%205%20PHP/moment5/Courses.php')
        .then(response => response.json())
        .then(data => {
            data.forEach(course => {
                courseEl.innerHTML +=
                    `<div class=courses>
                    <p>
                    <b>Kurskod:</b>${course.code}<br>
                    <b>Kursnamn:</b>${course.name}<br>
                    <b>Progression:</b>${course.progression}<br>
                    <b>Kursplan:</b>${course.coursesyllabus}
                    </p>
                    <button id = ${course.id} onClick="deleteCourse(${course.id})">Radera kurs</button>
                </div>`
            });
        })
}

function deleteCourse(id) {
    fetch('http://localhost/Moment%205%20PHP/moment5/Courses.php?id=' + id, {
            method: 'DELETE',
        })
        .then(response => response.json())
        .then(data => {
            getCourses();
        })
        .catch(error => {
            console.log('Error:', error)
        })
}

function addCourse() {
    let code = codeInput.value;
    let name = nameInput.value;
    let progression = progressionInput.value;
    let coursesyllabus = coursesyllabusInput.value;

    let course = { "code": code, "name": name, "progression": progression, "coursesyllabus": coursesyllabus };

    fetch('http://localhost/Moment%205%20PHP/moment5/Courses.php', {
            method: 'POST',
            body: JSON.stringify(course),
        })
        .then(response => response.json())
        .then(data => {
            getCourses();
        })
        .catch(error => {
            console.log('Error:', error)
        })

}