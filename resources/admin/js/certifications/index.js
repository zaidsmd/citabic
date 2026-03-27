import { initDataTable } from '../datatable.js';

const certificationsColumns = [
    { data: 'image_preview', orderable: false, searchable: false ,width: '1%'},
    { data: 'name' },
    { data: 'description' },
    { data: 'actions', orderable: false, searchable: false, className: 'text-end' },
];

initDataTable({
    ajaxUrl: '/admins/certifications',
    tableId: '#certifications-table',
    columns: certificationsColumns,
    language: localStorage.getItem('lang') || 'fr',
});
