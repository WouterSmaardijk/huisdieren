<!DOCTYPE html>
<html lang="en">
<x-head>
</x-head>
<body>
    <x-header>
    </x-header>
    <div class="container">
        <div class="section">
            <div class="title is-5 has-text-white">Huisdier Toevoegen</div>
            <form id="create-pet-form">
                <div class="field">
                    <label class="label" for="name">Naam:</label>
                    <div class="control">
                        <input class="input" type="text" id="name" name="name" required>
                    </div>
                </div>
                <div class="field">
                    <label class="label" for="type">Type:</label>
                    <div class="control">
                        <div class="select">
                            <select id="type" name="type" required>
                            </select>
                        </div>
                    </div>
                </div>
                <div>
                    <label class="label" for="address">Adres:</label>
                    <div class="control">
                        <textarea id="address" class="textarea" name="address" rows="4" required></textarea>
                    </div>
                </div>
                <div class="field">
                    <div class="control">
                        <button class="button is-primary mt-4" type="submit">Toevoegen</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
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
</body>
</html>