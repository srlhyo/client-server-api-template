<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/styles.css">
    <title>Client API</title>
</head>
<body>
    <h2>A demo on how to make an api call from the client side</h2>

    <div id="wrapper">
    </div>

    <form action="/foobar" method="POST" id="createUser">
        <input type="text" name="name" id="name" placeholder="your name">
        <input type="text" name="age" id="age" placeholder="your age">
        <button type="submit" >SUBMIT</button>
    </form>

    <div id="status"></div>

    <script>

        document.querySelector("#createUser").addEventListener("submit", function(e) {
            e.preventDefault();
            createUser()
            .then(handlerSuccess)
            .then(loadUsers)
            .catch(handlerError)
        });
        
        document.querySelector("#wrapper").addEventListener("click", function(e) {
            if ( e.target.classList.contains('delete-button') ) {
                deleteUser(e.target.getAttribute("userid"))
                .then(handlerSuccess)
                .then(loadUsers)
                .catch(handlerError)
            }
        });

        function handlerError(err) {
            document.getElementById('status').innerHTML = err;
        }

        function handlerSuccess() {
            document.getElementById('status').innerHTML = "sucess";
        }

        function loadUsers() {
            return fetch("service.php?resource=users")
            .then(resp => resp.json())
            .then(data => {
                const wrapper = document.getElementById("wrapper");
                wrapper.querySelectorAll('*').forEach(n => n.remove());
                wrapper.innerHTML = "<div class=\"one\">Id</div><div class=\"two\">Name</div><div class=\"three\">Age</div><div class=\"four\">Actions</div>"; 

                data.forEach(element => {
                    const id = document.createElement("div");
                    id.innerHTML = element.id;
                    wrapper.appendChild(id);

                    const name = document.createElement("div");
                    name.innerHTML = element.name;
                    wrapper.appendChild(name);

                    const age = document.createElement("div");
                    age.innerHTML = element.age;
                    wrapper.appendChild(age);

                    const btn = document.createElement("button");
                    btn.innerHTML = "delete";
                    btn.setAttribute("userid", element.id);

                    btn.className = "delete-button";
                    wrapper.appendChild(btn);
                    
                });
            });
        }

        function createUser() {
            const form = new FormData(document.getElementById('createUser'));
            return fetch("service.php?resource=users", {
                method: "POST",
                body: form
            })
            .then(resp => resp.json())
            .then(data => {
                if(!data || data.error) {
                    throw new Error(data.error);
                }
            })
        }

        function deleteUser(id) {
            return fetch("service.php?resource=user-delete&id=" + id)
            .then(resp => resp.json())
            .then(data => {
                if(!data || data.error) {
                    throw new Error(data.error);
                }
            })
        }

        loadUsers()
        .catch(handlerError)
    </script>
</body>
</html>
