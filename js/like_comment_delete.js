function submitlike(id)
{
    var request = new XMLHttpRequest();
    var url = "../functions/like.php";
    request.open("POST", url, true);
    request.setRequestHeader("Content-Type", "application/json");
    request.onreadystatechange = function () {
        if (request.readyState === 4 && request.status === 200) {
            var jsonData = JSON.parse(request.response);
            var like = document.getElementById("p" + id);
            if (jsonData <= 1) {
                var text = " like";
            }
            else {
                var text = " likes";
            }
            like.innerHTML = jsonData + text;
            // console.log(jsonData); //debug
        }
    };
    var img_path =  id;
    var username = document.getElementById("username").value;
    var data = JSON.stringify({"img_path": img_path, "username": username});
    request.send(data);
}

function submitcomment(id)
{
    var request = new XMLHttpRequest();
    var url = "../functions/comment.php";
    request.open("POST", url, true);
    request.setRequestHeader("Content-Type", "application/json");
    request.onreadystatechange = function () {
        if (request.readyState === 4 && request.status === 200) {
            var jsonData = JSON.parse(request.response);
            var i = 1;
            var end = Object.keys(jsonData).length;
            
            var commentsId = "comments" + id;
            var comments_list = document.getElementById(commentsId);
            comments_list.innerHTML = '';
            while (end >= i)
            {   
                var comm = document.createElement('p');
                comm.innerHTML = `<strong>`+ jsonData[end]['username'] + `</strong> ` + jsonData[end]['comment'];
                comments_list.appendChild(comm);
                end--;
            }
        }
    };
    var img_path =  id;
    var commentId = "comment" + id;
    var username = document.getElementById("username").value;
    var comment = document.getElementById(commentId).value;
    document.getElementById(commentId).value = '';
    var data = JSON.stringify({"img_path": img_path, "username": username, "comment": comment});
    request.send(data);
}

function deletepost(id)
{
    var request = new XMLHttpRequest();
    var url = "../functions/deletepost.php";
    request.open("POST", url, true);
    request.setRequestHeader("Content-Type", "application/json");
    request.onreadystatechange = function () {
        window.location.href = "../";
    };
    var img_path =  id;
    var username = document.getElementById("username").value;
    var data = JSON.stringify({"img_path": img_path, "username": username});
    request.send(data);
}