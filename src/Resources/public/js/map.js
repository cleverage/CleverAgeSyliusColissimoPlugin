import * as L from "https://cdn.jsdelivr.net/npm/leaflet@1.8.0/dist/leaflet-src.esm.js"

const DEFAULT_POSITION = [48.866667, 2.333333]

class Map {
    constructor () {
        this.mapSelector = document.getElementById('colissimo-map')
        this.pickupPoints = JSON.parse(this.mapSelector.dataset.points)
        this.firstCoords = []
        this.map = L.map('colissimo-map', {
            center: DEFAULT_POSITION,
            zoom: 13,
        })

        // Initialize map
        this.init()
        // Center map to pickupPoints
        this.panToFirstCoords()
    }

    panToFirstCoords() {
        if (this.pickupPoints?.length > 0) {
            this.firstCoords = this.pickupPoints[0]
            this.map.panTo([
                this.firstCoords.latGeoCoord,
                this.firstCoords.longGeoCoord,
            ])
        }
    }

    init() {
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
        }).addTo(this.map)

        if (this.pickupPoints?.length > 0) {
            this.setMarkers()
        }
    }

    setMarkers() {
        for (const pickupPoint of this.pickupPoints) {
            let marker = L.marker([
                pickupPoint.latGeoCoord,
                pickupPoint.longGeoCoord,
            ]).addTo(this.map)

            marker.bindPopup(this.getPopupContent(pickupPoint))
        }
    }

    getPopupContent(pickupPoint) {
        // @TODO : use translations.
        return `<div class="popup-pickup-content">
                   <div class="popup-pickup-type">${this.getPickupName(pickupPoint.pointType)}</div>
                   <h2 class="popup-pickup-name">${pickupPoint.name}</h2>
                   <div class="popup-address">
                       <div class="upc">${pickupPoint.streetName.toLowerCase()}</div>
                       <div class="city">${pickupPoint.postalCode} ${pickupPoint.city.toLowerCase()}</div>
                   </div>
                   <a onclick="selectPickupPoint(this)" 
                      id="choose-pickup-point" 
                      class="ui large primary button" 
                      data-identifier="${pickupPoint.id}"
                    >
                       <span>Choisir ce point relais</span>
                   </a>
                   <div class="popup-opening-hours">
                       <div>Horaire d'ouvertures : </div>
                       <ul>
                            ${this.getOpeningHours(pickupPoint.openings)}
                       </ul>
                   </div>
               </div>`
    }

    getPickupName(type) {
        // @TODO : use translations.
        switch (type) {
            case 'A2P':
            case 'PCS':
                return 'Commerçant'
            case 'BPR':
            case 'BDP':
            case 'CDI':
            case 'ACP':
                return 'Poste'
            default:
                return ''
        }
    }

    getOpeningHours(openingHourds) {
        const days = [
            { name: 'Lun', openings: openingHourds.monday[0].split(' ') },
            { name: 'Mar', openings: openingHourds.tuesday[0].split(' ') },
            { name: 'Mer', openings: openingHourds.wednesday[0].split(' ') },
            { name: 'Jeu', openings: openingHourds.thursday[0].split(' ') },
            { name: 'Ven', openings: openingHourds.friday[0].split(' ') },
            { name: 'Sam', openings: openingHourds.saturday[0].split(' ') },
            { name: 'Dim', openings: openingHourds.sunday[0].split(' ') },
        ]

        const closings = [],
            openingHours = []

        days.forEach(day => {
            if (day.openings[0] === day.openings[1] && day.openings[0] === '00:00-00:00') {
                closings.push(day.name)
            } else {
                if (day.openings[0] === '00:00-00:00') {
                    day.openings = day.openings[1]
                } else if (day.openings[1] === '00:00-00:00') {
                    day.openings = day.openings[0]
                }

                openingHours.push(day)
            }
        })

        const openings = []
        openingHours.forEach(opening => {
            if (typeof opening.openings === 'string') {
                // One opening hour a day
                const existingOpening = openings.findIndex(o => o.openingHours === opening.openings)
                if (existingOpening === -1) {
                    // Not in array yet
                    openings.push({
                        days: opening.name,
                        openingHours: opening.openings,
                    })
                } else {
                    openings[existingOpening].days += `, ${opening.name}`
                }
            } else {
                // Two opening hours a day
                const existingOpening = openings.findIndex(o => o.openingHours === `${opening.openings[0]} - ${opening.openings[1]}`)
                if (existingOpening === -1) {
                    openings.push({
                        days: opening.name,
                        openingHours: `${opening.openings[0]} - ${opening.openings[1]}`,
                    })
                } else {
                    openings[existingOpening].days += `, ${opening.name}`
                }
            }
        })

        let list = ''
        openings.forEach(opening => {
            list += `
                <li>
                    <strong>${opening.days} :</strong> ${opening.openingHours}
                </li>
            `
        })

        if (closings.length) {
            list += `
                <li>
                    <strong>Jour${closings.length > 1 ? 's' : ''} fermé${closings.length > 1 ? 's' : ''}</strong> : ${closings.join(', ')}
                </li>
            `
        }

        return list
    }
}

export default Map

// Init map
if (document.getElementById('colissimo-map')) {
    new Map().init()
}
