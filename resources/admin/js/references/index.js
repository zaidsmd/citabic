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

// Helper for opening social popup window centered
function openSocialPopup(url, title, w = 600, h = 650) {
    const left = (window.innerWidth / 2) - (w / 2) + window.screenLeft;
    const top = (window.innerHeight / 2) - (h / 2) + window.screenTop;
    const popup = window.open(url, title, `scrollbars=yes,width=${w},height=${h},top=${top},left=${left}`);
    if (popup && window.focus) {
        popup.focus();
    }
}

// 1-Click Social Popup trigger from table buttons
$(document).on('click', '.btn-share-popup, .btn-social-share', function(e) {
    e.preventDefault();
    const url = $(this).attr('href');
    if (!url || url === '#' || url === 'javascript:void(0)') return;
    const platform = $(this).data('platform') || 'SocialShare';
    openSocialPopup(url, platform);
});

// Open Share Modal
$(document).on('click', '.btn-open-share-modal', function() {
    const $btn = $(this);
    const url = $btn.data('url') || '';
    const title = $btn.data('title') || '';
    const client = $btn.data('client') ? ` (Client : ${$btn.data('client')})` : '';
    let caption = $btn.data('caption');

    if (!caption) {
        // Fallback: strip any HTML from summary
        const rawSummary = String($btn.data('summary') || '');
        const tmp = document.createElement('div');
        tmp.innerHTML = rawSummary;
        const cleanSummary = (tmp.textContent || tmp.innerText || '').replace(/\s+/g, ' ').trim();
        const summaryText = cleanSummary ? `\n\n${cleanSummary}` : '';
        caption = `Découvrez notre réalisation : ${title}${client}.${summaryText}\n\n👉 ${url}\n\n#CITABIC #Architecture #GénieCivil #Construction #Maroc`;
    }

    const fbUrl = $btn.data('fb') || `https://www.facebook.com/sharer/sharer.php?u=${encodeURIComponent(url)}`;
    const liUrl = $btn.data('li') || `https://www.linkedin.com/sharing/share-offsite/?url=${encodeURIComponent(url)}`;

    $('#shareReferenceUrl').val(url);
    $('#shareCaption').val(caption);
    $('#btnPublishFacebook').attr('href', fbUrl);
    $('#btnPublishLinkedin').attr('href', liUrl);

    const modalEl = document.getElementById('socialShareModal');
    if (modalEl && window.bootstrap) {
        const modal = bootstrap.Modal.getInstance(modalEl) || new bootstrap.Modal(modalEl);
        modal.show();
    }
});

// Copy Caption Button
$(document).on('click', '#btnCopyShareCaption', function() {
    const text = $('#shareCaption').val();
    if (navigator.clipboard) {
        navigator.clipboard.writeText(text).then(() => {
            const $label = $('#copyCaptionText');
            const original = $label.text();
            $label.text('✓ Copié !');
            setTimeout(() => $label.text(original), 2500);
        });
    }
});

// Copy URL Button
$(document).on('click', '#btnCopyShareUrl', function() {
    const text = $('#shareReferenceUrl').val();
    if (navigator.clipboard) {
        navigator.clipboard.writeText(text).then(() => {
            const $btn = $(this);
            $btn.html('<i class="ti ti-check text-success"></i>');
            setTimeout(() => $btn.html('<i class="ti ti-copy"></i>'), 2000);
        });
    }
});
