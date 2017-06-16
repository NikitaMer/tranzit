function GetEmail (s) {
    var code="";
    for (var k=0; k<s.length; k+=3) {
        code = String.fromCharCode(s.substring(k,k+3)) + code;
    }
    return code;
}

function Generate (mail) {

    if (mail=="") {
        window.alert ("Адрес E-mail пуст!");
        return;
    }
    /*
    if (!validEmail(mail)) {
        window.alert ("Адрес E-mail невалиден!");
        return;
    }
    */
    var result="",c;
    for (var k=0; k<mail.length; k++)
    {
        c=mail.charCodeAt(k);

        if (c<10)
            c="00"+c;
        else if (c<100)
            c="0"+c;

        result = c + result;
    }

    console.log(result);
}
