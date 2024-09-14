
    <title>To-Do App</title>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <style>
        body {
            background-color: #f0f8ff; 
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            font-family: Arial, sans-serif;
        }

        #app-container {
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 300px;
            text-align: center;
        }

        h1 {
            margin-bottom: 20px;
        }

        input[type="text"] {
            width: 80%;
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        button {
            padding: 8px 12px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        button:hover {
            background-color: #0056b3;
        }

        ul {
            list-style-type: none;
            padding: 0;
        }

        li {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
        }

        li span {
            flex-grow: 1;
            margin-left: 10px;
        }

        li button {
            background-color: #dc3545;
        }

        li button:hover {
            background-color: #c82333;
        }
    </style>
</head>
<body>
    <div id="app-container">
        <h1>To-Do List</h1>

        <form id="taskForm">
            <input id="newTaskInput" placeholder="Add a task">
            <button type="submit">Add Task</button>
        </form>

        <ul id="taskList"></ul>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const taskList = document.getElementById('taskList');
            const newTaskInput = document.getElementById('newTaskInput');
            const taskForm = document.getElementById('taskForm');

            function fetchTasks() {
                axios.get('api.php')
                    .then(response => {
                        taskList.innerHTML = '';
                        response.data.forEach(task => {
                            addTaskToDOM(task);
                        });
                    })
                    .catch(error => {
                        console.error('Error fetching tasks:', error);
                    });
            }

            function addTaskToDOM(task) {
                const li = document.createElement('li');
                const checkbox = document.createElement('input');
                checkbox.type = 'checkbox';
                checkbox.checked = task.completed;
                checkbox.addEventListener('change', function() {
                    updateTask(task.id, task.title, checkbox.checked);
                });

                const span = document.createElement('span');
                span.textContent = task.title;
                span.style.textDecoration = task.completed ? 'line-through' : 'none';

                const deleteButton = document.createElement('button');
                deleteButton.textContent = 'Delete';
                deleteButton.addEventListener('click', function() {
                    deleteTask(task.id);
                });

                li.appendChild(checkbox);
                li.appendChild(span);
                li.appendChild(deleteButton);

                taskList.appendChild(li);
            }

            taskForm.addEventListener('submit', function(e) {
                e.preventDefault();
                const taskTitle = newTaskInput.value.trim();
                if (taskTitle) {
                    axios.post('api.php', { title: taskTitle })
                        .then(() => {
                            newTaskInput.value = '';
                            fetchTasks();
                        })
                        .catch(error => {
                            console.error('Error creating task:', error);
                        });
                }
            });

            function updateTask(id, title, completed) {
                axios.put('api.php', {
                    id: id,
                    title: title,
                    completed: completed ? 1 : 0
                })
                .then(() => {
                    fetchTasks();
                })
                .catch(error => {
                    console.error('Error updating task:', error);
                });
            }

            function deleteTask(id) {
                axios.delete('api.php', { data: { id: id } })
                    .then(() => {
                        fetchTasks();
                    })
                    .catch(error => {
                        console.error('Error deleting task:', error);
                    });
            }

            fetchTasks();
        });
    </script>

