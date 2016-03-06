window.loadedPosts = 0;
hideAllViewPorts();

var config = {
    backendUrl: "BLOG_BACKEND_URL",
    frontendUrl: "BLOG_FRONTEND_URL",
    itensPerPage: 10
}

function hideAllViewPorts()
{
    var elements = document.getElementsByClassName("view-port");

    for (i = 0; i < elements.length; i++) {
        elements[i].style.display = "none";
    }
}

function loadViewPort(viewPortId)
{
    document.getElementById('loading').style.display = "block";
    if (viewPortId != 'post') {
        window.currentId = null;
    }

    window.currentViewPort = viewPortId;
    var event = new Event('load-'+viewPortId);
    dispatchEvent(event);

    url = '/#!/'+viewPortId;
    if (window.currentId) {
        url+= '/'+currentId;
    }

    window.history.pushState(
        {
            "html":document.html,
            "pageTitle":document.pageTitle
        },
        "",
        url
    );

    var event = new Event('viewport-rendered');
    dispatchEvent(event);


    document.getElementById('loading').style.display = "none";
    var viewPort = document.getElementById(viewPortId);
    viewPort.style.display = "block";
    blocks = document.querySelectorAll('pre code');
    var i;
    for (i = 0; i < blocks.length; i++) {
        hljs.highlightBlock(blocks[i]);
    }
}

window.addEventListener("hashchange", function(){
    location.reload();
})

document.getElementById("link-favourites").addEventListener('click', function () {
    hideAllViewPorts();
    window.currentId = 107;
    loadViewPort('post');
});

document.getElementById("link-about").addEventListener('click', function () {
    hideAllViewPorts();
    loadViewPort('about');
});


function attachButtonsListeners()
{
    elements = document.getElementsByClassName("link-posts")

    for (i = 0; i < elements.length; i++) {
        attachBackAction(elements[i]);
    }
}

function attachBackAction(element)
{
    element.addEventListener('click', function () {
        hideAllViewPorts();
        loadViewPort('posts');
    });
}

attachButtonsListeners();

document.getElementById("link-feed").href = config.backendUrl + '/feed';


window.onload = function () {
    hideAllViewPorts();

    var url = window.location.href;
    if (url.match(/post[^s]/)) {
        url =  url.split('/');
        var currentId = url[url.length - 1];
        if (isNaN(currentId)) {
            currentId = url[url.length - 2];
        }
        window.currentId = currentId;
        loadViewPort('post');
    } else if (url.match(/about/)) {
        loadViewPort('about');
    } else {
        loadViewPort('posts');
    }

    var search = document.getElementById("search");
    search.onkeyup= function () {
        if (this.value.length === 0) {
            hideAllViewPorts();
            loadViewPort('posts');
            return;
        }

        if (this.value.length > 2) {
            hideAllViewPorts();
            loadViewPort('search-result');
            window.blog = {};
            window.blog.searchTerm = this.value;
            return;
        }
    };
}


addEventListener('load-search-result', function (e) {
    xmlhttp= new XMLHttpRequest();
    var uri = "/posts?resume=1&search="+window.blog.searchTerm;

    xmlhttp.open("GET", config.backendUrl+uri, false);
    xmlhttp.send();

    var posts= JSON.parse(xmlhttp.responseText);

    var postsList = document.getElementById("search-result");

    while (postsList.childNodes.length > 1) {
        postsList.removeChild(postsList.lastChild);
    }

    if (posts.length) {
        for (i = 0; i < posts.length; i++) {
            var article = createArticle(
                posts[i].id,
                posts[i].titulo,
                posts[i].description,
                posts[i].data
            );
            postsList.appendChild(article);
        }
    } else {
        var message = document.createTextNode('No content found');
        var p = document.createElement('p');
        p.appendChild(message);
        postsList.appendChild(p);
    }
    document.getElmentById('link-posts').className+="visited";
});


addEventListener('load-posts', function (e) {
    xmlhttp= new XMLHttpRequest();
	//window.loadedPosts = 666;
    var uri = "/posts?resume=1&firstResult="
    +window.loadedPosts+"&maxResults="+config.itensPerPage;

    xmlhttp.open("GET", config.backendUrl+uri, false);
    xmlhttp.send();

    var posts= JSON.parse(xmlhttp.responseText);

    if (posts.length === 0) {
        window.noMorePosts = true;
    }
    var postsList = document.getElementById("posts");

    for (i = 0; i < posts.length; i++) {
        var article = createArticle(
            posts[i].id,
            posts[i].titulo,
            posts[i].description,
            posts[i].data
        );
        postsList.appendChild(article);
    }
    window.scroll.lock = false;
    window.loadedPosts+=config.itensPerPage;
});


addEventListener('load-post', function (e) {
    var data = getPostDataById(window.currentId);
    var postViewPort = document.getElementById("post");
    var article = createArticle(data.id, data.titulo, data.conteudo, data.data);
    article.className = 'currentPost';

    alterMetadataFromArticle(data);

    var currentPosts = document.getElementsByClassName('currentPost');
    while(currentPosts[0]) {
        currentPosts[0].parentNode.removeChild(currentPosts[0]);
    }

    postViewPort.insertBefore(article, postViewPort.firstChild);
    window.scrollTo(0, 0);
});

function alterMetadataFromArticle(data) {
    document.title = data.titulo;
    var metas = document.getElementsByTagName("meta");
    for (var i=0; i< metas.length;i++) {
        console.log(metas[i].name);
        if (metas[i].name === 'Description') {
            metas[i].content = data.description;
        }
        if (metas[i].name === 'Keywords') {
            metas[i].content = data.keywords;
        }
    }
}

addEventListener('load-about', function (e) {
    window.currentId = 2;
    if (window.aboutLoaded) {
        return;
    }

    var data = getPostDataById(2);
    var postViewPort = document.getElementById("about");
    var article = createArticle(data.id, data.titulo, data.conteudo, data.data);
    alterMetadataFromArticle(data);

    postViewPort.insertBefore(article ,postViewPort.firstChild);
    window.scrollTo(0, 0);

    return window.aboutLoaded = true;
});

window.onscroll = function () {
    if (
        window.currentViewPort === 'posts'
        && atBottom()
        && !window.scroll.lock
        && !window.noMorePosts
       ) {
        window.scroll.lock = true;
        var event = new Event('load-posts');
        dispatchEvent(event);
    }
}

function createArticle(id, title, content, date)
{
    var article = document.createElement('article');
    var header = document.createElement('header');
    var h1 = document.createElement('h1');
    var div = document.createElement('div');
    var title = document.createTextNode(title);

    h1.className = 'article-title';
    header.appendChild(h1);
    header.className ='article-header'

    if (date && date != '0000-00-00 00:00:00') {
        var time = document.createElement('time');
        time.className+="articleTime";
        var timeStr = document.createTextNode(Date.parse(date).toDateString());
        time.datetime=date.split(' ')[0];
        time.pubdate = "pubdate";

        time.appendChild(timeStr);
        header.appendChild(time);
    }

    var a = document.createElement('a');
    a.id = id;
    a.href = config.frontendUrl+'/#!/post/'+id;
    a.addEventListener("click", function () {
        if (window.currentId) {
            return;
        }

        hideAllViewPorts();
        window.currentId = this.id;
        loadViewPort('post');
    });

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


function getPostDataById(id)
{
    xmlhttp= new XMLHttpRequest();
    xmlhttp.open("POST", config.backendUrl+"/post/"+id, false);
    xmlhttp.send();

    return JSON.parse(xmlhttp.responseText)[0];
}

function atBottom()
{
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

