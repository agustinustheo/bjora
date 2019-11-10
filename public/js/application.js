setInterval(function(){
    var date = new Date();
    var dd = String(date.getDate()).padStart(2, '0');
    var mm = String(date.getMonth() + 1).padStart(2, '0'); //January is 0!
    var yyyy = date.getFullYear();
    var seconds = String(date.getSeconds()).padStart(2, '0');
    var minutes = String(date.getMinutes()).padStart(2, '0');
    var hour = String(date.getHours()).padStart(2, '0');
    today = yyyy + '-' + mm + '-' + dd + " " + hour + ":" + minutes + ":" + seconds;
    $('#time').text(today);
}, 1000);