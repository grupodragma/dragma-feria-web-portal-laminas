window.App = window.App || {};

App.mapManager = {
    map: null,
    markers: [],
    mapId: null,
    defaultCenter: [-12.0464, -77.0428],
    defaultZoom: 13,
    projects: [],
    projectsInitials: [],
    urlBackend: null,
    selectedLanguage: null,
    customIcon: L.icon({
        iconUrl: 'https://nexoinmobiliario.pe/static/website/build/images/marker-nexo-new.png',
        iconSize: [37, 51]
    }),

    init(mapId, options = {}) {
        console.log('options', options);

        this.mapId = mapId;
        this.projects = options.projects || [];
        this.projectsInitials = options.projects || [];
        this.urlBackend = options.urlBackend || null;
        this.selectedLanguage = options.selectedLanguage || null;
        this.map = L.map(this.mapId).setView(this.defaultCenter, this.defaultZoom);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap contributors'
        }).addTo(this.map);

        this.loadProjects();

        return this;
    },

    loadProjects() {
        if (!Array.isArray(this.projects)) return;

        console.log('loadProjects', this.projects);

        this.clearMarkers();

        this.projects.forEach(project => {

            const lat = parseFloat(project.latitud);
            const lng = parseFloat(project.longitud);

            if (!lat || !lng) return;

            const marker = L.marker([lat, lng], {
                icon: this.customIcon
            }).addTo(this.map);

            const tooltipHTML = `
                <div class="tooltip-card">
                    <div class="tooltip-header">
                        <span class="tooltip-header-title">PUEBLO LIBRE</span>
                        <img
                            class="tooltip-header-imagen"
                            src="${this.urlBackend}/empresas/logo/${project.empresa_logo}"
                        />
                    </div>
                    <div class="tooltip-body">
                        <h4>${project.nombre}</h4>
                        <p>${project.titulo_recuadro}</p>
                        <div class="price">
                            <span>Precio desde</span>
                            <strong>S/${project.precio_desde}</strong>
                        </div>
                        <a href="${this.selectedLanguage}/panel/proyecto/${project.hash_url}">
                            <div class="btn">MÁS INFORMACIÓN</div>
                        </a>
                    </div>
                </div>
            `;

            marker.bindPopup(tooltipHTML, {
                className: 'custom-tooltip',
                maxWidth: 280,
                offset: [0, -15]
            });

            marker.on('mouseover', function () {
                this.openPopup();
            });

            marker.on('mouseout', function () {
                setTimeout(() => {
                    const popup = document.querySelector('.custom-tooltip');

                    if (popup && !popup.matches(':hover')) {
                        this.closePopup();
                    }
                }, 200);
            });

            this.markers.push(marker);
        });

        if (this.markers.length > 0) {
            const group = L.featureGroup(this.markers);
            this.map.fitBounds(group.getBounds(), { padding: [20, 20] });
        }
    },

    filterProjects(obj) {
        console.log('filterProjects');

        let contenedorFiltros = $(obj).parents("form");
        let objSelect = contenedorFiltros.find("select.filtro-mapa");
        let filter = new Object();
        let totalfiltrosVacios = false;

        objSelect.each(function(){
            let keySelect = $(this).attr("data-filtro");
            let valorSelect = $(this).val();
            filter[keySelect] = valorSelect;
            if(valorSelect == '')totalfiltrosVacios++;
        });

        console.log(filter);

        this.projects = this.projectsInitials;

        this.projects = this.projects.filter(item => {
            if (filter.etapa && item.etapa !== filter.etapa) {
                return false;
            }

            if (filter.numeroHabitacion && item.numeroHabitacion !== filter.numeroHabitacion) {
                return false;
            }

            if (filter.distrito && item.distrito !== filter.distrito) {
                return false;
            }

            if (filter.tipoHabitacion && item.tipoHabitacion !== filter.tipoHabitacion) {
                return false;
            }

            return true;
        });

        this.loadProjects();
    },

    clearMarkers() {
        if (this.markers) {
            this.markers.forEach(m => this.map.removeLayer(m));
        }

        this.markers = [];
    },

    invalidateSize() {
        if (this.map) {
            this.map.invalidateSize();
            if( this.marker ) {
                this.marker.openPopup();
            }
        }
    }
};

function redirectPage(url) {
    console.log('redirectPage', url);
}