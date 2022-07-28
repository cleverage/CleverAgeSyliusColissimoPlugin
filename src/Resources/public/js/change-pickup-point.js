const removePickup = document.getElementById('remove-pickup')

if (removePickup) {
    removePickup.addEventListener('click', function () {
        // Show Map
        document.getElementsByClassName('colissimo-map-container')[0].classList.add('active')
        // Remove selected pickup text
        document.getElementById('selected-pickup').innerText = ''
        // Hide selected pickup
        document.querySelector('.selected-pickup-container').setAttribute('hidden', 'hidden')

        removeFromDatabase(removePickup)

        const nextStep = document.getElementById('next-step')
        if (nextStep) {
            nextStep.setAttribute('disabled', 'disabled')
        }
    })
}

const removeFromDatabase = element => {
    const { removeUrl, identifier } = element.dataset

    if (!identifier) {
        return
    }

    fetch(removeUrl + '?pickupPointId=' + identifier, {
        method: 'DELETE',
    })
        .then(response => response.json())
        .then(data => {
            // Do like you want !
        })
        .catch(error => console.log(error))
}
