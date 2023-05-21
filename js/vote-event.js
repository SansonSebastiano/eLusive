function vote(animal, voteType) {
    let xmlhttp = new XMLHttpRequest();
    let btnUpvote = document.getElementById("btn-exist");
    let btnDownvote = document.getElementById("btn-non-exist");

    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            if(voteType == 'upvote'){
                document.getElementById("exist-votes").innerHTML = this.responseText;
                btnUpvote.disabled = true;
                btnDownvote.disabled = true;

                alert("Grazie per aver votato!");
            } else {    // voteType = 'downvote'
                document.getElementById("non-exist-votes").innerHTML = this.responseText;
                btnUpvote.disabled = true;
                btnDownvote.disabled = true;    

                alert("Grazie per aver votato!");
            }
            window.location.reload();
        }
    };

    xmlhttp.open("GET", "../vote-event.php?animale=" + animal + "&voteType=" + voteType, true);
    xmlhttp.send();
}