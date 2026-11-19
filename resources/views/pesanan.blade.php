@extends('layouts.app')

@section('title', 'Pesanan Saya')

@section('content')
<div class='space-y-6'>
    <div class='flex flex-wrap justify-between items-center gap-3'>
        <h2 class='text-2xl font-bold text-gray-800'>Pesanan Saya</h2>
        <a href='{{ route('homeproduk') }}'
           class='bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700'>
            + Belanja Lagi
        </a>
    </div>

    {{-- Ringkasan --}}
    <div class='grid grid-cols-1 sm:grid-cols-3 gap-4'>
        <div class='bg-white rounded-lg shadow-md p-4 text-center'>
            <p class='text-gray-500 text-sm'>Total Transaksi</p>
            <p class='text-2xl font-bold text-blue-600'>{{ $totalTransaksi }}</p>
        </div>
        <div class='bg-white rounded-lg shadow-md p-4 text-center'>
            <p class='text-gray-500 text-sm'>Total Item Dibeli</p>
            <p class='text-2xl font-bold text-blue-600'>{{ $totalItem }}</p>
        </div>
        <div class='bg-white rounded-lg shadow-md p-4 text-center'>
            <p class='text-gray-500 text-sm'>Total Belanja</p>
            <p class='text-2xl font-bold text-blue-600'>
                Rp {{ number_format($totalBelanja, 0, ',', '.') }}
            </p>
        </div>
    </div>

    {{-- Daftar pesanan --}}
    @forelse($pembelians as $pembelian)
        <div class='bg-white rounded-lg shadow-md p-4'>
            <div class='flex flex-wrap justify-between items-center gap-2 border-b pb-3 mb-3'>
                <div>
                    <span class='font-bold text-gray-800'>{{ $pembelian->id_pembelian }}</span>
                    <span class='text-gray-400'> | </span>
                    <span class='text-gray-500 text-sm'>
                        {{ $pembelian->tanggal_transaksi->format('d-m-Y H:i') }}
                    </span>
                </div>
                @if($pembelian->status === 'Selesai')
                    <span class='bg-green-100 text-green-700 px-3 py-1 rounded-full text-sm font-medium'>
                        {{ $pembelian->status }}
                    </span>
                @elseif($pembelian->status === 'Kirim')
                    <span class='bg-indigo-100 text-indigo-700 px-3 py-1 rounded-full text-sm font-medium'>
                        {{ $pembelian->status }}
                    </span>
                @elseif($pembelian->status === 'Sampai')
                    <span class='bg-cyan-100 text-cyan-700 px-3 py-1 rounded-full text-sm font-medium'>
                        {{ $pembelian->status }}
                    </span>
                @elseif($pembelian->status === 'Proses')
                    <span class='bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-sm font-medium'>
                        {{ $pembelian->status }}
                    </span>
                @else
                    <span class='bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-sm font-medium'>
                        {{ $pembelian->status }}
                    </span>
                @endif
            </div>

            <div class='flex flex-wrap items-center gap-4'>
                <img src='{{ $pembelian->produk->gambar ?? asset('img/default.png') }}'
                     alt='{{ $pembelian->produk->nama_produk ?? $pembelian->kode_produk }}'
                     class='w-20 h-20 object-cover rounded'>
                <div class='flex-1 min-w-[200px]'>
                    <h3 class='font-bold'>
                        {{ $pembelian->produk->nama_produk ?? $pembelian->kode_produk }}
                    </h3>
                    <p class='text-gray-500 text-sm'>
                        Kode: {{ $pembelian->kode_produk }}
                        @if($pembelian->produk?->brand)
                            | Brand: {{ $pembelian->produk->brand->nama_brand }}
                        @endif
                    </p>
                    <p class='text-gray-600 text-sm'>Jumlah: {{ $pembelian->jumlah }} pcs</p>
                </div>
                <div class='text-right'>
                    <p class='text-gray-500 text-sm'>Total Bayar</p>
                    <p class='text-xl font-bold text-blue-600'>
                        Rp {{ number_format($pembelian->total_bayar, 0, ',', '.') }}
                    </p>
                </div>
            </div>

            <div class='border-t pt-3 mt-3 text-sm'>
                <a href='{{ route('cs') }}?pesanan={{ $pembelian->id_pembelian }}'
                   class='text-blue-600 hover:underline'>
                    Ada masalah dengan pesanan ini? Hubungi CS
                </a>
            </div>
        </div>
    @empty
        <div class='bg-white rounded-lg shadow-md p-10 text-center'>
            <p class='text-gray-500 text-lg mb-4'>
                Anda belum memiliki pesanan.
            </p>
            <a href='{{ route('homeproduk') }}'
               class='bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700'>
                Lihat Sparepart
            </a>
        </div>
    @endforelse
</div>
@endsection
