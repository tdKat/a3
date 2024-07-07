document.addEventListener('DOMContentLoaded', function() {
    fetchMechanics();
    document.getElementById('appointmentForm').addEventListener('submit', handleFormSubmit);
});

function fetchMechanics() {
    fetch('get_mechanics.php')
        .then(response => response.json())
        .then(data => {
            const mechanicSelect = document.getElementById('mechanic_id');
            data.forEach(mechanics => {
                const option = document.createElement('option');
                option.value = mechanics.id;
                option.textContent = `${mechanics.name}`;
                mechanicSelect.appendChild(option);
            });
        });
}

function handleFormSubmit(event) {
    event.preventDefault();
    const formData = new FormData(event.target);
    fetch('book_appointment.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        const responseDiv = document.getElementById('response');
        if (data.success) {
            responseDiv.textContent = 'Appointment booked successfully!';
            responseDiv.className = 'response success';
        } else {
            responseDiv.textContent = data.message;
            responseDiv.className = 'response error';
        }
    });
}
