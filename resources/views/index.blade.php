<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Huisdieren</title>
</head>
<body>
    <h1>Huisdieren</h1>
    <header>
        <nav>
            <a class="active-tab" href="/">Home</a>
            <a href="/create">Nieuw huisdier</a>
        </nav>
    </header>
    <table id="pets-table">
        <thead>
            <tr>
                <th>Naam</th>
                <th>Type</th>
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
                <th>Type</th>
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
                    populatePetsTable(data, petsTableBody);

                    // Create pagination buttons
                    createPaginationButtons(pagination, paginationDiv);
                })
                .catch(error => console.error('Error fetching data:', error));
        }

        function fetchTotals() {
            fetch('/api/pets/totals')
                .then(response => response.json())
                .then(data => {
                    const totalsTableBody = document.querySelector('#totals-table tbody');

                    // Clear existing table rows
                    totalsTableBody.innerHTML = '';

                    // Populate table with totals data
                    populateTotalsTable(data, totalsTableBody);
                })
                .catch(error => console.error('Error fetching totals:', error));
        }

        function populatePetsTable(data, tableBody) {
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
                if(!confirm("Weet je zeker dat je dit huisdier wilt verwijderen?")) {
                        return;
                } 
                handleDelete(pet.id, row);
                });

                row.appendChild(nameCell);
                row.appendChild(typeCell);
                row.appendChild(addressCell);
                deleteCell.appendChild(deleteButton);
                row.appendChild(deleteCell);

                tableBody.appendChild(row);
            });
        }

        function populateTotalsTable(data, tableBody) {
            data.forEach(total => {
                const row = document.createElement('tr');
                const typeCell = document.createElement('td');
                const amountCell = document.createElement('td');

                typeCell.textContent = toUpperFirst(total.species);
                amountCell.textContent = total.amount;

                row.appendChild(typeCell);
                row.appendChild(amountCell);

                tableBody.appendChild(row);
            });
        }

        function createPaginationButtons(pagination, paginationDiv) {
            for (let i = 1; i <= pagination.last_page; i++) {
                const button = document.createElement('button');
                button.textContent = i;
                if (i === pagination.current_page) {
                    button.classList.add('active'); // Add a class to highlight the current page
                }
                button.addEventListener('click', function() {
                    fetchPets(i);
                });
                paginationDiv.appendChild(button);
            }
        }

        function handleDelete(petId, row) {
            fetch(`/api/pets/${petId}`, { method: 'DELETE' })
                .then(response => response.json())
                .then(data => {
                    row.remove();
                    fetchTotals();
                })
                .catch(error => console.error('Error deleting data:', error));
        }

        function toUpperFirst(string) {
            return string.charAt(0).toUpperCase() + string.slice(1);
        }

        // Initial fetch
        fetchPets();
        fetchTotals();
    });
    </script>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        header {
            margin-bottom: 20px;
        }
        nav {
            margin-bottom: 20px;
        }
        nav a {
            margin-right: 10px;
            text-decoration: none;
            color: white;
            background-color:#4CAF50;
            padding: 5px;
            border: none;
        }
        nav a.active-tab {
            background-color: #007bff;
            border: solid 3px black;
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
        .pagination button.active {
            background-color: #007bff;
            color: white;
            border: solid 3px black;
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
</body>
</html>