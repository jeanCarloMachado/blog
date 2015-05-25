window.loadedPosts = 0;

var config = {
    backendUrl: "http://backend.blog",
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

function attachButtonsListeners() {
    elements = document.getElementsByClassName("link-posts")
    for (i = 0; i < elements.length; i++) {
        attachBackAction(elements[i]);
    }
}

function attachBackAction(element) {
    element.onclick = function() {
        hideAllViewPorts();
        loadViewPort('posts');
    };
}

attachButtonsListeners();

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
    var postsList = document.getElementById("posts");

    for(i = 0; i < posts.length; i++) {
        var article = createArticle(posts[i].id, posts[i].titulo, posts[i].conteudo, posts[i].data);
        postsList.appendChild(article);
    }
});


addEventListener('load-post', function (e) {
    var data = getPostDataById(window.currentPost);
    var postViewPort = document.getElementById("post");
    var article = createArticleFromPostData(data, postViewPort);

    while (postViewPort.hasChildNodes()) {
        postViewPort.removeChild(postViewPort.lastChild);
    }

    postViewPort.appendChild(article);
    postViewPort.appendChild(createBackButton());
});


addEventListener('load-about', function (e) {
    var data = getPostDataById(2);
    var postViewPort = document.getElementById("about");
    var article = createArticleFromPostData(data, postViewPort);

    while (postViewPort.hasChildNodes()) {
        postViewPort.removeChild(postViewPort.lastChild);
    }

    postViewPort.appendChild(article);
    postViewPort.appendChild(createBackButton());
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

function createArticle(id, title, content, date) {
    var article = document.createElement('article');
    var header = document.createElement('header');
    var h1 = document.createElement('h1');
    var div = document.createElement('div');
    var title = document.createTextNode(title);


    header.appendChild(h1);
    if (date && date != '0000-00-00 00:00:00') {
        var span = document.createElement('span');
        var date = document.createTextNode(Date.parse(date).toDateString());
        span.appendChild(date);
        header.appendChild(span);
    }

    var a = document.createElement('a');

    a.id = id;
    a.onclick = function() {
        hideAllViewPorts();
        window.currentPost = this.id;
        loadViewPort('post');
    };

    a.appendChild(title);
    h1.appendChild(a);



    while (article.firstChild) {
        article.removeChild(article.firstChild);
    }

    div.innerHTML = content;
    article.appendChild(header);
    article.appendChild(div);

    return article;
}

function createArticleFromPostData(data, container) {
    return createArticle(
        data.row.vars.id.bruteValue,
        data.row.vars.titulo.bruteValue,
        data.row.vars.conteudo.bruteValue,
        data.row.vars.data.bruteValue
    );
}

function getPostDataById(id) {
    xmlhttp= new XMLHttpRequest();
    xmlhttp.open("POST", config.backendUrl+"/post/json/"+id, false);
    xmlhttp.setRequestHeader("Accept","text/markdown;level=100");
    xmlhttp.send();
    return JSON.parse(xmlhttp.responseText);
}

function createBackButton() {
    var a = document.createElement('a');
    a.appendChild(document.createTextNode('Back'))
    a.class = 'link-posts';
    attachBackAction(a);
    a.href = 'javascript:void(0);';

    return a;
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
