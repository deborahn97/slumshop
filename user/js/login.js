function rememberMe() {
    var email = document.forms["loginform"]["idemail"].value;
    var pass = document.forms["loginform"]["idpass"].value;
    var rememberme = document.forms["loginform"]["idremember"].checked;

    // console.log("Form data:" + rememberme + "," + email + "," + pass); // for debugging

    if (!rememberme) {
        setCookies("cemail", "", 0);
        setCookies("cpass", "", 0);
        setCookies("crem", false, 0);

        document.forms["loginform"]["idemail"].value = "";
        document.forms["loginform"]["idpass"].value = "";
        document.forms["loginform"]["idremember"].checked = false;

        alert("Credentials removed");
    } else {
        if (email == "" || pass == "") {
            document.forms["loginform"]["idremember"].checked = false;

            alert("Please enter your credentials");
            return false;
        } else {
            setCookies("cemail", email, 30);
            setCookies("cpass", pass, 30);
            setCookies("crem", rememberme, 30);

            alert("Credentials stored success");
        }
    }
}

function setCookies(cookiename, cookiedata, exdays) {
    var d = new Date();
    d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));

    var expires = "expires=" + d.toUTCString();
    document.cookie = cookiename + "=" + cookiedata + ";" + expires + ";path=/";
}

function getCookie(cname) {
    var name = cname + "=";
    var decodedCookie = decodeURIComponent(document.cookie);
    var ca = decodedCookie.split(';');

    for (var i = 0; i < ca.length; i++) {
        var c = ca[i];

        while (c.charAt(0) == ' ') {
            c = c.substring(1);
        }

        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }
    return "";
}

function loadCookies() {
    var username = getCookie("cemail");
    var password = getCookie("cpass");
    var rememberme = getCookie("crem");

    // console.log("COOKIES:" + username, password, rememberme);

    document.forms["loginForm"]["idemail"].value = username;
    document.forms["loginForm"]["idpass"].value = password;
    
    if (rememberme) {
        document.forms["loginForm"]["idremember"].checked = true;
    } else {
        document.forms["loginForm"]["idremember"].checked = false;
    }
}

function deleteCookie(cname) {
    const d = new Date();
    d.setTime(d.getTime() + (24 * 60 * 60 * 1000));
    let expires = "expires=" + d.toUTCString();

    document.cookie = cname + "=;" + expires + ";path=/";
}
    
function acceptCookieConsent() {
    deleteCookie('user_cookie_consent');
    setCookies('user_cookie_consent', 1, 30);
    document.getElementById("cookieNotice").style.display = "none";
}
