import './bootstrap';

import 'sweetalert2/dist/sweetalert2.min.css';
import Swal from 'sweetalert2';
window.Swal = Swal; 


document.addEventListener('livewire:init', () => {
    Livewire.on('alert', (data) => {
        // Ambil data dari event
        const alertType = data[0].type;
        const alertMessage = data[0].message;

        // Buat instance Toast yang bisa dipakai ulang
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end', // Posisi di pojok kanan atas
            showConfirmButton: false,
            timer: data[0].timer ?? 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.onmouseenter = Swal.stopTimer;
                toast.onmouseleave = Swal.resumeTimer;
            },
            // Terapkan class CSS custom
            customClass: {
                popup: `colored-toast ${alertType}-toast`
            },
            iconColor: 'white' // Ubah warna ikon default menjadi putih
        });

        // Tampilkan toast
        Toast.fire({
            icon: alertType,
            title: alertMessage
        });
    });

Livewire.on('show-delete-confirmation', (id) => {
        Swal.fire({
            // Konten
            title: 'Apakah Anda yakin?',
            text: "Data yang dihapus tidak dapat dikembalikan!",
            icon: 'warning',

            // Tombol
            showCancelButton: true,
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal',

            // Pengaturan Desain Modern
            reverseButtons: true,
            focusCancel: true,
            buttonsStyling: false, // Wajib false untuk menerapkan class custom

            // Class CSS Custom untuk Styling Total
            customClass: {
                popup: 'custom-swal-popup',
                header: 'custom-swal-header',
                title: 'custom-swal-title',
                icon: 'custom-swal-icon',
                confirmButton: 'swal-confirm-button', // Class ini sudah kita buat sebelumnya
                cancelButton: 'swal-cancel-button'   // Class ini juga sudah ada
            }

        }).then((result) => {
            if (result.isConfirmed) {
                Livewire.dispatch('delete-confirmed', id);
            }
        });
    });
});