import './bootstrap';

import 'sweetalert2/dist/sweetalert2.min.css';
import Swal from 'sweetalert2';
window.Swal = Swal; 

document.addEventListener('livewire:init', () => {
    Livewire.on('alert', (data) => {
        Swal.fire({
            icon: data[0].type,
            title: data[0].message,
            showConfirmButton: false,
            timer: data[0].timer ?? 3000
        });
    });

        Livewire.on('show-delete-confirmation', (id) => { // <-- Terima 'id' langsung
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Anda tidak akan bisa mengembalikan data ini!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                // Kirim 'id' kembali ke server secara langsung
                Livewire.dispatch('delete-confirmed', id);
            }
        });
    });
});