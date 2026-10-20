-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 10 Sep 2026 pada 03.48
-- Versi server: 10.4.6-MariaDB
-- Versi PHP: 7.3.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ahaha`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `anggota`
--

CREATE TABLE `anggota` (
  `id_anggota` int(11) UNSIGNED NOT NULL,
  `kode_anggota` varchar(20) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `jenis_kelamin` enum('pria','wanita') NOT NULL,
  `telp` varchar(12) DEFAULT NULL,
  `alamat` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `anggota`
--

INSERT INTO `anggota` (`id_anggota`, `kode_anggota`, `nama`, `jenis_kelamin`, `telp`, `alamat`) VALUES
(1, 'AGT001', 'Alif', 'pria', '081234567890', 'Bandung'),
(2, 'AGT002', 'Amel', 'wanita', '082345678901', 'Cimahi'),
(3, 'AGT003', 'Finjol', 'pria', '083456789012', 'Bandung');

-- --------------------------------------------------------

--
-- Struktur dari tabel `buku`
--

CREATE TABLE `buku` (
  `id_buku` int(11) UNSIGNED NOT NULL,
  `kode_buku` varchar(20) NOT NULL,
  `judul_buku` varchar(255) NOT NULL,
  `kategori` varchar(100) NOT NULL,
  `penerbit` varchar(100) NOT NULL,
  `pengarang` varchar(150) DEFAULT NULL,
  `stok` varchar(3) DEFAULT NULL,
  `tahun_terbit` int(4) DEFAULT NULL,
  `sinopsis` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `buku`
--

INSERT INTO `buku` (`id_buku`, `kode_buku`, `judul_buku`, `kategori`, `penerbit`, `pengarang`, `stok`, `tahun_terbit`, `sinopsis`) VALUES
(1, 'BKU001', 'Kerajaan di Balik Kabut', 'Fiksi', 'Gramedia', 'Arka Pratama', '5', 2022, 'Seorang pemuda menemukan kerajaan misterius yang tersembunyi di balik kabut dan harus mengungkap rahasia kuno kerajaan tersebut.'),
(2, 'BKU002', 'Penyihir dari Menara Bulan', 'Fiksi', 'Mizan', 'Nara Wijaya', '4', 2023, 'Kisah seorang penyihir muda yang tinggal di menara bulan dan menghadapi kekuatan gelap yang mulai mengancam dunia.');
INSERT INTO `buku` (`id_buku`, `kode_buku`, `judul_buku`, `kategori`, `penerbit`, `pengarang`, `stok`, `tahun_terbit`, `sinopsis`) VALUES
(3, 'BKU003', 'Jejak Sejarah Nusantara', 'Sejarah', 'Mizan', 'Raka Wijaya', '3', 2021, 'Buku sejarah yang membahas perjalanan dan peninggalan penting Nusantara.');

-- --------------------------------------------------------

--
-- Struktur dari tabel `kategori`
--

CREATE TABLE `kategori` (
  `id_kategori` int(11) UNSIGNED NOT NULL,
  `kode_kategori` varchar(20) NOT NULL,
  `nama_kategori` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `kategori`
--

INSERT INTO `kategori` (`id_kategori`, `kode_kategori`, `nama_kategori`) VALUES
(1, 'KTG001', 'Fiksi'),
(2, 'KTG002', 'Teknologi'),
(3, 'KTG003', 'Sejarah');

-- --------------------------------------------------------

--
-- Struktur dari tabel `peminjaman`
--

CREATE TABLE `peminjaman` (
  `id_peminjaman` int(10) UNSIGNED NOT NULL,
  `tanggal_pinjam` date NOT NULL,
  `lama_pinjam` tinyint(3) UNSIGNED DEFAULT NULL,
  `keterangan` text DEFAULT NULL,
  `status` enum('dipinjam','sudah dikembalikan') NOT NULL DEFAULT 'dipinjam',
  `anggota_id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `peminjaman`
--

