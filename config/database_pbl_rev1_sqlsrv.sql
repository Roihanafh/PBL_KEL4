-- Membuat database jika belum ada
IF NOT EXISTS (SELECT * FROM sys.databases WHERE name = 'PBL_Lencana')
BEGIN
    CREATE DATABASE PBL_Lencana;
END;
GO

-- Menggunakan database yang dibuat
USE PBL_Lencana;
GO

-- Membuat tabel Prestasi
CREATE TABLE Prestasi (
    PrestasiId INT NOT NULL PRIMARY KEY,
    Peringkat INT NOT NULL,
    Url NVARCHAR(255) NOT NULL,
    TanggalMulai DATE NOT NULL,
    TanggalBerakhir DATE NOT NULL,
    Status NVARCHAR(20) NOT NULL CHECK (Status IN ('Valid', 'Menunggu Validasi', 'Tidak Valid')),
    TempatKompetisi NVARCHAR(45) NOT NULL,
    BuktiSertif VARBINARY(MAX) NULL,
    BuktiSuratTugas VARBINARY(MAX) NULL,
    FotoKegiatan VARBINARY(MAX) NULL,
    JudulPrestasi NVARCHAR(255) NULL,
    Poin INT NULL,
    TingkatPrestasi NVARCHAR(20) NULL CHECK (TingkatPrestasi IN ('Nasional', 'Internasional', 'Provinsi')),
    TipePrestasi NVARCHAR(20) NULL CHECK (TipePrestasi IN ('Individu', 'Kelompok'))
);
GO

-- Membuat tabel Dosen
CREATE TABLE Dosen (
    Nip NVARCHAR(25) NOT NULL PRIMARY KEY,
    Nama NVARCHAR(100) NULL,
    Email NVARCHAR(100) NULL,
    NoTelp NVARCHAR(15) NULL,
    Password NVARCHAR(255) NULL,
    Prestasi_PrestasiId INT NOT NULL,
    CONSTRAINT FK_Dosen_Prestasi FOREIGN KEY (Prestasi_PrestasiId) REFERENCES Prestasi (PrestasiId)
);
GO

-- Membuat tabel Mahasiswa
CREATE TABLE Mahasiswa (
    Nim NVARCHAR(25) NOT NULL PRIMARY KEY,
    Email NVARCHAR(100) NULL,
    Nama NVARCHAR(100) NULL,
    Password NVARCHAR(255) NULL,
    ProgramStudi NVARCHAR(50) NULL CHECK (ProgramStudi IN ('D4 Teknik Informatika', 'D4 Sistem Informasi Bisnis', 'D2 PPLS')),
    Angkatan INT NULL,
    Prestasi_PrestasiId INT NOT NULL,
    CONSTRAINT FK_Mahasiswa_Prestasi FOREIGN KEY (Prestasi_PrestasiId) REFERENCES Prestasi (PrestasiId)
);
GO

-- Membuat tabel Admin
CREATE TABLE Admin (
    IdAdmin NVARCHAR(20) NOT NULL PRIMARY KEY,
    Password NVARCHAR(255) NOT NULL,
    Nama NVARCHAR(100) NOT NULL,
    Email NVARCHAR(100) NULL
);
GO

-- Menambahkan data dummy ke tabel Prestasi
INSERT INTO Prestasi (PrestasiId, Peringkat, Url, TanggalMulai, TanggalBerakhir, Status, TempatKompetisi, JudulPrestasi, Poin, TingkatPrestasi, TipePrestasi)
VALUES
(1, 1, 'http://example.com/prestasi1', '2024-01-01', '2024-01-10', 'Valid', 'Jakarta', 'Juara 1 Lomba A', 100, 'Nasional', 'Individu'),
(2, 2, 'http://example.com/prestasi2', '2024-02-01', '2024-02-10', 'Menunggu Validasi', 'Bandung', 'Juara 2 Lomba B', 80, 'Provinsi', 'Kelompok');
GO

-- Menambahkan data dummy ke tabel Dosen
INSERT INTO Dosen (Nip, Nama, Email, NoTelp, Password, Prestasi_PrestasiId)
VALUES
('123456', 'Dr. Andi', 'andi@example.com', '081234567890', 'password123', 1),
('789012', 'Dr. Budi', 'budi@example.com', '081298765432', 'password456', 2);
GO

-- Menambahkan data dummy ke tabel Mahasiswa
INSERT INTO Mahasiswa (Nim, Email, Nama, Password, ProgramStudi, Angkatan, Prestasi_PrestasiId)
VALUES
('202401001', 'mahasiswa1@example.com', 'Ali', 'pass123', 'D4 Teknik Informatika', 2024, 1),
('202401002', 'mahasiswa2@example.com', 'Siti', 'pass456', 'D4 Sistem Informasi Bisnis', 2023, 2);
GO

-- Menambahkan data dummy ke tabel Admin
INSERT INTO Admin (IdAdmin, Password, Nama, Email)
VALUES
('admin1', 'adminpass1', 'Admin Satu', 'admin1@example.com'),
('admin2', 'adminpass2', 'Admin Dua', 'admin2@example.com');
GO
