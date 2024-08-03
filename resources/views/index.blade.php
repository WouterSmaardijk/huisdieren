<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Huisdieren</title>
</head>
<body>
    <h1>Huisdieren</h1>
    <table id="pets-table">
        <thead>
            <tr>
                <th>Naam</th>
                <th>Soort</th>
                <th>Adres</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <!-- Data will be inserted here by JavaScript -->
        </tbody>
    </table>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            fetch('/api/pets')
                .then(response => response.json())
                .then(responseData => {
                    const data = responseData.data;
                    const petsTableBody = document.querySelector('#pets-table tbody');
                    data.forEach(pet => {
                        const row = document.createElement('tr');
                        const nameCell = document.createElement('td');
                        const typeCell = document.createElement('td');
                        const addressCell = document.createElement('td');
                        const deleteCell = document.createElement('td');
                        const deleteButton = document.createElement('button');
                        
                        nameCell.textContent = pet.name;
                        typeCell.textContent = pet.type;
                        addressCell.textContent = pet.address;
                        deleteButton.textContent = 'Delete';
                        deleteButton.addEventListener('click', function() {
                            fetch(`/api/pets/${pet.id}`, { method: 'DELETE' })
                                .then(response => response.json())
                                .then(data => {
                                    row.remove();
                                })
                                .catch(error => console.error('Error deleting data:', error));
                        });
                        row.appendChild(nameCell);
                        row.appendChild(typeCell);
                        row.appendChild(addressCell);
                        row.appendChild(deleteCell);
                        deleteCell.appendChild(deleteButton);

                        petsTableBody.appendChild(row);
                    });
                })
                .catch(error => console.error('Error fetching data:', error));
        });
    </script>
</body>
</html>
