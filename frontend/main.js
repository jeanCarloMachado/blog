window.loadedPosts = 0;

var config = {
    backendUrl: "http://backend.jeancarlomachado.com.br",
    frontendUrl: "http://jeancarlomachado.com.br",
    //backendUrl: "http://backend.blog",
    //frontendUrl: "http://blog",
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
    if (viewPortId != 'post') {
        window.currentId = null;
    }

    var elements = document.getElementsByClassName("view-port");
    for (i = 0; i < elements.length; i++) {
        if (elements[i].id == viewPortId) {
            elements[i].style.display = "block";
        }
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
}

hideAllViewPorts();

document.getElementById("link-about").onclick = function () {
    hideAllViewPorts();
    loadViewPort('about');
};

function attachButtonsListeners()
{
    elements = document.getElementsByClassName("link-posts")

    for (i = 0; i < elements.length; i++) {
        attachBackAction(elements[i]);
    }
}

function attachBackAction(element)
{
    element.onclick = function () {
        hideAllViewPorts();
        loadViewPort('posts');
    };
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
}


addEventListener('load-posts', function (e) {
    xmlhttp= new XMLHttpRequest();
    var uri = "/posts?resume=1&firstResult="
    +window.loadedPosts+"&maxResults="+config.itensPerPage;

    xmlhttp.open("GET", config.backendUrl+uri, false);
    xmlhttp.send();

    var posts= JSON.parse(xmlhttp.responseText);

    if (posts.length == 0) {
        window.noMorePosts = true;
    }
    var postsList = document.getElementById("posts");

    for (i = 0; i < posts.length; i++) {
        var article = createArticle(
            posts[i].id,    
            posts[i].titulo,
            posts[i].conteudo,
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

    postViewPort.insertBefore(article ,postViewPort.firstChild);
    window.scrollTo(0, 0);

    var config = {
        'identifier': 'jeancarlomachado',
        'title': document.title,
        'url': window.location.href,
        'shortname': 'jeancarlomachado'
    };
    enableDisqus(config);
});

function alterMetadataFromArticle(data) {
    document.title = data.titulo;
    var metas = document.getElementsByTagName("meta");
    for (var i=0; i< metas.length;i++) {
        console.log(metas[i].name);
        if (metas[i].name == 'Description') {
            metas[i].content = data.description;
        }
        if (metas[i].name == 'Keywords') {
            metas[i].content = data.keywords;
        }
    }
}

addEventListener('load-about', function (e) {
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
        window.currentViewPort == 'posts'
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
        var span = document.createElement('span');
        var date = document.createTextNode(Date.parse(date).toDateString());
        span.appendChild(date);
        span.className = 'article-date';
        header.appendChild(span);
    }

    var a = document.createElement('a');

    a.id = id;
    a.onclick = function () {
        hideAllViewPorts();
        window.currentId = this.id;
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


function enableDisqus(config) { 
  if (enableDisqus.loaded) {
    DISQUS.reset({
      reload: true,
      config: function () {  
        this.page.identifier = config.identifier;
        this.page.url        = config.url;
        this.page.title      = config.title;
      }
    });
  } else {
    var body = "var disqus_shortname  = \"" + config.shortname  + "\";\n" + 
               "var disqus_title      = \"" + config.title      + "\";\n" + 
               "var disqus_identifier = \"" + config.identifier + "\";\n" +
               "var disqus_url        = \"" + config.url        + "\";\n";
    if (config.developer) {
      body +=  "var disqus_developer  = 1;\n"
    }
    appendScriptTagWithBody(body);
 
    (function() {
      var dsq = document.createElement('script'); dsq.type = 'text/javascript'; dsq.async = true;
      dsq.src = 'http://' + disqus_shortname + '.disqus.com/embed.js';
      (document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(dsq);
    })();
 
    enableDisqus.loaded = true;
  }
}
 
function appendScriptTagWithBody(body) {
  var dso   = document.createElement("script");
  dso.type  = "text/javascript";
  dso.async = true;
  dso.text  = body;
  console.log(body);
  document.getElementsByTagName('body')[0].appendChild(dso);
}



