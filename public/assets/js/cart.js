const alerts = document.querySelector(".alerts");

var cart = {
  indexOfItemsInCart: document.querySelector(".links .cart-items") ?? null,

  add: function (id, e = null) {
    let obj = {};

    obj.data_type = "add";
    obj.id = id;

    if(e != null) {
      obj.qty = e.target.parentElement.previousElementSibling.querySelector("input").value;
    }

    let items = localStorage.getItem("items");
    let arr = JSON.parse(items) ?? [];

    if (arr.length == 0) {
      arr.push(id);
      localStorage.setItem("items", JSON.stringify(arr));
      this.setIndexOfCart(this.getIndexOfCart(), "add");
    } else {
      let result = arr.find((element) => element === id);
      if (!result) {
        arr.push(id);
        localStorage.setItem("items", JSON.stringify(arr));
        this.setIndexOfCart(this.getIndexOfCart(), "add");
      }
    }

    this.send_data(obj);
  },

  remove: function (id) {
    let obj = {};

    obj.data_type = "remove";
    obj.id = id;

    let items = JSON.parse(localStorage.getItem("items"));
    for (var i = 0; i < items.length; i++) {
      if (items[i] === id) {
        items.splice(i, 1);
        i--;
      }
    }
    localStorage.setItem("items", JSON.stringify(items));

    this.setIndexOfCart(this.getIndexOfCart(), "remove");

    this.send_data(obj);
  },

  remove_all: function () {
    let obj = {};

    obj.data_type = "remove_all";
    this.setIndexOfCart(0);
    this.send_data(obj);
  },

  changeQty: function (id, e) {
    let value = parseInt(e.value) ?? 0;

    if (value < 1) {
      value = 1;
    }

    let obj = {};

    obj.data_type = "change_qty";
    obj.id = id;
    obj.value = value;

    this.send_data(obj);
  },

  send_data: function (obj) {
    let ajax = new XMLHttpRequest();
    let myForm = new FormData();

    for (const key in obj) {
      myForm.append(key, obj[key]);
    }

    ajax.addEventListener("readystatechange", () => {
      if (ajax.readyState == 4) {
        if (ajax.status == 200) {
          this.handle_result(ajax.responseText);
        }
      }
    });

    ajax.open("post", ROOT + "/cart/handle_data");
    ajax.send(myForm);
  },

  handle_result: function (data) {
    if (data.substr(0, 2) == '{"') {
      let obj = JSON.parse(data);
      //console.log(data);

      if (typeof obj == "object") {
        let action = obj.action;
        obj.message.length > 0 ? alert(obj.message) : "";
        if (action == "reload") {
          window.location.reload();
        } else if (action == "add") {
          //console.log("ADDDING");
          showAlert();
        } else if (action == "cart") {
          if (obj.data == false) {
            this.setIndexOfCart(0);
          }
        }
      }
    }
  },

  setIndexOfCart: function (index, action = "") {
    if (action == "add") {
      let number = parseInt(index) + 1;
      localStorage.setItem("indexOfItems", JSON.stringify(number));
    } else if (action == "remove") {
      let number = parseInt(index) - 1 > 1 ? parseInt(index) - 1 : 0;
      localStorage.setItem("indexOfItems", JSON.stringify(number));
    } else {
      localStorage.setItem("indexOfItems", JSON.stringify(0));
      localStorage.setItem("items", JSON.stringify([]));
    }
    this.updateCartIndex();
  },

  updateCartIndex: function () {
    this.indexOfItemsInCart.innerHTML = this.getIndexOfCart();
  },

  getIndexOfCart: function () {
    return localStorage.getItem("indexOfItems") ?? 0;
  },

  isCartPresent: function () {
    let obj = {};

    obj.data_type = "get_cart";

    this.send_data(obj);
  },
};

cart.isCartPresent();

cart.updateCartIndex();

// CODE FOR ALERTS

function showAlert() {
  let myAlert = document.createElement("div");
  myAlert.classList.add("pop-up-alert");
  myAlert.classList.add("show");

  myAlert.innerHTML = `
          <span><i class="bx bx-check-circle"></i></span>
          <span>Položka byla přidána.</span>
          <span class="close-alert" onclick="closeAlert(this)"><i class="bx bx-x"></i></span>
        `;

  alerts.append(myAlert);
  setInterval(() => {
    myAlert.remove();
  }, 5000);
}

function closeAlert(e) {
  e.parentElement.remove();
}
