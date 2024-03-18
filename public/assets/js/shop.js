let dropdown = document.querySelector(".shop-dropdown");
let button = document.querySelector(".shop-dropdown > button");
let buttonDropdown = document.querySelector(".textbox");
let options = document.querySelectorAll(".option > a");

if (button != undefined) {
  button.onclick = function () {
    dropdown.classList.toggle("active");
  };

  if (window.innerWidth < 720) {
    dropdown.classList.toggle("active");
  }
}

var search = {
  searchBox: document.querySelector("#searchBox"),

  click: function (e) {
    e.value = "";
  },

  input: function (e) {
    let text = e.value.trim();
    let obj = {};

    obj.data_type = "search";
    obj.data = text;

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

    ajax.open("post", ROOT + "/shop");
    ajax.send(myForm);
  },

  handle_result: function (data) {
    let obj = JSON.parse(data);

    if (typeof obj == "object") {
      let myDiv = document.querySelector("#shop-products");
      myDiv.innerHTML = "";

      if (obj.data != "") {
        for (let i = 0; i < obj.data.length; i++) {
          myDiv.innerHTML += this.productHtml(obj.data[i]);
        }
      } else {
        let span = document.createElement("span");
        span.innerHTML = "Žádné produkty se nenašly!";
        myDiv.appendChild(span);
      }
    }
  },

  productHtml: function (data) {
    return `
        <!-- PRODUCT -->
            <div class="item">
              <a href="${ROOT}/product/${data.slug ?? ""}">
                <img src="${ROOT}/${data.product_image ?? ""}" alt="${
      data.name ?? ""
    }" class="photo" />
              </a>
              <div class="item-info">
                <div class="item-header">
                  <span class="category">${data.category ?? ""}</span>
                  <h4 class="title">${data.name ?? ""}</h4>
                </div>
                <div class="item-body">
                  <div class="price">${data.price ?? ""}</div>
                  <button type="button" class="item-btn" onclick="cart.add(${
                    data.id ?? ""
                  })">Add to cart</button>
                </div>
              </div>
            </div>
            <!-- END OF PRODUCT -->
    `;
  },
};
