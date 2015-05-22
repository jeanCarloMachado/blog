window.loadedPosts = 0;

var config = {
    backendUrl: "http://jeancarlomachado.com.br",
    itensPerPage: 10
}

function hideAllViewPorts() {
    var elements = document.getElementsByClassName("view-port");
    for (i = 0; i < elements.length; i++) {
        elements[i].style.display = "none";
    }
}

function loadViewPort(id) {

    var elements = document.getElementsByClassName("view-port");
    for (i = 0; i < elements.length; i++) {
        if (elements[i].id == id) {
            elements[i].style.display = "block";
        }
    }

    window.currentViewPort = id;
    var event = new Event('load-'+id);
    dispatchEvent(event);
}

hideAllViewPorts();
loadViewPort('loading');

document.getElementById("link-about").onclick = function() {
    hideAllViewPorts();
    loadViewPort('about');
};

elements = document.getElementsByClassName("link-posts")
for (i = 0; i < elements.length; i++) {
    elements[i].onclick = function() {
        hideAllViewPorts();
        loadViewPort('posts');
    };
}

document.getElementById("link-feed").href = config.backendUrl + '/feed';


window.onload = function () {
    hideAllViewPorts();
    loadViewPort('posts');
}


addEventListener('load-posts', function (e) {
    xmlhttp= new XMLHttpRequest();
    xmlhttp.open("POST", config.backendUrl+"/posts/routerAjax", false);
    xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
    xmlhttp.send(
    "ajaxACK=%7B%22publicado%22%3A%221%22%2C%22order%22%3A%22data DESC%22%2C%22visivel%22%3A%221%22%2C%22action%22%3A%22loadItens%22%2C%22itensCount%22%3A"+window.loadedPosts+"%2C+\"itensPerPage\"%3A+"+config.itensPerPage+"%7D"
    );

    data = JSON.parse(xmlhttp.responseText);
    var posts = data.grupo;
    if (posts.length == 0){
        window.noMorePosts = true;
    }
    var postsList = document.getElementById("posts-list");

    for(i = 0; i < posts.length; i++) {
        var li = document.createElement('li');
        var article = document.createElement('article');
        var header = document.createElement('header');
        var h1 = document.createElement('h1');
        var a = document.createElement('a');
        var div = document.createElement('div');

        var title = document.createTextNode(posts[i].titulo);
        header.appendChild(h1);

        if (posts[i].data && posts[i].data != '0000-00-00 00:00:00') {
            var date = document.createTextNode(Date.parse(posts[i].data).toDateString());
            header.appendChild(date);
        }


        var content = document.createTextNode(posts[i].conteudo);

        a.id = posts[i].id;

        a.onclick = function() {
            hideAllViewPorts();
            window.currentPost = this.id;
            loadViewPort('post');
        };

        h1.appendChild(a);
        h1.className = 'post-title';
        a.appendChild(title);
        article.appendChild(header);
        article.appendChild(div);
        div.appendChild(content);
        li.appendChild(article);
        postsList.appendChild(li);
    }
});


addEventListener('load-post', function (e) {
    var data = getPostDataById(window.currentPost);
    var postViewPort = document.getElementById("post");
    createArticleFromPostData(data, postViewPort);
});


addEventListener('load-about', function (e) {
    var data = getPostDataById(2);
    var postViewPort = document.getElementById("about");

    createArticleFromPostData(data, postViewPort);
});


window.onscroll = function() {

    if (atBottom()
        && !window.scroll.lock
        && !window.noMorePosts
        && window.currentViewPort == 'posts'
        ) {
        window.scroll.lock = true;
        window.loadedPosts+=config.itensPerPage;
        var event = new Event('load-posts');
        dispatchEvent(event);
        window.scroll.lock = false;
    }
}

function createArticleFromPostData(data, container) {

    var header = document.createElement('header');
    var h1 = document.createElement('h1');
    var div = document.createElement('div');

    var title = document.createTextNode(data.row.vars.titulo.bruteValue);
    var content = data.row.vars.conteudo.bruteValue;

    header.appendChild(h1);

    if (data.row.vars.data.bruteValue && data.row.vars.data.bruteValue != '0000-00-00 00:00:00') {
        var date = document.createTextNode(Date.parse(data.row.vars.data.bruteValue).toDateString());
        header.appendChild(date);
    }

    var article = container.children[0];

    while (article.firstChild) {
        article.removeChild(article.firstChild);
    }


    h1.appendChild(title);
    h1.className = 'post-title';
    div.innerHTML = content;
    article.appendChild(header);
    article.appendChild(div);
}

function getPostDataById(id) {
    xmlhttp= new XMLHttpRequest();
    xmlhttp.open("POST", config.backendUrl+"/post/json/"+id, false);
    xmlhttp.setRequestHeader("Accept","text/markdown;level=100");
    xmlhttp.send();
    return JSON.parse(xmlhttp.responseText);
}

function atBottom() {
    var totalHeight, currentScroll, visibleHeight;

    if (document.documentElement.scrollTop) {
        currentScroll = document.documentElement.scrollTop;
    } else {
        currentScroll = document.body.scrollTop;
    }

    totalHeight = document.body.offsetHeight;
    visibleHeight = document.documentElement.clientHeight;
    if (totalHeight <= currentScroll + visibleHeight ) {
        return true;
    }

    return false;
}
