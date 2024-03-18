let signupInputRecaptcha = document.querySelector("#g-token-signup");
let contactInputRecaptcha = document.querySelector("#g-token-contact");

if (signupInputRecaptcha != undefined) {
  grecaptcha.enterprise.ready(function () {
    grecaptcha.enterprise
      .execute("6LdYCzskAAAAALuIgvdKnsQxDcZxYKT9wOFwphRV", {
        action: "signup",
      })
      .then(function (token) {
        signupInputRecaptcha.value = token;
      });
  });
}

if (contactInputRecaptcha != undefined) {
  grecaptcha.enterprise.ready(function () {
    grecaptcha.enterprise
      .execute("6LdYCzskAAAAALuIgvdKnsQxDcZxYKT9wOFwphRV", {
        action: "contact",
      })
      .then(function (token) {
        contactInputRecaptcha.value = token;
      });
  });
}
