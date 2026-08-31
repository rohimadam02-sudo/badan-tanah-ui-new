function asetPage() {

    return {

        /* =====================================================
           DATA
        ====================================================== */

        asets: [],

        loading: false,

        map: null,

        markers: [],


        /* =====================================================
           FILTER
        ====================================================== */

        filters: {
            provinsi: '',
            luas_min: '',
            luas_max: '',
            peruntukan: '',
            skema: ''
        },


        /* =====================================================
           DATA DUMMY
           Dipakai sebagai fallback untuk:
           - Daftar Aset
           - Peta
           - Popup
           - Filter
        ====================================================== */

        dummyAssets: [

            {
                id: 'dummy-1',
                nama_lokasi: 'Kawasan Industri Terpadu Batang',
                provinsi: 'Jawa Tengah',
                kabupaten: 'Batang',
                luas_hektar: 2450,
                status: 'Tersedia',
                peruntukan: 'Industri',
                skema: 'Kerjasama',
                lat: -6.9004,
                lng: 109.7422,
                gambar: null
            },

            {
                id: 'dummy-2',
                nama_lokasi: 'Tanah Bekas HGU PT. Sinar Harapan',
                provinsi: 'Sumatera Selatan',
                kabupaten: 'Musi Banyuasin',
                luas_hektar: 1850.50,
                status: 'Dalam Pengembangan',
                peruntukan: 'Pertanian',
                skema: 'Sewa',
                lat: -2.4858,
                lng: 103.5038,
                gambar: null
            },

            {
                id: 'dummy-3',
                nama_lokasi: 'Kawasan Sentra Pangan Merauke',
                provinsi: 'Papua Selatan',
                kabupaten: 'Merauke',
                luas_hektar: 5320.75,
                status: 'Tersedia',
                peruntukan: 'Pertanian',
                skema: 'Kerjasama',
                lat: -8.4966,
                lng: 140.3940,
                gambar: null
            },

            {
                id: 'dummy-4',
                nama_lokasi: 'Kawasan Pengembangan Perumahan Bogor',
                provinsi: 'Jawa Barat',
                kabupaten: 'Bogor',
                luas_hektar: 850.25,
                status: 'Dalam Proses',
                peruntukan: 'Perumahan',
                skema: 'Kerjasama',
                lat: -6.5950,
                lng: 106.8160,
                gambar: null
            },

            {
                id: 'dummy-5',
                nama_lokasi: 'Kawasan Pertanian Produktif Gowa',
                provinsi: 'Sulawesi Selatan',
                kabupaten: 'Gowa',
                luas_hektar: 1250.80,
                status: 'Tersedia',
                peruntukan: 'Pertanian',
                skema: 'Sewa',
                lat: -5.3170,
                lng: 119.7420,
                gambar: null
            },

            {
                id: 'dummy-6',
                nama_lokasi: 'Kawasan Industri Kalimantan Timur',
                provinsi: 'Kalimantan Timur',
                kabupaten: 'Kutai Kartanegara',
                luas_hektar: 3150.40,
                status: 'Dalam Pengembangan',
                peruntukan: 'Industri',
                skema: 'Kerjasama',
                lat: -0.5020,
                lng: 117.1530,
                gambar: null
            }

        ],


        /* =====================================================
           INIT
        ====================================================== */

        async init() {

            console.log('ASET PAGE: init');

            this.initMap();

            await this.fetchAset();

        },


        /* =====================================================
           INIT MAP
        ====================================================== */

        initMap() {

            const mapElement = document.getElementById('assetMap');

            if (!mapElement) {

                console.error(
                    'ASET PAGE: #assetMap tidak ditemukan'
                );

                return;
            }


            // Cegah map dibuat dua kali
            if (this.map) {

                console.log(
                    'ASET PAGE: map sudah dibuat'
                );

                return;
            }


            this.map = L.map('assetMap').setView(
                [-2.5, 118],
                5
            );


            L.tileLayer(
                'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '&copy; OpenStreetMap contributors'
                }
            ).addTo(this.map);


            console.log(
                'ASET PAGE: map berhasil dibuat'
            );

        },


        /* =====================================================
           FETCH DATA
        ====================================================== */

        async fetchAset(filters = this.filters) {

            this.loading = true;


            try {

                const cleanFilters = {};


                Object.keys(filters).forEach(key => {

                    if (
                        filters[key] !== '' &&
                        filters[key] !== null &&
                        filters[key] !== undefined
                    ) {

                        cleanFilters[key] =
                            filters[key];

                    }

                });


                const params =
                    new URLSearchParams(
                        cleanFilters
                    ).toString();


                const response =
                    await fetch(
                        `/aset/filter?${params}`
                    );


                if (!response.ok) {

                    throw new Error(
                        'Gagal mengambil data aset'
                    );

                }


                const data =
                    await response.json();


                console.log(
                    'DATA DATABASE:',
                    data
                );


                /*
                 * Jika database mempunyai data,
                 * gunakan database.
                 */

                if (
                    Array.isArray(data) &&
                    data.length > 0
                ) {

                    this.asets = data;

                    console.log(
                        'ASET PAGE: menggunakan data database'
                    );

                }


                /*
                 * Jika database kosong,
                 * gunakan dummy.
                 */
                else {

                    this.asets =
                        this.filterDummyAssets(
                            filters
                        );


                    console.log(
                        'ASET PAGE: database kosong → menggunakan dummy',
                        this.asets
                    );

                }


                this.updateMap();


            } catch (error) {

                console.error(
                    'ASET PAGE: API error',
                    error
                );


                /*
                 * Jika API gagal,
                 * jangan membuat halaman kosong.
                 *
                 * Gunakan data dummy.
                 */

                this.asets =
                    this.filterDummyAssets(
                        filters
                    );


                console.log(
                    'ASET PAGE: menggunakan fallback dummy',
                    this.asets
                );


                this.updateMap();


            } finally {

                this.loading = false;

            }

        },


        /* =====================================================
           FILTER DATA DUMMY
        ====================================================== */

        filterDummyAssets(filters = {}) {

            return this.dummyAssets.filter(item => {


                /*
                 * PROVINSI
                 */

                if (
                    filters.provinsi &&
                    item.provinsi !==
                    filters.provinsi
                ) {

                    return false;

                }


                /*
                 * LUAS MINIMUM
                 */

                if (
                    filters.luas_min &&
                    Number(item.luas_hektar) <
                    Number(filters.luas_min)
                ) {

                    return false;

                }


                /*
                 * LUAS MAKSIMUM
                 */

                if (
                    filters.luas_max &&
                    Number(item.luas_hektar) >
                    Number(filters.luas_max)
                ) {

                    return false;

                }


                /*
                 * PERUNTUKAN
                 */

                if (
                    filters.peruntukan &&
                    item.peruntukan !==
                    filters.peruntukan
                ) {

                    return false;

                }


                /*
                 * SKEMA
                 */

                if (
                    filters.skema &&
                    item.skema !==
                    filters.skema
                ) {

                    return false;

                }


                return true;

            });

        },


        /* =====================================================
           APPLY FILTER
        ====================================================== */

        async applyFilter() {

            console.log(
                'ASET PAGE: apply filter',
                this.filters
            );


            await this.fetchAset(
                this.filters
            );

        },


        /* =====================================================
           RESET FILTER
        ====================================================== */

        async resetFilter() {

            this.filters = {

                provinsi: '',

                luas_min: '',

                luas_max: '',

                peruntukan: '',

                skema: ''

            };


            await this.fetchAset(
                this.filters
            );

        },


        /* =====================================================
           UPDATE MAP
        ====================================================== */

        updateMap() {

            /*
             * Pastikan map tersedia
             */

            if (!this.map) {

                console.warn(
                    'ASET PAGE: map belum tersedia'
                );

                return;

            }


            /*
             * Bersihkan marker lama
             */

            this.clearMarkers();


            /*
             * Data yang ditampilkan
             *
             * Bisa berasal dari:
             * - database
             * - dummy
             */

            const assets =
                Array.isArray(this.asets) ?
                this.asets :
                [];


            if (assets.length === 0) {

                console.log(
                    'ASET PAGE: tidak ada data untuk map'
                );

                return;

            }


            console.log(
                'ASET PAGE: update map',
                assets
            );


            /*
             * Buat marker
             */

            assets.forEach(item => {

                const lat =
                    Number(item.lat);

                const lng =
                    Number(item.lng);


                /*
                 * Skip jika koordinat tidak valid
                 */

                if (
                    !Number.isFinite(lat) ||
                    !Number.isFinite(lng)
                ) {

                    console.warn(
                        'Koordinat tidak valid:',
                        item
                    );

                    return;

                }


                /*
                 * WARNA MARKER
                 */

                let markerColor =
                    '#006400';


                if (
                    item.status ===
                    'Dalam Pengembangan'
                ) {

                    markerColor =
                        '#2563EB';

                }


                if (
                    item.status ===
                    'Dalam Proses'
                ) {

                    markerColor =
                        '#F97316';

                }


                /*
                 * CUSTOM MARKER
                 */

                const markerIcon =
                    L.divIcon({

                        className: 'asset-map-marker',

                        html: `
                            <div style="
                                width:20px;
                                height:20px;
                                background:${markerColor};
                                border:3px solid white;
                                border-radius:50%;
                                box-shadow:
                                    0 2px 8px rgba(0,0,0,.35);
                            "></div>
                        `,

                        iconSize: [
                            20,
                            20
                        ],

                        iconAnchor: [
                            10,
                            10
                        ],

                        popupAnchor: [
                            0,
                            -10
                        ]

                    });


                /*
                 * MARKER
                 */

                const marker =
                    L.marker(
                        [lat, lng], {
                            icon: markerIcon
                        }
                    ).addTo(this.map);


                /*
                 * POPUP
                 */

                marker.bindPopup(`

                    <div style="
                        min-width:230px;
                        font-family:Inter,sans-serif;
                    ">

                        <div style="
                            font-size:15px;
                            font-weight:700;
                            color:#111827;
                            margin-bottom:6px;
                        ">
                            ${item.nama_lokasi ?? 'Aset Tanah'}
                        </div>


                        <div style="
                            font-size:11px;
                            color:#6B7280;
                            margin-bottom:12px;
                        ">

                            <i class="fas fa-location-dot"></i>

                            ${item.kabupaten ?? ''},
                            ${item.provinsi ?? ''}

                        </div>


                        <div style="
                            background:#F0FDF4;
                            padding:10px;
                            border-radius:7px;
                            margin-bottom:10px;
                        ">

                            <div style="
                                font-size:9px;
                                color:#6B7280;
                                text-transform:uppercase;
                            ">
                                Total Luas
                            </div>


                            <div style="
                                font-size:14px;
                                font-weight:700;
                                color:#006400;
                            ">

                                ${this.formatNumber(
                                    item.luas_hektar
                                )} Ha

                            </div>

                        </div>


                        <div style="
                            font-size:11px;
                            line-height:1.8;
                            color:#4B5563;
                        ">

                            <strong>
                                Peruntukan:
                            </strong>

                            ${item.peruntukan ?? '-'}

                            <br>

                            <strong>
                                Skema:
                            </strong>

                            ${item.skema ?? '-'}

                            <br>

                            <strong>
                                Status:
                            </strong>

                            ${item.status ?? '-'}

                        </div>


                        <div style="
                            margin-top:12px;
                            padding:6px;
                            text-align:center;
                            background:#FFF7ED;
                            color:#C2410C;
                            border-radius:5px;
                            font-size:9px;
                        ">

                            Data demonstrasi

                        </div>

                    </div>

                `);


                this.markers.push(
                    marker
                );

            });


            /*
             * FIT MAP
             * ke seluruh marker
             */

            const validAssets =
                assets.filter(item => {

                    const lat =
                        Number(item.lat);

                    const lng =
                        Number(item.lng);


                    return (
                        Number.isFinite(lat) &&
                        Number.isFinite(lng)
                    );

                });


            if (
                validAssets.length > 0
            ) {

                const bounds =
                    L.latLngBounds(
                        validAssets.map(
                            item => [
                                Number(item.lat),
                                Number(item.lng)
                            ]
                        )
                    );


                this.map.fitBounds(
                    bounds, {
                        padding: [
                            30,
                            30
                        ],

                        maxZoom: 6
                    }
                );

            }

        },


        /* =====================================================
           CLEAR MARKERS
        ====================================================== */

        clearMarkers() {

            if (!this.map) {

                return;

            }


            this.markers.forEach(
                marker => {

                    this.map.removeLayer(
                        marker
                    );

                }
            );


            this.markers = [];

        },


        /* =====================================================
           NUMBER FORMAT
        ====================================================== */

        formatNumber(num) {

            if (
                num === null ||
                num === undefined ||
                num === ''
            ) {

                return '0,00';

            }


            return parseFloat(num)
                .toLocaleString(
                    'id-ID', {
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2
                    }
                );

        }

    };

}


/* =========================================================
   ALPINE
   ========================================================= */

window.asetPage = asetPage;