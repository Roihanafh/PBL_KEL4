--jangan lupa di drop dulu database nya :)
-- Drop database jika sudah ada
IF EXISTS (SELECT name FROM sys.databases WHERE name = 'PBL_Lencana')
BEGIN
    DROP DATABASE PBL_Lencana;
END
GO

-- Membuat database PBL_Lencana
CREATE DATABASE PBL_Lencana;
GO

USE PBL_Lencana;
GO
-- Tabel Admin
CREATE TABLE Admin (
    IdAdmin VARCHAR(20) NOT NULL PRIMARY KEY,
    Password VARCHAR(255) NOT NULL,
    Nama VARCHAR(100) NOT NULL,
    Email VARCHAR(100) NULL,
    Role VARCHAR(50) NOT NULL DEFAULT 'Admin'
);
-- Data Dummy untuk Tabel Admin
INSERT INTO Admin (IdAdmin, Password, Nama, Email) VALUES
('A001', 'adminpass123', 'Andi Setiawan', 'andi.setiawan@polinema.ac.id'),
('A002', 'adminpass234', 'Budi Santoso', 'budi.santoso@polinema.ac.id');


-- Tabel Dosen (tanpa foreign key, karena tidak ada relasi dari tabel lain)
CREATE TABLE Dosen (
    Nip VARCHAR(25) PRIMARY KEY,
    Nama VARCHAR(100) NOT NULL,
    Email VARCHAR(100) NULL,
    NoTelp VARCHAR(15) NULL,
    Password VARCHAR(255) NULL,
    Role VARCHAR(50) NOT NULL DEFAULT 'Dosen'
);
GO

-- Tabel Prestasi dengan penambahan FK Dosen
CREATE TABLE Prestasi (
    PrestasiId INT IDENTITY(1,1) PRIMARY KEY,
    Peringkat INT NOT NULL,
    Url VARCHAR(255) NOT NULL,
    TanggalMulai DATE NOT NULL,
    TanggalBerakhir DATE NOT NULL,
    Status VARCHAR(50) CHECK (Status IN ('Valid', 'Menunggu Validasi', 'Tidak Valid')) NOT NULL,
    TempatKompetisi VARCHAR(255) NOT NULL,
    BuktiSertif VARBINARY(MAX) NULL,
    BuktiSuratTugas VARBINARY(MAX) NULL,
    FotoKegiatan VARBINARY(MAX) NULL,
    JudulPrestasi VARCHAR(255) NULL,
    Poin INT NULL,
    TingkatPrestasi VARCHAR(50) CHECK (TingkatPrestasi IN ('Kabupaten/Kota','Nasional', 'Internasional', 'Provinsi')) NULL,
    TipePrestasi VARCHAR(50) CHECK (TipePrestasi IN ('Individu', 'Kelompok')) NULL,
    DosenNip VARCHAR(25), -- FK Dosen
    FOREIGN KEY (DosenNip) REFERENCES Dosen(Nip) -- Menambahkan foreign key
);
GO

-- Tabel Mahasiswa tanpa foreign key langsung ke Prestasi
CREATE TABLE Mahasiswa (
    Nim VARCHAR(25) PRIMARY KEY,
    Email VARCHAR(100) NULL,
    Nama VARCHAR(100) NOT NULL,
    Password VARCHAR(255) NULL,
    ProgramStudi VARCHAR(50) CHECK (ProgramStudi IN ('D4 Teknik Informatika', 'D4 Sistem Informasi Bisnis', 'D2 PPLS')) NULL,
    Angkatan INT NULL,
    Role VARCHAR(50) NOT NULL DEFAULT 'Mahasiswa'
);
GO

-- Tabel PrestasiMahasiswa sebagai relasi antara Mahasiswa dan Prestasi
CREATE TABLE PrestasiMahasiswa (
    PrestasiId INT NOT NULL,
    Nim VARCHAR(25) NOT NULL,
    PRIMARY KEY (PrestasiId, Nim),
    FOREIGN KEY (PrestasiId) REFERENCES Prestasi(PrestasiId),
    FOREIGN KEY (Nim) REFERENCES Mahasiswa(Nim)
);
GO

