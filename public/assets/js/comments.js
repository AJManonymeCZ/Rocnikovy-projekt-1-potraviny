const comments = {
    commentHolder: document.querySelector("#comments-holder"),
    textareaValue: null,
    currSubComment: null,
    currEditDiv: null,
    collectData: function (e, p_id = null, parent_id = null) {
        let obj = {};
        if(parent_id == null)  {
            const textarea = e.target.parentElement.previousElementSibling.querySelector("textarea");

            obj.data_type = 'create';
            obj.content = textarea.value;
            obj.product_id = p_id;

            textarea.value = '';
        } else {
            obj.product_id = p_id;
            obj.parent_id = parent_id;
            obj.data_type = 'get'
        }


        this.send_data(obj);
    },
    showComment: function (comment) {

        if(comment.parent_id) {
            let comments = document.querySelectorAll("#comments-holder .comment");

            comments.forEach((c) => {
               if(c.dataset.id == comment.parent_id) {
                   let currWidth = parseInt(c.style.width.replace("%", ''));
                   currWidth -= 3;

                   let div = document.createElement('div');
                   div.classList.add('comment')
                   div.dataset.id = comment.id
                   div.style.width = currWidth + "%";
                   div.innerHTML = this.createSubCommentHTML(comment);


                   this.commentHolder.insertBefore(div, c.nextElementSibling);
               }
            });


        } else {
            let div = document.createElement('div');
            div.style.width = "100%";
            div.innerHTML = this.commentHTML(comment);

            let p = this.commentHolder.querySelector("p");

            if(p)
                p.remove();

            this.commentHolder.insertBefore(div, this.commentHolder.children[0]);
        }
    },
    deleteComment: function (id) {
        const comments = document.querySelectorAll(".comments-container .comment")

        comments.forEach((c) => {
            if(c.dataset.id == id) {
                c.remove();
            }
        });

        let obj = {}
        obj.id = id;
        obj.data_type = 'delete';

        this.send_data(obj);
    },
    editComment: function (id) {
        const comments = document.querySelectorAll(".comments-container .comment")

        this.deleteCurrSubComment();
        this.deleteCurrEditDiv();

        if(this.textareaValue == null) {
            comments.forEach((c) => {
                if(c.dataset.id == id) {
                    const editDiv = document.createElement('div');
                    const textarea = document.createElement("textarea");
                    textarea.value = c.children[1].children[0].innerText;
                    textarea.style.margin = "10px 0";
                    textarea.style.width = '100%';
                    textarea.addEventListener("keyup", (e) => {
                        this.textareaValue = textarea.value;
                    });

                    const div = document.createElement("div");
                    div.classList.add("add-comment");
                    div.innerHTML = `<button onclick="comments.editComment(${id})">Editovat komentář</button>`;

                    editDiv.appendChild(textarea);
                    editDiv.appendChild(div);

                    c.children[1].appendChild(editDiv);

                    this.currEditDiv = editDiv;
                }
            });
        } else {

            //send edit form
            let obj = {}
            obj.id = id;
            obj.content = this.textareaValue;
            obj.data_type = 'edit';
            //TODO: fuction to validate comment (backend is done)
            //show the edited comment
            comments.forEach((c) => {
                if(c.dataset.id == id) {
                    Array.from(c.children[1].children).forEach(el =>{
                        el.remove();
                    });

                    const p = document.createElement("p");
                    p.innerText = this.textareaValue;

                    c.children[1].appendChild(p);
                }
            });

            this.textareaValue = null;
            this.currEditDiv = null;
            this.send_data(obj);

        }
    },
    createSubComment: function (me) {
        const comments = document.querySelectorAll(".comments-container .comment");

        this.deleteCurrSubComment();
        this.deleteCurrEditDiv();

        comments.forEach((c) => {
           if(c.dataset.id == me.p_id) {
               const newDiv = document.createElement('div');
               newDiv.style.width = '100%'
               newDiv.innerHTML = this.commentHTML(null, me);

               const textarea = newDiv.querySelector("textarea");
               const button = newDiv.querySelector("button");



               if(c.nextElementSibling) {
                   console.log(c.nextElementSibling);
                    this.commentHolder.insertBefore(newDiv, c.nextElementSibling);
               }
               else {
                   this.commentHolder.appendChild(newDiv);
               }

               this.currSubComment = newDiv;

               button.onclick = () => {
                   let obj = {};

                   obj.data_type = 'create';
                   obj.content = textarea.value;
                   obj.parent_id = me.p_id;
                   obj.product_id = me.product_id;

                    this.send_data(obj);
                   this.deleteCurrSubComment();
               }
           }
        });
    },
    createSubCommentHTML: function (comment) {
        return `
                  <div class="header">
                      <div class="img-holder">
                          <img src="${ROOT + "/" + comment.image}" alt="">
                      </div>
                      <div class="user-details">
                          <p>${comment.fullname}</p>
                          <span>teď</span>
                      </div>
                      <div class="actions">                                   
                            <div class="edit-delete">
                                <span onclick="comments.editComment(${comment.id})"><i class='bx bx-edit-alt'></i></span>
                                <span onclick="comments.deleteComment(${comment.id})"><i class='bx bx-message-alt-x' ></i></span>
                            </div>
                    
                        <div class="replay-to"><span onclick="comments.collectData(event, ${comment.product_id}, ${comment.id})" ><br> <i class='bx bx-share'></i></span></div>
                    </div>
                  </div>
                  <div class="content">
                      <p>${comment.content}</p>
                  </div>
           
        `
    },
    deleteCurrSubComment: function () {
        if(this.currSubComment)
            this.currSubComment.remove();
    },
    deleteCurrEditDiv: function () {
        if(this.currEditDiv) {
            this.currEditDiv.remove();
        }
    },
    commentHTML: function (comment = null, user = null) {
        if(comment) {
            console.log(comment);
            return `
                  <div class="header">
                      <div class="img-holder">
                          <img src="${ROOT + "/" + comment.image}" alt="">
                      </div>
                      <div class="user-details">
                          <p>${comment.fullname}</p>
                          <span>teď</span>
                      </div>
                      <div class="actions">                                   
                            <div class="edit-delete">
                                <span onclick="comments.editComment(${comment.id})"><i class='bx bx-edit-alt'></i></span>
                                <span onclick="comments.deleteComment(${comment.id})"><i class='bx bx-message-alt-x' ></i></span>
                            </div>
                    
                        <div class="replay-to"><span onclick="comments.collectData(event, comment.product_id, ${comment.id})" ><br> <i class='bx bx-share'></i></span></div>
                    </div>
                  </div>
                  <div class="content">
                      <p>${comment.content}</p>
                  </div>
            `;
        } else {
            return `
                <div class="comment sub-comment-creator ">
                  <div class="header">
                      <div class="img-holder">
                          <img src="${ROOT + "/" + user.image}" alt="">
                      </div>
                      <div class="user-details">
                          <p>${user.fullname}</p>
                      </div>
                  </div>
                  <div class="content">
                      <textarea name="" id=""  rows="2"></textarea>
                      <div class="add-comment">
                          <button onclick="comments.collectData(event,null)">Přídat odpověď</button>
                      </div>
                  </div>
                </div>
            `;
        }



    },
    send_data: function (data) {
        let xhr = new XMLHttpRequest();
        let myForm = new FormData();

        for (const key in data) {
            myForm.append(key, data[key]);
        }

        xhr.addEventListener('readystatechange', () => {
            if(xhr.readyState == 4) {
                if(xhr.status == 200) {
                    this.handle_result(xhr.responseText)
                }
            }
        });

        xhr.open('post',ROOT + "/product/comment");
        xhr.send(myForm);
    },
    handle_result: function (response) {
        console.log(response);
        response = JSON.parse(response);
        if(typeof response == 'object') {

            if(typeof response.errors == 'object' && Object.keys(response.errors).length > 0) {
                for (const key in response.errors) {
                    alert(response.errors[key]);
                }
            } else if (response.data_type == 'show') {
                this.showComment(response.comment);
            } else if (response.data_type == 'user') {
                console.log(response.me);
                this.createSubComment(response.me);
            }
        }
    }
}