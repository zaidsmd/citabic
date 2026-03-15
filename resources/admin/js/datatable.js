/**
 * Initialize a DataTable with Yajra integration
 * @param {Object} config - Configuration object
 * @param {string} config.ajaxUrl - API endpoint URL
 * @param {Array} config.columns - Column definitions
 * @param {Object} [config.filters] - Filter input selectors
 * @param {string} [config.triggerButtonId] - Button to trigger reload
 * @param {string} [config.tableId='#dataTable'] - Table element ID
 * @param {Object} [config.language] - Language configuration
 * @param {Object} [config.options] - Additional DataTable options
 */

const defaultLanguage = {
    processing: 'Processing...',
    search: 'Search:',
    lengthMenu: 'Show _MENU_ entries',
    info: 'Showing _START_ to _END_ of _TOTAL_ entries',
    infoEmpty: 'Showing 0 to 0 of 0 entries',
    infoFiltered: '(filtered from _MAX_ total entries)',
    loadingRecords: 'Loading...',
    zeroRecords: 'No matching records found',
    emptyTable: 'No data available in table',
    paginate: {
        first: 'First',
        previous: 'Previous',
        next: 'Next',
        last: 'Last'
    }
};

const frenchLanguage = {
    processing: 'Traitement...',
    search: 'Rechercher:',
    lengthMenu: 'Afficher _MENU_ elements',
    info: 'Affichage de _START_ a _END_ sur _TOTAL_ elements',
    infoEmpty: 'Affichage de 0 a 0 sur 0 element',
    infoFiltered: '(filtre a partir de _MAX_ elements au total)',
    loadingRecords: 'Chargement...',
    zeroRecords: 'Aucun element correspondant trouve',
    emptyTable: 'Aucune donnee disponible dans le tableau',
    paginate: {
        first: 'Premier',
        previous: 'Precedent',
        next: 'Suivant',
        last: 'Dernier'
    }
};

const resolveLanguagePack = (language) => {
    if (language && typeof language === 'object') {
        return language;
    }

    return language === 'fr' ? frenchLanguage : defaultLanguage;
};


export const initDataTable = ({
                                  ajaxUrl,
                                  columns,
                                  filters = {},
                                  triggerButtonId,
                                  tableId = '#dataTable',
                                  language = 'en',
                                  customOptions = {}
                              }) => {
    const languagePack = resolveLanguagePack(language);

    const table = $(tableId).DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        ajax: {
            url: ajaxUrl,
            type: 'GET',
            data: (d) => {
                // Add filter values
                Object.entries(filters).forEach(([key, selector]) => {
                    d[key] = $(selector).val();
                });

                // Allow custom data manipulation
                if (customOptions.beforeSend) {
                    customOptions.beforeSend(d);
                }
            },
            error: (xhr, error, thrown) => {
                console.error('DataTable error:', error);
                if (customOptions.onError) {
                    customOptions.onError(xhr, error, thrown);
                }
            }
        },
        columns: columns,
        language: languagePack,
        ...customOptions
    });

    // Handle row selection
    $(document).on('click', '#select-all-row', function() {
        const isChecked = this.checked;
        $(tableId)
            .find('tbody input.row-select')
            .prop('checked', isChecked)
            .trigger('change');
    });

    // Handle filter trigger
    if (triggerButtonId) {
        $(triggerButtonId).on('click', () => table.ajax.reload());
    }

    // Return table instance for further manipulation
    return table;
};