-- Data Dummy untuk Dosen
INSERT INTO Dosen (Nip, Nama, Email, NoTelp, Password)
VALUES
('NIP001', 'Dr. Ahmad', 'ahmad@polinema.ac.id', '081234567890', 'password123'),
('NIP002', 'Prof. Siti', 'siti@polinema.ac.id', '082345678901', 'password456'),
('NIP003', 'Dr. Budi', 'budi@polinema.ac.id', '083456789012', 'password789'),
('NIP004', 'Prof. Dwi', 'dwi@polinema.ac.id', '084567890123', 'password101'),
('NIP005', 'Dr. Lia', 'lia@polinema.ac.id', '085678901234', 'password202');
GO

-- Data Dummy untuk Prestasi dengan tempat kompetisi yang diubah dan FK Dosen
INSERT INTO Prestasi (Peringkat, Url, TanggalMulai, TanggalBerakhir, Status, TempatKompetisi, JudulPrestasi, Poin, TingkatPrestasi, TipePrestasi, DosenNip)
VALUES
(1, 'http://lomba1.com', '2024-01-01', '2024-01-02', 'Valid', 'Universitas Gadjah Mada', 'Juara 1 Lomba A', 10, 'Nasional', 'Individu', 'NIP001'),
(2, 'http://lomba2.com', '2024-02-01', '2024-02-02', 'Valid', 'Politeknik Negeri Jakarta', 'Juara 2 Lomba B', 8, 'Nasional', 'Kelompok', 'NIP002'),
(3, 'http://lomba3.com', '2024-03-01', '2024-03-02', 'Valid', 'Universitas Indonesia', 'Juara 1 Lomba C', 12, 'Provinsi', 'Individu', 'NIP003'),
(4, 'http://lomba4.com', '2024-04-01', '2024-04-02', 'Menunggu Validasi', 'Institut Teknologi Bandung', 'Juara 3 Lomba D', 7, 'Internasional', 'Kelompok', 'NIP004'),
(5, 'http://lomba5.com', '2024-05-01', '2024-05-02', 'Valid', 'Universitas Airlangga', 'Juara 1 Lomba E', 15, 'Nasional', 'Individu', 'NIP005'),
(6, 'http://lomba6.com', '2024-06-01', '2024-06-02', 'Tidak Valid', 'Politeknik Negeri Surabaya', 'Juara 2 Lomba F', 6, 'Provinsi', 'Kelompok', 'NIP001'),
(7, 'http://lomba7.com', '2024-07-01', '2024-07-02', 'Valid', 'Universitas Brawijaya', 'Juara 1 Lomba G', 18, 'Internasional', 'Individu', 'NIP002'),
(8, 'http://lomba8.com', '2024-08-01', '2024-08-02', 'Valid', 'Universitas Padjadjaran', 'Juara 3 Lomba H', 9, 'Nasional', 'Kelompok', 'NIP003'),
(9, 'http://lomba9.com', '2024-09-01', '2024-09-02', 'Menunggu Validasi', 'Politeknik Negeri Bali', 'Juara 1 Lomba I', 11, 'Provinsi', 'Individu', 'NIP004'),
(10, 'http://lomba10.com', '2024-10-01', '2024-10-02', 'Valid', 'Universitas Diponegoro', 'Juara 2 Lomba J', 10, 'Internasional', 'Kelompok', 'NIP005');
GO

-- Data Dummy untuk Mahasiswa
INSERT INTO Mahasiswa (Nim, Email, Nama, Password, ProgramStudi, Angkatan)
VALUES
('NIM001', 'mahasiswa1@polinema.ac.id', 'Siti Aisyah', 'password123', 'D4 Teknik Informatika', 2022),
('NIM002', 'mahasiswa2@polinema.ac.id', 'Ahmad Fauzi', 'password456', 'D4 Sistem Informasi Bisnis', 2022),
('NIM003', 'mahasiswa3@polinema.ac.id', 'Rina Pratiwi', 'password789', 'D4 Teknik Informatika', 2023),
('NIM004', 'mahasiswa4@polinema.ac.id', 'Siti Nurbaya', 'password101', 'D4 Sistem Informasi Bisnis', 2023),
('NIM005', 'mahasiswa5@polinema.ac.id', 'Budi Santoso', 'password202', 'D4 Teknik Informatika', 2022),
('NIM006', 'mahasiswa6@polinema.ac.id', 'Fahmi Idris', 'password303', 'D4 Sistem Informasi Bisnis', 2023),
('NIM007', 'mahasiswa7@polinema.ac.id', 'Ari Wibowo', 'password404', 'D4 Teknik Informatika', 2022),
('NIM008', 'mahasiswa8@polinema.ac.id', 'Intan Permatasari', 'password505', 'D4 Sistem Informasi Bisnis', 2023),
('NIM009', 'mahasiswa9@polinema.ac.id', 'Agus Santoso', 'password606', 'D4 Teknik Informatika', 2022),
('NIM010', 'mahasiswa10@polinema.ac.id', 'Dina Rahmawati', 'password707', 'D4 Sistem Informasi Bisnis', 2023);
GO

