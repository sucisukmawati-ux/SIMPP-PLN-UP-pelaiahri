CREATE DATABASE IF NOT EXISTS wa_tagihan CHARACTER SET utf8mb4;
USE wa_tagihan;

CREATE TABLE unit (
  unitup VARCHAR(5) PRIMARY KEY,
  unitap VARCHAR(5) NOT NULL,
  unitupi VARCHAR(2) NOT NULL
);
CREATE TABLE wilayah (
  kode_kelurahan VARCHAR(10) PRIMARY KEY,
  kelurahan VARCHAR(60) NOT NULL,
  kecamatan VARCHAR(60) NOT NULL,
  kabupaten VARCHAR(60) NOT NULL,
  provinsi VARCHAR(60) NOT NULL
);
CREATE TABLE gardu (
  nomor_gardu VARCHAR(30) PRIMARY KEY,
  kode_gardu VARCHAR(20) NOT NULL,
  nama_gardu VARCHAR(100)
);
CREATE TABLE pelanggan (
  idpel VARCHAR(12) PRIMARY KEY,
  unitup VARCHAR(5) NOT NULL,
  kode_kelurahan VARCHAR(10) NOT NULL,
  nomor_gardu VARCHAR(30),
  nomor_kwh VARCHAR(15),
  nama VARCHAR(100) NOT NULL,
  alamat VARCHAR(255),
  tarif VARCHAR(5) NOT NULL,
  daya INT NOT NULL,
  kddk VARCHAR(15),
  latitude DECIMAL(13,10),
  longitude DECIMAL(13,10),
  no_hp VARCHAR(20),
  FOREIGN KEY (unitup) REFERENCES unit(unitup),
  FOREIGN KEY (kode_kelurahan) REFERENCES wilayah(kode_kelurahan),
  FOREIGN KEY (nomor_gardu) REFERENCES gardu(nomor_gardu)
);
CREATE TABLE tagihan (
  id_tagihan INT AUTO_INCREMENT PRIMARY KEY,
  idpel VARCHAR(12) NOT NULL,
  periode CHAR(6) NOT NULL COMMENT 'format YYYYMM',
  total_tagihan DECIMAL(15,2) NOT NULL,
  status_bayar ENUM('belum','lunas') NOT NULL DEFAULT 'belum',
  tgl_bayar DATE,
  UNIQUE (idpel, periode),
  FOREIGN KEY (idpel) REFERENCES pelanggan(idpel)
);
CREATE TABLE pengguna (
  id_pengguna INT AUTO_INCREMENT PRIMARY KEY,
  nama VARCHAR(100) NOT NULL,
  username VARCHAR(50) NOT NULL UNIQUE,
  password_hash VARCHAR(255) NOT NULL,
  peran ENUM('admin','petugas','manajer') NOT NULL
);
CREATE TABLE template_pesan (
  id_template INT AUTO_INCREMENT PRIMARY KEY,
  nama_template VARCHAR(100) NOT NULL,
  isi TEXT NOT NULL
);
CREATE TABLE kampanye (
  id_kampanye INT AUTO_INCREMENT PRIMARY KEY,
  id_pengguna INT NOT NULL,
  id_template INT NOT NULL,
  nama_kampanye VARCHAR(100) NOT NULL,
  jadwal DATETIME,
  status ENUM('draf','dijadwalkan','berjalan','selesai') NOT NULL DEFAULT 'draf',
  FOREIGN KEY (id_pengguna) REFERENCES pengguna(id_pengguna),
  FOREIGN KEY (id_template) REFERENCES template_pesan(id_template)
);
CREATE TABLE pesan (
  id_pesan INT AUTO_INCREMENT PRIMARY KEY,
  id_kampanye INT NOT NULL,
  id_tagihan INT NOT NULL,
  no_tujuan VARCHAR(20) NOT NULL,
  isi_terkirim TEXT NOT NULL,
  status_kirim ENUM('antre','terkirim','diterima','dibaca','gagal') NOT NULL DEFAULT 'antre',
  waktu_kirim DATETIME,
  keterangan_error VARCHAR(255),
  UNIQUE (id_kampanye, id_tagihan),
  FOREIGN KEY (id_kampanye) REFERENCES kampanye(id_kampanye),
  FOREIGN KEY (id_tagihan) REFERENCES tagihan(id_tagihan)
);
