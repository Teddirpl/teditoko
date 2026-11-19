@extends('layouts.app')

@section('title', 'Customer Service')

@section('content')
<div class='space-y-8'>
    {{-- Header --}}
    <div class='bg-white rounded-lg shadow-md p-6 text-center'>
        <h2 class='text-2xl font-bold text-gray-800'>Customer Service</h2>
        <p class='text-gray-500 mt-2'>
            Ada pertanyaan seputar produk, pesanan, atau kendaraan Anda?
            Tim CS Toko Komputer siap membantu.
        </p>
    </div>

    {{-- Kontak cepat --}}
    <div class='grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4'>
        <div class='bg-white rounded-lg shadow-md p-4 text-center'>
            <p class='text-2xl'>&#128222;</p>
            <h3 class='font-bold mt-1'>WhatsApp</h3>
            <p class='text-gray-500 text-sm mt-1'>0812-3456-7890</p>
            <a href='https://wa.me/6281234567890'
               class='inline-block bg-green-600 text-white text-sm px-4 py-1.5 rounded mt-2 hover:bg-green-700'>
                Chat Sekarang
            </a>
        </div>
        <div class='bg-white rounded-lg shadow-md p-4 text-center'>
            <p class='text-2xl'>&#128231;</p>
            <h3 class='font-bold mt-1'>Email</h3>
            <p class='text-gray-500 text-sm mt-1'>cs@tokokomputer.com</p>
            <p class='text-gray-400 text-xs mt-2'>Dibalas maks. 1x24 jam</p>
        </div>
        <div class='bg-white rounded-lg shadow-md p-4 text-center'>
            <p class='text-2xl'>&#128336;</p>
            <h3 class='font-bold mt-1'>Jam Operasional</h3>
            <p class='text-gray-500 text-sm mt-1'>Senin - Sabtu</p>
            <p class='text-gray-500 text-sm'>08.00 - 17.00 WIB</p>
            <p class='text-gray-400 text-xs mt-1'>Minggu & libur nasional tutup</p>
        </div>
        <div class='bg-white rounded-lg shadow-md p-4 text-center'>
            <p class='text-2xl'>&#128205;</p>
            <h3 class='font-bold mt-1'>Toko</h3>
            <p class='text-gray-500 text-sm mt-1'>Jl. Komputer Raya No. 1</p>
            <p class='text-gray-500 text-sm'>Indonesia</p>
        </div>
    </div>

    {{-- Form kirim pesan ke CS --}}
    <div class='bg-white rounded-lg shadow-md p-6'>
        <h3 class='text-xl font-bold mb-1'>Kirim Pesan ke CS</h3>
        <p class='text-gray-500 text-sm mb-4'>
            Isi form di bawah ini, pesan Anda langsung masuk ke tim CS kami.
        </p>
        <form action='{{ route('cs.store') }}' method='POST' class='space-y-4'>
            @csrf
            <div class='grid grid-cols-1 md:grid-cols-2 gap-4'>
                <div>
                    <label class='block text-sm font-medium mb-1'>Nama <span class='text-red-600'>*</span></label>
                    <input type='text' name='nama' required
                           value='{{ $defaultNama }}'
                           placeholder='Nama Anda'
                           class='w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500'>
                </div>
                <div>
                    <label class='block text-sm font-medium mb-1'>Email <span class='text-red-600'>*</span></label>
                    <input type='email' name='email' required
                           value='{{ $defaultEmail }}'
                           placeholder='email@contoh.com'
                           class='w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500'>
                </div>
                <div>
                    <label class='block text-sm font-medium mb-1'>No. WhatsApp</label>
                    <input type='text' name='whatsapp'
                           value='{{ old('whatsapp') }}'
                           placeholder='08xxxxxxxxxx (opsional)'
                           class='w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500'>
                </div>
                <div>
                    <label class='block text-sm font-medium mb-1'>Subjek</label>
                    <select name='subjek'
                            class='w-full border rounded px-3 py-2 bg-white focus:outline-none focus:ring-2 focus:ring-blue-500'>
                        @foreach(['Pertanyaan Produk', 'Status Pesanan', 'Komplain/Kerusakan', 'Saran', 'Lainnya'] as $opsi)
                            <option value='{{ $opsi }}'
                                @if(old('subjek') === $opsi) selected @endif>
                                {{ $opsi }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div>
                <label class='block text-sm font-medium mb-1'>Nomor Pesanan (TRX-xxxx)</label>
                <input type='text' name='id_pembelian'
                       value='{{ request('pesanan', old('id_pembelian')) }}'
                       placeholder='Contoh: TRX-AbCd1234 (kosongkan bila tidak ada)'
                       class='w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500'>
            </div>
            <div>
                <label class='block text-sm font-medium mb-1'>Pesan <span class='text-red-600'>*</span></label>
                <textarea name='pesan' rows='4' required
                          placeholder='Tuliskan pertanyaan atau keluhan Anda...'
                          class='w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500'>{{ old('pesan') }}</textarea>
            </div>
            <button type='submit'
                    class='bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700'>
                Kirim Pesan
            </button>
        </form>
    </div>

    {{-- FAQ --}}
    <div class='bg-white rounded-lg shadow-md p-6'>
        <h3 class='text-xl font-bold mb-4'>Pertanyaan yang Sering Diajukan (FAQ)</h3>
        <div class='space-y-3'>
            <details class='border rounded p-3'>
                <summary class='font-medium cursor-pointer'>Bagaimana status pesanan saya berubah?</summary>
                <p class='text-gray-600 text-sm mt-2'>
                    Pesanan berproses: Verifikasi &rarr; Proses &rarr; Kirim &rarr; Sampai &rarr; Selesai.
                    Cek perubahan status di menu <a href='{{ route('pesanan') }}' class='text-blue-600 hover:underline'>Pesanan</a>.
                </p>
            </details>
            <details class='border rounded p-3'>
                <summary class='font-medium cursor-pointer'>Barang yang dikirim rusak / tidak sesuai, bagaimana?</summary>
                <p class='text-gray-600 text-sm mt-2'>
                    Segera hubungi kami melalui form di atas dengan subjek
                    <strong>Komplain/Kerusakan</strong> dan sertakan nomor pesanan (TRX-xxxx)
                    beserta foto kondisi barang. Klaim komplain maksimal 3 hari setelah barang diterima.
                </p>
            </details>
            <details class='border rounded p-3'>
                <summary class='font-medium cursor-pointer'>Apakah bisa tanya-tanya dulu sebelum membeli?</summary>
                <p class='text-gray-600 text-sm mt-2'>
                    Tentu bisa. Pilih subjek <strong>Pertanyaan Produk</strong> di form di atas,
                    atau chat langsung melalui WhatsApp pada jam operasional.
                </p>
            </details>
            <details class='border rounded p-3'>
                <summary class='font-medium cursor-pointer'>Apakah harus login untuk menghubungi CS?</summary>
                <p class='text-gray-600 text-sm mt-2'>
                    Tidak harus. Pengunjung yang belum login tetap bisa mengirim pesan
                    dengan mencantumkan nama dan email. Namun jika login, data Anda
                    terisi otomatis dan tim CS dapat mengecek pesanan Anda lebih cepat.
                </p>
            </details>
        </div>
    </div>
</div>
@endsection
