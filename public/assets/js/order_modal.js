const order = {
  modal: document.querySelector(".order-modal"),
  closeModal: function (e) {
    order.modal.style.display = "none";
    document.body.classList.remove("modal-open");
    e.target.parentElement.parentElement.parentElement.parentElement.firstChild.remove();
  },
  show: function (id) {
    let obj = {};
    obj.data_type = "order";
    obj.id = id;

    this.send_data(obj);
  },
  close: function (event) {},
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

    ajax.open("post", ROOT + "/orders");
    ajax.send(myForm);
  },
  handle_result: function (data) {
    //console.log(data);
    let obj = JSON.parse(data);

    if (typeof obj == "object") {
      let myDiv = document.createElement("div");
      myDiv.classList.add("order-modal-content");
      myDiv.innerHTML = this.orderHtml(obj);

      this.modal.appendChild(myDiv);

      //open the modal
      this.modal.style.display = "block";
      document.body.classList.add("modal-open");
    }
  },
  orderHtml: function (data) {
    console.log(data);
    return `
    <div class="modal-heading">
      <h2>Vaše objednávka #${data.row[0].id}</h2>
      <span onclick="order.closeModal(event)" class="close-modal close-modal-order"><i class='bx bx-window-close'></i></span>
    </div>
    <div class="order-wrapper">
      <div class="info">
        <h4>Informace o objednávce</h4>
        <div class="row-holder">
          <label>Jméno:</label>
          <span class="name">${data.row[0].firstname} ${
      data.row[0].lastname
    }</span>
        </div>
        <div class="row-holder">
          <label>Email:</label>
          <span class="email">${data.row[0].email}</span>
        </div>
        <div class="row-holder">
          <label>Vytvořeno:</label>
          <span class="date">${data.row[0].order_date}</span>
        </div>
        <div class="row-holder">
          <label>Adresa:</label>
          <span class="address">${data.row_address[0].street}<br> ${
      data.row_address[0].town
    } <br> ${data.row_address[0].country} <br> ${
      data.row_address[0].postcode
    }</span>
        </div>
        <div class="row-holder">
          <label>Status:</label>
          <span class="status">${data.row[0].status}</span>
        </div>
      </div>
      <div class="products">
        <h4>Produkty v objednávce</h4>
        <table>
          <thead>
            <th>Název</th>
            <th>Ketegorie</th>
            <th>Množství</th>
            <th>Cena</th>
          </thead>
          <tbody>

            ${this.getRows(data.row)}
  
            <tr>
              <td></td>
              <td></td>
              <td><b>Celkem:</b></td>
              <td><b>${data.row[0].order_amount} Kč</b></td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>    
    `;
  },
  getRows: function (rows) {
    let retrunString = "";
    rows.forEach((el) => {
      retrunString += `
      <tr>
        <td>${el.name}</td>
        <td>${el.category}</td>
        <td>${el.quantity}</td>
        <td>${el.product_price}</td>
      </tr>
      `;
    });
    return retrunString;
  },
};