INSERT INTO `peminjaman` (`id_peminjaman`, `tanggal_pinjam`, `lama_pinjam`, `keterangan`, `status`, `anggota_id`, `user_id`) VALUES
(1, '2026-09-01', 7, 'Peminjaman buku untuk belajar', 'dipinjam', 1, 2),
(2, '2026-09-02', 5, 'Peminjaman buku pelajaran', 'dipinjam', 2, 2),
(3, '2026-09-03', 7, 'Peminjaman buku sejarah', 'sudah dikembalikan', 3, 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `peminjaman_detail`
--

CREATE TABLE `peminjaman_detail` (
  `id_pd` int(11) UNSIGNED NOT NULL,
  `peminjaman_id` int(11) UNSIGNED NOT NULL,
  `buku_id` int(11) UNSIGNED NOT NULL,
  `jumlah` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `peminjaman_detail`
--

INSERT INTO `peminjaman_detail` (`id_pd`, `peminjaman_id`, `buku_id`, `jumlah`) VALUES
(1, 1, 1, 1),
(2, 2, 2, 1),
(3, 3, 3, 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `penerbit`
--

CREATE TABLE `penerbit` (
  `id_penerbit` int(11) UNSIGNED NOT NULL,
  `kode_penerbit` varchar(20) NOT NULL,
  `nama_penerbit` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `penerbit`
--

INSERT INTO `penerbit` (`id_penerbit`, `kode_penerbit`, `nama_penerbit`) VALUES
(1, 'PNR001', 'Gramedia'),
(2, 'PNR002', 'Elex Media Komputindo'),
(3, 'PNR003', 'Mizan');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pengembalian`
--

CREATE TABLE `pengembalian` (
  `id_pengembalian` int(11) UNSIGNED NOT NULL,
  `peminjaman_id` int(11) UNSIGNED NOT NULL,
  `tanggal_kembali` date NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL,
  `denda` int(11) UNSIGNED NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `pengembalian`
--

INSERT INTO `pengembalian` (`id_pengembalian`, `peminjaman_id`, `tanggal_kembali`, `user_id`, `denda`) VALUES
(1, 3, '2026-09-08', 1, 0);

-- --------------------------------------------------------

--
-- Struktur dari tabel `user`
--

CREATE TABLE `user` (
  `id_user` int(11) UNSIGNED NOT NULL,
  `nama` varchar(100) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `role` enum('admin','petugas') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

ALTER TABLE `user` MODIFY `role` enum('admin','petugas','anggota') NOT NULL;
ALTER TABLE `user` ADD `anggota_id` int(11) UNSIGNED DEFAULT NULL AFTER `role`;

--
-- Dumping data untuk tabel `user`
--

INSERT INTO `user` (`id_user`, `nama`, `username`, `password`, `role`, `anggota_id`) VALUES
(1, 'AhA', 'aha', 'aha123', 'admin', NULL),
(2, 'Isee', 'isee', 'isee123', 'petugas', NULL),
(3, 'Akivili', 'akivili', 'akivili123', 'petugas', NULL),
(4, 'Alif', 'alif', 'alif123', 'anggota', 1),
(5, 'Amel', 'amel', 'amel123', 'anggota', 2),
(6, 'Finjol', 'finjol', 'finjol123', 'anggota', 3);

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `anggota`
--
ALTER TABLE `anggota`
  ADD PRIMARY KEY (`id_anggota`);

--
-- Indeks untuk tabel `buku`
--
ALTER TABLE `buku`
  ADD PRIMARY KEY (`id_buku`);

--
-- Indeks untuk tabel `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`id_kategori`);

--
-- Indeks untuk tabel `peminjaman`
--
ALTER TABLE `peminjaman`
  ADD PRIMARY KEY (`id_peminjaman`),
  ADD KEY `fk_peminjaman_anggota` (`anggota_id`),
  ADD KEY `fk_peminjaman_user` (`user_id`);

--
-- Indeks untuk tabel `peminjaman_detail`
--
ALTER TABLE `peminjaman_detail`
  ADD PRIMARY KEY (`id_pd`),
  ADD KEY `fk_detail_peminjaman` (`peminjaman_id`),
  ADD KEY `buku_id` (`buku_id`);

--
-- Indeks untuk tabel `penerbit`
--
ALTER TABLE `penerbit`
  ADD PRIMARY KEY (`id_penerbit`);

--
-- Indeks untuk tabel `pengembalian`
--
ALTER TABLE `pengembalian`
  ADD PRIMARY KEY (`id_pengembalian`),
  ADD KEY `fk_pengembalian_peminjaman` (`peminjaman_id`),
  ADD KEY `fk_pengembalian_user` (`user_id`);

--
-- Indeks untuk tabel `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `anggota`
--
ALTER TABLE `anggota`
  MODIFY `id_anggota` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `buku`
--
ALTER TABLE `buku`
  MODIFY `id_buku` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `kategori`
--
ALTER TABLE `kategori`
  MODIFY `id_kategori` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `peminjaman`
--
ALTER TABLE `peminjaman`
  MODIFY `id_peminjaman` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `peminjaman_detail`
--
ALTER TABLE `peminjaman_detail`
  MODIFY `id_pd` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `penerbit`
--
ALTER TABLE `penerbit`
  MODIFY `id_penerbit` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `pengembalian`
--
ALTER TABLE `pengembalian`
  MODIFY `id_pengembalian` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `peminjaman`
--
ALTER TABLE `peminjaman`
  ADD CONSTRAINT `fk_peminjaman_anggota` FOREIGN KEY (`anggota_id`) REFERENCES `anggota` (`id_anggota`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_peminjaman_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id_user`) ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `peminjaman_detail`
--
ALTER TABLE `peminjaman_detail`
  ADD CONSTRAINT `fk_detail_peminjaman` FOREIGN KEY (`peminjaman_id`) REFERENCES `peminjaman` (`id_peminjaman`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `pengembalian`
--
ALTER TABLE `pengembalian`
  ADD CONSTRAINT `fk_pengembalian_peminjaman` FOREIGN KEY (`peminjaman_id`) REFERENCES `peminjaman` (`id_peminjaman`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_pengembalian_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id_user`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
