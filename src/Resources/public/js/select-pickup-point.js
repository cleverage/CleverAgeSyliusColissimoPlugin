window.selectPickupPoint = function (element) {
    const pickupPointId = element.dataset.identifier
    if (!pickupPointId) {
        console.error('Pickup point id not found')
        return
    }

    const url = document.getElementById('colissimo-map').dataset.setPickupUrl
    if (!url) {
        console.error('Set pickup url not found')
        return
    }

    const body = new FormData()
    body.append('pickupPointId', pickupPointId)

    fetch(url, {
        method: 'POST',
        body,
    })
        .then(response => response.json())
        .then(data => {
            document.dispatchEvent(new CustomEvent('pickupPointSelected', {
                detail: { pickupPoint: data },
            }))
        })
        .catch(error => console.log(error))
}

document.addEventListener('pickupPointSelected', function (e) {
    const { pickupPoint } = e.detail
    if (!pickupPoint) {
        return
    }

    const colissimoMap = document.getElementsByClassName('colissimo-map-container')[0]
    const selectedPickup = document.getElementById('selected-pickup')
    const pickupContainer = document.querySelector('.selected-pickup-container')

    // Remove map && show selected pickup infos.
    colissimoMap.classList.remove('active')
    selectedPickup.innerText = pickupPoint.name + ' ' + pickupPoint.streetName + ', ' + pickupPoint.postalCode + ', '  + pickupPoint.city
    pickupContainer.removeAttribute('hidden')

    // Set the identifier to the remove pickup button.
    const removePickup = document.getElementById('remove-pickup')
    removePickup.setAttribute('data-identifier', pickupPoint.id)

    const nextStep = document.getElementById('next-step')
    if (nextStep) {
        // Go to next step available !
        nextStep.removeAttribute('disabled')
    }
})