-- Data Dummy untuk PrestasiMahasiswa (Relasi antara Mahasiswa dan Prestasi)
INSERT INTO PrestasiMahasiswa (PrestasiId, Nim)
VALUES
(1, 'NIM001'),
(2, 'NIM001'),
(3, 'NIM002'),
(4, 'NIM003'),
(5, 'NIM003'),
(6, 'NIM004'),
(7, 'NIM004'),
(8, 'NIM005'),
(9, 'NIM005'),
(10, 'NIM006');
GO

-- Merubah tabel dosen
ALTER TABLE Dosen
ADD Alamat VARCHAR(255) NULL;

-- Merubah tabel mahasiswa
ALTER TABLE Mahasiswa
ADD NoTelp VARCHAR(15) NULL,
    Alamat VARCHAR(255) NULL;

-- Merubah data dummy
UPDATE Dosen
SET Alamat = 'Jl. Sudirman No. 45, Malang' WHERE Nip = 'NIP001';

UPDATE Dosen
SET Alamat = 'Jl. Diponegoro No. 20, Jakarta' WHERE Nip = 'NIP002';

UPDATE Dosen
SET Alamat = 'Jl. Pahlawan No. 10, Surabaya' WHERE Nip = 'NIP003';

UPDATE Dosen
SET Alamat = 'Jl. Merdeka No. 30, Bandung' WHERE Nip = 'NIP004';

UPDATE Dosen
SET Alamat = 'Jl. Kartini No. 5, Yogyakarta' WHERE Nip = 'NIP005';

UPDATE Mahasiswa
SET NoTelp = '0811111111', Alamat = 'Jl. Cempaka No. 12, Malang' WHERE Nim = 'NIM001';

UPDATE Mahasiswa
SET NoTelp = '0822222222', Alamat = 'Jl. Melati No. 25, Surabaya' WHERE Nim = 'NIM002';

UPDATE Mahasiswa
SET NoTelp = '0833333333', Alamat = 'Jl. Mawar No. 7, Jakarta' WHERE Nim = 'NIM003';

UPDATE Mahasiswa
SET NoTelp = '0844444444', Alamat = 'Jl. Kenanga No. 8, Bandung' WHERE Nim = 'NIM004';

UPDATE Mahasiswa
SET NoTelp = '0855555555', Alamat = 'Jl. Anggrek No. 10, Yogyakarta' WHERE Nim = 'NIM005';

UPDATE Mahasiswa
SET NoTelp = '0866666666', Alamat = 'Jl. Flamboyan No. 18, Denpasar' WHERE Nim = 'NIM006';

UPDATE Mahasiswa
SET NoTelp = '0877777777', Alamat = 'Jl. Sakura No. 3, Makassar' WHERE Nim = 'NIM007';

UPDATE Mahasiswa
SET NoTelp = '0888888888', Alamat = 'Jl. Teratai No. 6, Semarang' WHERE Nim = 'NIM008';

UPDATE Mahasiswa
SET NoTelp = '0899999999', Alamat = 'Jl. Tulip No. 9, Bali' WHERE Nim = 'NIM009';

UPDATE Mahasiswa
SET NoTelp = '0810101010', Alamat = 'Jl. Dahlia No. 11, Solo' WHERE Nim = 'NIM010';

-- hapus data yang ada pada prestasi
DELETE FROM PrestasiMahasiswa;
DELETE FROM Prestasi;



