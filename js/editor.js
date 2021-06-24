var input = document.querySelector("textarea");
var output = document.querySelector("#render");
var title = document.querySelector("#title");
var banner = document.querySelector("#banner");
var old_wp_container = document.querySelector("#old_wp_container");
var send = document.querySelector("#send");
var update = document.querySelector("#update");
var password = document.querySelector("#password");
var tags = document.querySelector("#tags");
var delete_ = document.querySelector("#delete");
var file_ = document.querySelector("#file");
var image_input = document.querySelector('#image-input');
var image = document.querySelector('#image');
var image_container = document.querySelector("#image-container");
var image_name = document.querySelector('#image-name');
var manage_image_container = document.querySelector('#manage-image-container');
var manage_image = document.querySelector('#manage-image-container > div');
var old_wps;
var cropper;
var reader;
var ID;

const submit_wp = () => {
    data = new URLSearchParams({
        'title': title.value,
        'content': input.value,
        'banner': banner.value,
        'password': password.value,
        'tags': tags.value
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

const get_old_wp = () => {
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

const update_wp = () => {
    data = new URLSearchParams({
        'title': title.value,
        'content': input.value,
        'banner': banner.value,
        'id': ID,
        'password': password.value,
        'tags': tags.value
    })
    fetch(`api.php?action=edit`, {
        method: 'POST',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        body: data
    })
    .then(() => location.reload())
}

const modify = () => {
    if (old_wp_container.value == "new") {
        send.style.display = 'block';
        update.style.display = 'none';
        delete_.style.display = 'none';
        input.innerHTML = "";
        output.innerHTML = "";
        title.value = "";
        banner.value = "";
        password.value = "";
        tags.value = "";
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
                tags.value = wp['tags'];
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

image_input.addEventListener('input', (e) => {
    var file = image_input.files[0];
    reader = new FileReader();
    reader.addEventListener("load", function () {
        image.src = reader.result;

        cropper = new Cropper(image, {});

    }, false);
    if (file) {
        reader.readAsDataURL(file);
    }
})

const upload_image = () => {
    data = new URLSearchParams({
        'name': image_name.value,
        'image': cropper.getCroppedCanvas().toDataURL()
    })
    fetch('api.php?action=upload_image', {
        method: 'POST',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        body: data
    })
    .then(res => res.json())
    .then(res => {
        if (res['state'] == 'success') {
            alert('image uploaded successfully ✅')
        } else if (res['state'] == 'failed') {
            alert('image already exists ❌')
        }
    })
}

const add_image = () => {
    image_container.classList.toggle('visible');
}

const clear_image = () => {
    image.src = '';
    cropper.destroy();
}

const manage_images = () => {
    fetch('api.php?action=manage_image')
    .then(res => res.json())
    .then(res => {
        manage_image_container.classList.add('visible')
        manage_image.innerHTML = ''
        for (key in res) {
            manage_image.innerHTML +=
            `<div>
                <p class="image-name">${res[key]}</p>
                <button onclick="delete_image('${res[key]}')"></button>
            </div>`;
        }
    })
}

const close_manage_image = () => {
    manage_image_container.classList.remove('visible')
}

const delete_image = (name) => {
    if (confirm(`are you sure you want to delete ${name}`)) {
        data = new URLSearchParams({
            'name': name
        })
        fetch('api.php?action=manage_image', {
            method: 'POST',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'},
            body: data
        })
        .then(res => res.json())
        .then(res => {
            if (res['state'] == 'success') {
                alert('image successfully deleted ✅')
                manage_images()
            }
        })
    }
}

update.style.display = 'none';
delete_.style.display = 'none';

get_old_wp();

document.addEventListener('keydown', e => {
    if (e.code == "Tab") {
        e.preventDefault();
    }
})