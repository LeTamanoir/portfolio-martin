var input = document.querySelector("textarea");
var output = document.querySelector("#render");
var title = document.querySelector("#title");
var banner = document.querySelector("#banner");
var old_wp_container = document.querySelector("#old_wp_container");
var old_wps;
var send = document.querySelector("#send");
var update = document.querySelector("#update");
var password = document.querySelector("#password");
var delete_ = document.querySelector("#delete");
var file_ = document.querySelector("#file");
var ID;

function submit_wp() {
    data = new URLSearchParams({
        'title': title.value,
        'content': input.value,
        'banner': banner.value,
        'password': password.value
    })
    fetch('api.php?action=upload', {
        method: 'POST',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        body: data
    })
    .then(() => location.reload())
}

input.addEventListener("input", () => {
    output.innerHTML = md.render(input.value)
})

function get_old_wp() {
    fetch(`api.php?action=getall`)
    .then(res => res.json())
    .then(data => {
        old_wps = data
        old_wps.forEach(wp => {
            old_wp_container.innerHTML +=
            `<option value="${wp['id']}" class="old_wp">${wp['title']}</option>`;
        });
    })
}

function update_wp() {
    data = new URLSearchParams({
        'title': title.value,
        'content': input.value,
        'banner': banner.value,
        'id': ID,
        'password': password.value
    })
    fetch(`api.php?action=edit`, {
        method: 'POST',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        body: data
    })
    .then(() => location.reload())
}

function modify() {
    if (old_wp_container.value == "new") {
        send.style.display = 'block';
        update.style.display = 'none';
        delete_.style.display = 'none';
        input.innerHTML = "";
        output.innerHTML = "";
        title.value = "";
        banner.value = "";
        password.value = "";
    } else {
        send.style.display = 'none';
        update.style.display = 'block';
        delete_.style.display = 'block';
        ID = old_wp_container.value
        old_wps.map(wp => {
            if (wp['id'] == ID) {
                input.innerHTML = wp['content'];
                output.innerHTML = md.render(wp['content']);
                title.value = wp['title'];
                banner.value = wp['banner'];
                password.value = wp['password'];
            }
        })
    }
}

function delete_wp() {
    if (!confirm('Are you sure ?')) {
        return null
    }
    data = new URLSearchParams({
        'id': ID
    })
    fetch(`api.php?action=delete`, {
        method: 'POST',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        body: data
    })
    .then(() => location.reload())
}

update.style.display = 'none';
delete_.style.display = 'none';

get_old_wp();

document.addEventListener('keydown', e => {
    if (e.code == "Tab") {
        e.preventDefault();
    }
})