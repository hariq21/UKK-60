import 'bootstrap/dist/js/bootstrap.bundle.min.js';
import { DataTable } from 'simple-datatables';
import 'simple-datatables/dist/style.css';

document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.js-datatable').forEach((tableElement) => {
        new DataTable(tableElement, {
            searchable: false,
            sortable: false,
            perPage: 10,
            perPageSelect: false,
            labels: {
                perPage: '{select} data per halaman',
                noRows: 'Data tidak ditemukan',
                info: 'Menampilkan {start} sampai {end} dari {rows} data',
            },
        });
    });
});
