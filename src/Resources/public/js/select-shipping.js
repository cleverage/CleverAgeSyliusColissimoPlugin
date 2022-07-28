const manageColissimoMap = (element, removePickup = null) => {
    const colissimoMapContainer = document.getElementsByClassName('colissimo-map-container')[0]
    const isColissimoPickup = typeof element.dataset.colissimoPickup !== 'undefined'

    if (removePickup) removePickup.click()

    if (isColissimoPickup) {
        if (colissimoMapContainer.classList.contains('hasPickupPoint')) {
            colissimoMapContainer.classList.remove('hasPickupPoint')
        } else {
            colissimoMapContainer.classList.add('active')
        }
    } else {
        colissimoMapContainer.classList.remove('active')
    }

    const nextStep = document.getElementById('next-step')
    if (nextStep) {
        const selectedPickup = document.querySelector('.selected-pickup-container')

        if (isColissimoPickup && selectedPickup.hasAttribute('hidden')) {
            nextStep.setAttribute('disabled', 'disabled')
        } else {
            nextStep.removeAttribute('disabled')
        }
    }
}

const choices = document.querySelectorAll('form[name="sylius_checkout_select_shipping"] input[type="radio"]')

if (choices.length) {
    const defaultChecked = document.querySelector('form[name="sylius_checkout_select_shipping"] input[type="radio"][checked]')
    const removePickup = document.getElementById('remove-pickup')

    if (defaultChecked) {
        manageColissimoMap(defaultChecked, removePickup)
    }

    choices.forEach(elem => {
        elem.addEventListener('change', function () {
            removePickup.click()
            manageColissimoMap(this)
        })
    })
}

