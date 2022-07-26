const manageColissimoMap = element => {
    const colissimoMapContainer = document.getElementsByClassName('colissimo-map-container')[0]
    const isColissimoPickup = typeof element.dataset.colissimoPickup !== 'undefined'

    if (isColissimoPickup) {
        colissimoMapContainer.classList.add('active')
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

    manageColissimoMap(defaultChecked)

    choices.forEach(elem => {
        elem.addEventListener('change', function () {
            removePickup.click()
            manageColissimoMap(this)
        })
    })
}

