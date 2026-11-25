document.querySelectorAll('[data-password-toggle]').forEach((button) => {
    const inputId = button.getAttribute('aria-controls');
    const input = inputId ? document.getElementById(inputId) : null;

    if (!(button instanceof HTMLButtonElement) || !(input instanceof HTMLInputElement)) {
        return;
    }

    button.addEventListener('click', () => {
        const isVisible = input.type === 'password';

        input.type = isVisible ? 'text' : 'password';
        button.setAttribute('aria-pressed', String(isVisible));
        button.setAttribute('aria-label', isVisible ? 'Sembunyikan kata sandi' : 'Tampilkan kata sandi');
        button.querySelector('[data-password-visible-icon]').classList.toggle('hidden', !isVisible);
        button.querySelector('[data-password-hidden-icon]').classList.toggle('hidden', isVisible);
    });
});

const sidebar = document.querySelector('[data-mobile-sidebar]');
const sidebarBackdrop = document.querySelector('[data-sidebar-backdrop]');

document.querySelectorAll('[data-sidebar-toggle]').forEach((button) => {
    button.addEventListener('click', () => {
        sidebar?.classList.toggle('-translate-x-full');
        sidebarBackdrop?.classList.toggle('hidden');
    });
});

sidebarBackdrop?.addEventListener('click', () => {
    sidebar?.classList.add('-translate-x-full');
    sidebarBackdrop.classList.add('hidden');
});
