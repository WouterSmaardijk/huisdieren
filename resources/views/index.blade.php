<!DOCTYPE html>
<html lang="en">
<x-head>
</x-head>
<body>
    <x-header>
    </x-header>
    <div class="container">
        <div class="section">
            <div class="title is-5">Alle Huisdieren</div>
            <table id="pets-table" class="table is-primary is-striped fixed-width is-hoverable">
                <thead class="table-head">
                    <tr>
                        <th class="col-name">Naam</th>
                        <th class="col-type">Type</th>
                        <th class="col-address">Adres</th>
                        <th class="col-actions"></th>
                    </tr>
                </thead>
                <tbody class="table-body">
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="4">
                            <x-pagination></x-pagination>
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>
        <hr class="is-divider">
        <div class="section">
            <div class="title is-5">Aantal Huisdieren Per Type</div>

            <table id="totals-table" class="table is-striped">
                <thead class="table-head">
                    <tr>
                        <th>Type</th>
                        <th>Aantal</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        function fetchPets(page = 1) {
            fetch(`/api/pets?page=${page}`)
                .then(response => response.json())
                .then(responseData => {
                    const data = responseData.data;
                    const pagination = responseData;
                    const petsTableBody = document.querySelector('#pets-table tbody');
                    const paginationList = document.querySelector('.pagination-list');

                    // Clear existing table rows and pagination buttons
                    petsTableBody.innerHTML = '';
                    paginationList.innerHTML = '';

                    // Populate table with pet data
                    populatePetsTable(data, petsTableBody);

                    // Create pagination buttons
                    createPaginationButtons(pagination, paginationList);
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
                deleteButton.classList.add('delete');

                nameCell.textContent = pet.name;
                typeCell.textContent = toUpperFirst(pet.type);
                addressCell.textContent = pet.address;
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

        function createPaginationButtons(pagination, paginationList) {
            for (let i = 1; i <= pagination.last_page; i++) {
                const listItem = document.createElement('li');
                const button = document.createElement('a');
                button.classList.add('pagination-link');
                listItem.appendChild(button);
                button.textContent = i;
                if (i === pagination.current_page) {
                    button.classList.add('is-current'); // Add a class to highlight the current page
                }
                listItem.addEventListener('click', function() {
                    fetchPets(i);
                });
                paginationList.appendChild(listItem);
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
</body>
</html>