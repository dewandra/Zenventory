import './bootstrap';

import 'sweetalert2/dist/sweetalert2.min.css';
import Swal from 'sweetalert2';
window.Swal = Swal; 


import Alpine from 'alpinejs';
window.Alpine = Alpine;
Alpine.start();


document.addEventListener('livewire:init', () => {
    Livewire.on('alert', (data) => {
        Swal.fire({
            icon: data[0].type,
            title: data[0].message,
            showConfirmButton: false,
            timer: data[0].timer ?? 3000
        });
    });

        Livewire.on('close-modal', () => {
        // Menemukan komponen Alpine terdekat dan mengubah state 'isOpen' menjadi false
        const alpineComponent = document.querySelector('[x-data]');
        if (alpineComponent && alpineComponent.__x) {
            alpineComponent.__x.data.isOpen = false;
        }
    });
});