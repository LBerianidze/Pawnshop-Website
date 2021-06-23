function forgetPass() {
    let loginField = document.querySelectorAll(".input-login");
    let emailField = document.querySelectorAll(".input-email");

    for (let i = 0; i < loginField.length; i++) {
        let inputField = loginField[i];
        inputField.style.display = "none";
        inputField.lastElementChild.removeAttribute('required');
    }

    for (let i = 0; i < emailField.length; i++) {
        let inputField = emailField[i];
        inputField.style.display = "flex";
        inputField.lastElementChild.setAttribute('required','');
    }

    let forgetLink = document.querySelector("#forgetLink");
    forgetLink.style.display = "none";

    let rememberLink = document.querySelector("#rememberLink");
    rememberLink.style.display = "inline-block";

    let formButton = document.querySelector("#forgetButton");
    formButton.textContent = "Выслать пароль";
    formButton.style.margin = "0";
    document.getElementById('action').value = '2';
}

function rememberPass() {
    let loginField = document.querySelectorAll(".input-login");
    let emailField = document.querySelectorAll(".input-email");

    for (let i = 0; i < loginField.length; i++) {
        let inputField = loginField[i];
        inputField.style.display = "flex";
        inputField.lastElementChild.setAttribute('required','');
    }

    for (let i = 0; i < emailField.length; i++) {
        let inputField = emailField[i];
        inputField.style.display = "none";
        inputField.lastElementChild.removeAttribute('required');
        inputField.lastElementChild.value = '';
    }

    let forgetLink = document.querySelector("#forgetLink");
    forgetLink.style.display = "inline-block";

    let rememberLink = document.querySelector("#rememberLink");
    rememberLink.style.display = "none";

    let formButton = document.querySelector("#forgetButton");
    formButton.textContent = "Войти";
    formButton.style.marginTop = "45px";

    document.getElementById('action').value = '1';
}
window.onload = (function ()
{
document.getElementsByName('accept')[0].setAttribute("checked", "true");
});