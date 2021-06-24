var main = document.querySelector("#writeups");
var search_bar = document.querySelector("#search_bar");
var last_state;

const get_articles = () => {
    main.classList.remove('full');
    search_bar.classList.remove('hide');
    fetch(`api.php?action=display`)
    .then(res => res.json())
    .then(data => {
        main.innerHTML = '';
        data.forEach(wp => {
            var tags = '';
            wp['tags'].split(',').forEach(tag => tags+=`<span tag="${tag}">${tag}</span>`)
            main.innerHTML +=
            `<div class="writeup" onclick="article_set_page(${wp['id']})">
                <div>
                    <h2>${wp['title']}</h2>
                    <div class="tags">${tags}</div>
                    <img class="banner" src="${wp['banner']}" alt="banner">
                    <small class="date">${wp['date']}</small>
                </div>
            </div>`;
        });
    })
}

const display_article = (id,password) => {
    main.innerHTML = "";
    main.classList.add('full');
    search_bar.classList.add('hide');
    fetch(`api.php?action=display&id=${id}&password=${password}`)
    .then(res => res.json())
    .then(data => {
        if (data['state'] == "failed") {
            password.length > 0 ? access_denied = '<p class="error">Access denied !</p>' : access_denied = '';
            main.innerHTML =
            `<button id="back_writeups" onclick="back_articles()">back</button>
            <div id="conn">
                <p>
                    Enter the last flag : <br>
                    for HTB machines enter the <b>md5sum</b><br>
                    of the <b>root hash</b> at /etc/shadow :
                </p>
                <input type="text" id="conn_wp">
                ${access_denied}
                <input type="submit" onclick="display_article(${id},document.querySelector('#conn_wp').value)">
            </div>`;
        } else {
            wp = data[0]
            main.innerHTML =
            `<button id="back_writeups" onclick="back_articles()">back</button>
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

const search_article = () => {
    if (search_bar.value.length == 0) {
        get_articles();
    } else {
        main.classList.remove('full');
        search_bar.classList.remove('hide');
        fetch(`api.php?action=display&search=${search_bar.value}`)
        .then(res => res.json())
        .then(data => {
            main.innerHTML = "";
            data.forEach(wp => {
                var tags = '';
                wp['tags'].split(',').forEach(tag => tags+=`<span tag="${tag}">${tag}</span>`)
                main.innerHTML +=
                `<div class="writeup" onclick="article_set_page(${wp['id']})">
                    <div>
                        <h2>${wp['title']}</h2>
                        <div class="tags">${tags}</div>
                        <img class="banner" src="${wp['banner']}" alt="banner">
                        <small class="date">${wp['date']}</small>
                    </div>
                </div>`;
            });
        })
    }
}

const back_articles = () => {
    history.pushState(null, null, `?page=writeups`);
    if (search_bar.value) {
        search_article(search_bar.value)
    } else {
        get_articles();
    }
}

const article_set_page = (id) => {
    history.pushState( { 
        wp: id, 
    }, null, `?page=writeups&wp=${id}`);
    display_article(id,'')
}

const state_handler = (e) => {
    let params = (new URL(document.location)).searchParams;
    if (e.state || params.get('wp')) {
        e.state ? wp = e.state['wp'] : wp = null;
        display_article(wp || params.get('wp'),'')
    }
    else {
        if (search_bar.value) {
            search_article(search_bar.value)
        } else {
            get_articles();
        }
    }
}

window.addEventListener('popstate', (e) => state_handler(e));
window.onload = state_handler;
search_bar.addEventListener('input', search_article)