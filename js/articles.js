var limit = 10;
var main = document.querySelector("#writeups");
var search_bar = document.querySelector("#search_bar");
var show_more = document.querySelector("#show_more");
var url = new URL(window.location);

function get_articles() {
    main.classList.remove('full');
    search_bar.classList.remove('hide');
    show_more.classList.remove('hide');
    fetch(`api.php?action=display&top=${limit}`)
    .then(res => res.json())
    .then(data => {
        data.length == limit ? show_more.classList.remove('hide') : show_more.classList.add('hide')
        limit += 20;
        main.innerHTML = '';
        data.forEach(wp => {
            main.innerHTML +=
            `<div class="writeup" onclick="article_set_page(${wp['id']})">
                <div>
                    <h2>${wp['title']}</h2>
                    <img class="banner" src="${wp['banner']}" alt="banner">
                    <small class="date">${wp['date']}</small>
                </div>
            </div>`;
        });
    })
}

function article_set_page(id) {
    if (url.searchParams.get('wp') == null) {
        url.searchParams.append('wp', id);
        window.location = url
    } else if (url.searchParams.get('wp') != id) {
        url.searchParams.set('wp', id);
        window.location = url
    }
}

function display_article(id,password) {
    main.innerHTML = "";
    main.classList.add('full');
    search_bar.classList.add('hide');
    show_more.classList.add('hide');
    fetch(`api.php?action=display&id=${id}&password=${password}`)
    .then(res => res.json())
    .then(data => {
        console.log(data)
        if (data['state'] == "failed") {
            pass = prompt('Enter the last flag : \nfor HTB machines enter the md5sum of the root hash at /etc/shadow :')
            if (pass) {
                display_article(id,pass);
            } else {
                main.innerHTML = 
                `<div class='error'>Access denied !</div>
                <button class='error-btn' onclick='location.reload()'>retry</button>
                <a id="back_writeups" href="?page=writeups">back</a>`;
            }
        } else {
            wp = data[0]
            main.innerHTML =
            `<a id="back_writeups" href="?page=writeups">back</a>
            <div class="writeup">
                <div>
                    <img class="banner" src="${wp['banner']}" alt="banner">
                    <div class="markdown-body">${md.render(wp['content'])}</div>
                    <small class="date">${wp['date']}</small>
                </div>
            </div>`;
        }
    });
}

function search_article() {
    if (search_bar.value.length == 0) {
        get_articles();
    } else {
        fetch(`api.php?action=display&search=${search_bar.value}`)
        .then(res => res.json())
        .then(data => {
            main.innerHTML = "";
            data.forEach(wp => {
                main.innerHTML +=
                `<div class="writeup" onclick="article_set_page(${wp['id']})">
                    <div>
                        <h2>${wp['title']}</h2>
                        <img class="banner" src="${wp['banner']}" alt="banner">
                        <small class="date">${wp['date']}</small>
                    </div>
                </div>`;
            });
        })
    }
}

if (url.searchParams.get('wp') != null) {
    display_article(url.searchParams.get('wp'),'')
} else {
    get_articles();
    search_bar.addEventListener('input', search_article)
}