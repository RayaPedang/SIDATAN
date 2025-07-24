CREATE DATABASE SI_Jadwal;
USE SI_Jadwal;

Create table Pengguna(
id Int auto_increment primary key,
username varchar(50) not null unique,
password varchar(255) not null,
role Enum('Admin', 'Kepala Dinas', 'Sekretaris Dinas', 'Kepala Bagian', 'Kepala Bidang') not null,
created_at timestamp default current_timestamp);

Create table Jadwal_Kegiatan(
id INT auto_increment primary key,
Jenis_Kegiatan enum('Internal', 'Eksternal') not null,
Tanggal_Mulai date not null,
Tanggal_Selesai date default null,
Waktu time not null,
Tempat varchar(100) not null,
Agenda text not null,
Keterangan text,
created_at timestamp default current_timestamp,
update_at timestamp default current_timestamp on update current_timestamp);

