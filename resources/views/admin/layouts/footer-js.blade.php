<!-- Required Js -->
<script src="/build/js/plugins/popper.min.js"></script>
<script src="/build/js/plugins/simplebar.min.js"></script>
<script src="/build/js/plugins/bootstrap.min.js"></script>
<script src="/build/js/plugins/i18next.min.js"></script>
<script src="/build/js/plugins/i18nextHttpBackend.min.js"></script>
<script src="/build/js/icon/custom-font.js"></script>
<script src="/build/js/script.js"></script>
<script src="/build/js/theme.js"></script>
<script src="/build/js/multi-lang.js"></script>
<script src="/build/js/plugins/feather.min.js"></script>
<script src="/build/js/plugins/sweetalert2.all.min.js"></script>
@if (config('app.dark_layout') != "")
<script>
  layout_change("{{config('app.dark_layout')}}");
</script>
@endif
@if (config('app.theme_contrast') != '')
<script>
  layout_theme_contrast_change("{{config('app.theme_contrast')}}");
</script>
@endif
@if (config('app.box_container') != '')
<script>
  change_box_container("{{config('app.box_container')}}");
</script>
@endif
@if (config('app.caption_show') != '')
<script>
  layout_caption_change("{{config('app.caption_show')}}");
</script>
@endif
@if (config('app.rtl_layout') != '')
<script>
  layout_rtl_change("{{config('app.rtl_layout')}}");
</script>
@endif
@if (config('app.preset_theme') != "")
<script>
  preset_change("{{config('app.preset_theme')}}");
</script>
@endif
@if (config('app.theme_layout') == 'default')
<script>
  main_layout_change('default');
</script>
@elseif(config('app.theme_layout') != "")
<script>
  main_layout_change('dark');
</script>
@endif

<script>
    document.addEventListener('DOMContentLoaded', function () {
        if (typeof window.jQuery === 'undefined' || typeof $.fn.DataTable === 'undefined') {
            return;
        }

        const locale = @json(app()->getLocale());
        window.appLocale = locale;
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
                last: 'Last',
            },
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
                last: 'Dernier',
            },
        };

        const language = String(locale).toLowerCase().startsWith('fr') ? frenchLanguage : defaultLanguage;
        $.extend(true, $.fn.dataTable.defaults, { language });
    });
</script>

<script>
    document.addEventListener('click', function (e) {
        const el = e.target.closest('[data-table-action="delete"]');
        if (!el) return;
        e.preventDefault();
        const url = el.dataset.href || el.dataset.url;
        if (!url) return;

        const i18n = {
            title: @json(__('Are you sure?')),
            text: @json(__('You will not be able to revert this action.')),
            confirm: @json(__('Yes, delete it!')),
            cancel: @json(__('Cancel')),
            successTitle: @json(__('Success')),
            successText: @json(__('Deleted successfully.')),
            errorTitle: @json(__('Error')),
            errorText: @json(__('Something went wrong while processing your request.'))
        };

        Swal.fire({
            title: i18n.title,
            text: i18n.text,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: i18n.confirm,
            cancelButtonText: i18n.cancel,
            buttonsStyling: false,
            customClass: {
                confirmButton: 'btn btn-light-danger mx-2',
                cancelButton: 'btn btn-light-secondary mx-2',
            },
            didOpen: () => $('.btn').blur(),
        }).then(async (result) => {
            if (!result.isConfirmed) {
                return;
            }

            try {
                const response = await fetch(url, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': @json(csrf_token()),
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json',
                    },
                });

                if (!response.ok) {
                    throw new Error('Request failed');
                }

                await Swal.fire({
                    title: i18n.successTitle,
                    text: i18n.successText,
                    icon: 'success',
                    buttonsStyling: false,
                    confirmButtonText: 'OK',
                    customClass: {
                        confirmButton: 'btn btn-soft-success mx-2',
                    },
                });

                location.reload();
            } catch (_) {
                Swal.fire({
                    title: i18n.errorTitle,
                    text: i18n.errorText,
                    icon: 'error',
                    buttonsStyling: false,
                    confirmButtonText: 'OK',
                    customClass: {
                        confirmButton: 'btn btn-soft-danger mx-2',
                    },
                });
            }
        });
    });
</script>
