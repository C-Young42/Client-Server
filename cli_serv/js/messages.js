const currentMessagesDiv = document.getElementById("current-messages");
const listTabUsers = document.getElementById("list-tab-users");
const msgInput = document.getElementById("message-input");

let currentUser = null;
let loading = false;

//adds an event handler to the element
document.addEventListener('DOMContentLoaded', async () =>
{
    await getChatUsers();

    msgInput.addEventListener("keydown", sendMessage);
});
// send messages from one user to the other
async function sendMessage(e) {
    if (e.key === "Enter" && currentUser) {
        const message = msgInput.value;
        msgInput.value = "";

        const form = new FormData();
        form.append('userTo', currentUser);
        form.append('msg', message);

        //checks for a valid user
        const res = await fetch("data/messages.php", {
            method: 'POST',
            credentials: 'same-origin',
            body: form,
        });
        const json = await res.json();

        const returnedMessage = json.message;
        const { body, date} = returnedMessage;

        currentMessagesDiv.innerHTML += `<div class="message self">
                                            <p class="msg-text">${body}</p>
                                            <p class="small text-muted">${date}</p>
                                        </div>`;

        e.preventDefault();
    }
}

async function getChatUsers()
{
    const res = await fetch('data/messages.php', {
        credentials: 'same-origin'
    });
    const data = await res.json();

    // Add users to the group
    data.forEach(message => {
        const { name, date, last_message, id } = message;

        listTabUsers.innerHTML += `<a href="#current-messages" class="list-group-item list-group-item-action flex-column align-items-start user-message-list" role="tab" data-toggle="list" id="user-messages-${id}">
                                    <div class="d-flex w-100 justify-content-between">
                                      <h5 class="mb-1">${name}</h5>
                                      <small class="text-warning">${date}</small>
                                    </div>
                                    <p class="mb-1">${last_message}</p>
                                  </a>`;
    });

    // adds the event listeners
    addEventListeners();
}


function addEventListeners()
{
    const usersList = document.getElementsByClassName('user-message-list');
    for (const tab of usersList) {
        tab.addEventListener('click', async function () {
            if (loading)
                return;

            const id = this.id.substr(14);
            currentUser = id;

            const res = await fetch(`data/messages.php?id=${id}`);
            const data = await res.json();

            currentMessagesDiv.innerHTML = "";

            data.forEach(message => {
               const { body, self, date } = message;

               let html = ``;

               if (self == 1) {
                   html = `<div class="message self">
                            <p class="msg-text">${body}</p>
                            <p class="small text-muted">${date}</p>
                        </div>`;
               } else {
                   html = `<div class="message">
                            <p class="msg-text">${body}</p>
                            <p class="small text-muted">${date}</p>
                        </div>`;
               }
               currentMessagesDiv.innerHTML += html;
            });

            loading = false;
        });
    }
}