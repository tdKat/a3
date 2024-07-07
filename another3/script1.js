document.addEventListener('DOMContentLoaded', function() {
    fetchMechanics();
    document.getElementById('addMechanicForm').addEventListener('submit', handleAddMechanic);
});

function fetchMechanics() {
    fetch('get_mechanics.php')
        .then(response => response.json())
        .then(data => {
            const mechanics = document.getElementById('mechanicsTable').querySelector('tbody');
            mechanics.innerHTML = '';
            data.forEach(mechanics => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>${mechanics.name}</td>
                    <td>
                        <input type="number" value="${mechanics.daily_limit}" data-id="${mechanics.id}" class="daily_limit">
                        <button class="update" onclick="updateMechanic(${mechanics.id})">Update</button>
                    </td>
                    <td>
                        <button class="delete" onclick="deleteMechanic(${mechanics.id})">Delete</button>
                    </td>
                `;
                mechanics.appendChild(row);
            });
        });
}

function handleAddMechanic(event) {
    event.preventDefault();
    const formData = new FormData(event.target);
    fetch('add_mechanic.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        const responseDiv = document.getElementById('response');
        if (data.success) {
            responseDiv.textContent = 'Mechanic added successfully!';
            responseDiv.className = 'response success';
            fetchMechanics();
        } else {
            responseDiv.textContent = data.message;
            responseDiv.className = 'response error';
        }
    });
}

function deleteMechanic(mechanicId) {
    if (!confirm('Are you sure you want to delete this mechanic?')) return;

    fetch(`delete_mechanic.php?id=${mechanicId}`, {
        method: 'GET'
    })
    .then(response => response.json())
    .then(data => {
        const responseDiv = document.getElementById('response');
        if (data.success) {
            responseDiv.textContent = 'Mechanic deleted successfully!';
            responseDiv.className = 'response success';
            fetchMechanics();
        } else {
            responseDiv.textContent = data.message;
            responseDiv.className = 'response error';
        }
    });
}

function updateMechanic(mechanicId) {
    const input = document.querySelector(`input[data-id='${mechanicId}']`);
    const newCount = input.value;

    fetch(`update_mechanic.php`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ id: mechanicId, max_daily_count: newCount })
    })
    .then(response => response.json())
    .then(data => {
        const responseDiv = document.getElementById('response');
        if (data.success) {
            responseDiv.textContent = 'Mechanic updated successfully!';
            responseDiv.className = 'response success';
            fetchMechanics();
        } else {
            responseDiv.textContent = data.message;
            responseDiv.className = 'response error';
        }
    });
}
