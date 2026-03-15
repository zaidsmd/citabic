import { initDataTable } from '../datatable.js';

const certificationsColumns = [
    { data: 'image_preview', orderable: false, searchable: false },
    { data: 'name' },
    { data: 'description' },
    { data: 'actions', orderable: false, searchable: false, className: 'text-end' },
];

initDataTable({
    ajaxUrl: '/admins/certifications',
    tableId: '#certifications-table',
    columns: certificationsColumns
});
