import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

// Mount React mobile page when #root exists
if (document.getElementById('root')) {
    import('./mobile.jsx');
}
