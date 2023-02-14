function isEmailValid(emailAddress) {
    var email = document.createElement("input");
    email.type = "email";
    email.value = emailAddress;
    return emailAddress != "" && email.checkValidity();
}