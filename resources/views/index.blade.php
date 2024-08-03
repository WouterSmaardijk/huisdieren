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
    <div class="pagination">
        <!-- Pagination buttons will be inserted here by JavaScript -->
    </div>

    <h2>Totaal aantal huisdieren per soort</h2>

    <table id="totals-table">
        <thead>
            <tr>
                <th>Soort</th>
                <th>Aantal</th>
            </tr>
        </thead>
        <tbody>
            <!-- Data will be inserted here by JavaScript -->
        </tbody>
    </table>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            function fetchPets(page = 1) {
                fetch(`/api/pets?page=${page}`)
                    .then(response => response.json())
                    .then(responseData => {
                        const data = responseData.data;
                        const pagination = responseData;
                        const petsTableBody = document.querySelector('#pets-table tbody');
                        const paginationDiv = document.querySelector('.pagination');

                        // Clear existing table rows and pagination buttons
                        petsTableBody.innerHTML = '';
                        paginationDiv.innerHTML = '';

                        // Populate table with pet data
                        data.forEach(pet => {
                            const row = document.createElement('tr');
                            const nameCell = document.createElement('td');
                            const typeCell = document.createElement('td');
                            const addressCell = document.createElement('td');
                            const deleteCell = document.createElement('td');
                            const deleteButton = document.createElement('button');

                            nameCell.textContent = pet.name;
                            typeCell.textContent = toUpperFirst(pet.type);
                            addressCell.textContent = pet.address;
                            deleteButton.textContent = 'Delete';
                            deleteButton.addEventListener('click', function() {
                                fetch(`/api/pets/${pet.id}`, { method: 'DELETE' })
                                    .then(response => response.json())
                                    .then(data => {
                                        row.remove();
                                        fetchTotals();
                                    })
                                    .catch(error => console.error('Error deleting data:', error));
                            });

                            row.appendChild(nameCell);
                            row.appendChild(typeCell);
                            row.appendChild(addressCell);
                            deleteCell.appendChild(deleteButton);
                            row.appendChild(deleteCell);

                            petsTableBody.appendChild(row);
                        });

                        // Create pagination buttons
                        for (let i = 1; i <= pagination.last_page; i++) {
                            const button = document.createElement('button');
                            button.textContent = i;
                            button.addEventListener('click', function() {
                                fetchPets(i);
                            });
                            paginationDiv.appendChild(button);
                        }
                    })
                    .catch(error => console.error('Error fetching data:', error));
            }

            function fetchTotals() {
                fetch('/api/pets/totals')
                    .then(response => response.json())
                    .then(data => {
                        const totalsTableBody = document.querySelector('#totals-table tbody');

                        // Clear existing totals table rows
                        totalsTableBody.innerHTML = '';

                        // Populate totals table with data
                        data.forEach(total => {
                            const row = document.createElement('tr');
                            const speciesCell = document.createElement('td');
                            const amountCell = document.createElement('td');

                            speciesCell.textContent = toUpperFirst(total.species);
                            amountCell.textContent = total.amount;

                            row.appendChild(speciesCell);
                            row.appendChild(amountCell);

                            totalsTableBody.appendChild(row);
                        });
                    })
                    .catch(error => console.error('Error fetching totals:', error));
            }

            // Initial fetch
            fetchPets();
            fetchTotals();
        });
        function toUpperFirst(string) {
            return string.charAt(0).toUpperCase() + string.slice(1);
        }
    </script>
</body>
<style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .pagination button {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 10px 20px;
            margin: 5px;
            cursor: pointer;
        }
        .pagination button:hover {
            background-color: #45a049;
        }
        h1, h2 {
            color: #333;
        }
        button {
            background-color: #f44336;
            color: white;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
        }
        button:hover {
            background-color: #d32f2f;
        }
    </style>
</html>