import { initDataTable } from '../datatable.js';

const referencesColumns = [
    { data: 'image_preview', orderable: false, searchable: false ,width: '1%'},
    { data: 'title' },
    { data: 'client' },
    { data: 'slug' },
    { data: 'actions', orderable: false, searchable: false, className: 'text-end' },
];

initDataTable({
    ajaxUrl: '/admins/references',
    tableId: '#references-table',
    columns: referencesColumns,
    language: localStorage.getItem('lang') || 'fr',
});
