import { initDataTable } from '../datatable.js';

const processesColumns = [
    { data: 'title', orderable: false, searchable: false ,width: '1%'},
    { data: 'description' },
    { data: 'actions', orderable: false, searchable: false, className: 'text-end' },
];

initDataTable({
    ajaxUrl: '/admins/processes',
    tableId: '#processes-table',
    columns: processesColumns,
    language: localStorage.getItem('lang') || 'fr',
});
