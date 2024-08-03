<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nieuw Huisdier</title>
</head>
<body>
    <h1>Nieuw Huisdier</h1>
    <header>
        <nav>
            <a href="/">Home</a>
            <a class="active-tab" href="/create">Nieuw huisdier</a>
        </nav>
    </header>

    <form id="create-pet-form">
        <div>
            <label for="name">Naam:</label>
            <input type="text" id="name" name="name" required>
        </div>
        <div>
            <label for="type">Type:</label>
            <select id="type" name="type" required>
            </select>
        </div>
        <div>
            <label for="address">Adres:</label>
            <textarea id="address" name="address" rows="4" required></textarea>
        </div>
        <button type="submit">Toevoegen</button>
    </form>

    <script>
        fetch('/api/pets/types')
            .then(response => response.json())
            .then(data => {
                const typeSelect = document.getElementById('type');
                data.forEach(type => {
                    const option = document.createElement('option');
                    option.value = type.id;
                    option.textContent = toUpperFirst(type.name);
                    typeSelect.appendChild(option);
                });
            })
            .catch(error => console.error('Error loading types:', error));
        
        document.getElementById('create-pet-form').addEventListener('submit', function(event) {
            event.preventDefault();
        
            const name = document.getElementById('name').value;
            const type_id = document.getElementById('type').value;
            const address = document.getElementById('address').value;
        
            fetch('/api/pets', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ name, type_id, address })
            })
            .then(response => {
                if (!response.ok) {
                    return response.json().then(errorData => {
                        throw new Error(errorData.message || 'Error adding pet');
                    });
                }
                return response.json();
            })
            .then(data => {
                alert('Huisdier toegevoegd!');
                window.location.href = '/';
            })
            .catch(error => {
                alert('Error: ' + error.message);
                console.error('Error adding pet:', error);
            });
        });
        
        function toUpperFirst(string) {
            return string.charAt(0).toUpperCase() + string.slice(1);
        }

    </script>

    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        header {
            margin-bottom: 20px;
        }
        nav a {
            margin-right: 10px;
            text-decoration: none;
            font-weight: bold;
            color: white;
            background-color:#4CAF50;
            padding: 5px;
            border: none;
        }
        nav a.active-tab {
            background-color: #007bff;
            border: solid 3px black;
        }
        form {
            max-width: 600px;
            margin: 0 auto;
        }
        form div {
            margin-bottom: 15px;
        }
        label {
            display: block;
            margin-bottom: 5px;
        }
        input, select, textarea {
            width: 100%;
            padding: 8px;
            box-sizing: border-box;
        }
        button {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
        }
        button:hover {
            background-color: #45a049;
        }
        h1 {
            color: #333;
        }
    </style>
</body>
</html>