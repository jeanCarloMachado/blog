var config = {
    backendUrl: "http://blog-backend"
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
    xmlhttp.send("ajaxACK=%7B%22action%22%3A%22loadItens%22%2C%22itensCount%22%3A0%2C+\"itensPerPage\"%3A+5%7D");

    data = JSON.parse(xmlhttp.responseText);
    var posts = data.grupo;
    var postsList = document.getElementById("posts-list");
    for(i = 0; i < posts.length; i++) {
        var li = document.createElement('li');
        var article = document.createElement('article');
        var header = document.createElement('header');
        var h1 = document.createElement('h1');
        var a = document.createElement('a');
        var title = document.createTextNode(posts[i].titulo);
        var date = document.createTextNode(posts[i].data);
        var div = document.createElement('div');
        var content = document.createTextNode(posts[i].conteudo);

        a.class = 'link-posts';
        a.id = posts[i].id;

        a.onclick = function() {
            hideAllViewPorts();
            window.currentPost = this.id;
            loadViewPort('post');
        };

        header.appendChild(h1);
        header.appendChild(date);
        h1.appendChild(a);
        a.appendChild(title);
        article.appendChild(header);
        article.appendChild(div);
        div.appendChild(content);
        li.appendChild(article);
        postsList.appendChild(li);
    }
});


addEventListener('load-post', function (e) {
    xmlhttp= new XMLHttpRequest();
    xmlhttp.open("POST", config.backendUrl+"/post/json/"+window.currentPost, false);
    xmlhttp.send();
    data = JSON.parse(xmlhttp.responseText);
    var title = document.createTextNode(data.row.vars.titulo.bruteValue);
    var content = document.createTextNode(data.row.vars.conteudo.bruteValue);
    var date = document.createTextNode(data.row.vars.data.bruteValue);

    var postViewPort = document.getElementById("post");
    var article = postViewPort.children[0];
    console.log(article);
    var header = document.createElement('header');
    var h1 = document.createElement('h1');
    var div = document.createElement('div');

    h1.appendChild(title);
    header.appendChild(h1);
    header.appendChild(date);
    div.appendChild(content);
    article.html = '';
    article.appendChild(header);
    article.appendChild(div);
});
