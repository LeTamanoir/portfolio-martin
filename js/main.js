const frontendBtn = document.querySelector("#frontend-btn");
const backendBtn = document.querySelector("#backend-btn");
const frontend = document.querySelector("#frontend");
const backend = document.querySelector("#backend");

const showSkill = (skill) => {
    if (skill == "frontend") {
        frontendBtn.classList.add("click");
        backendBtn.classList.remove("click"); 
        frontend.classList.add("deploy");
        backend.classList.remove("deploy");
    } else if (skill == "backend") {
        backendBtn.classList.add("click");
        frontendBtn.classList.remove("click");
        backend.classList.add("deploy");
        frontend.classList.remove("deploy");
    }
}