/*create database harcama_takib  DEFAULT CHARACTER SET 'utf8'  DEFAULT COLLATE 'utf8_turkish_ci';*/

/*Drop Database harcama_takib;*/

use harcama_takib;

CREATE TABLE IF NOT EXISTS Kullanicilar(
	OKytNo				Int		Not Null AUTO_INCREMENT,
    KaydTarihi			timestamp DEFAULT CURRENT_TIMESTAMP,
	GuncellemeTarihi 	timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
	isim 				VarChar(255) NOT NULL,
	soyisim 			VarChar(255) NOT NULL,	
	email 				VarChar(255) NOT NULL,	
	sifre 				VarChar(255) NOT NULL,
	    CONSTRAINT PK__Kullanicilar__OKytNo PRIMARY KEY(OKytNo),	
		CONSTRAINT UK__Kullanicilar__email UNIQUE(email)
)ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

INSERT INTO `Kullanicilar` (`OKytNo`, `isim`, `soyisim`, `email`, `sifre`) VALUES
(1, 'Ali', 'KOCA', 'ali.koca@gmail.com', '$2y$10$2N74YBkxYXPtEtFTxynuxeEn9OH9BZ.wI4ldZr00n1FX5q09/llbO');                                          
 
INSERT INTO `Kullanicilar` (`OKytNo`, `isim`, `soyisim`, `email`, `sifre`) VALUES
(2, 'Arjun', 'A', 'arjunphp@gmail.com', '$2y$10$2N74YBkxYXPtEtFTxynuxeEn9OH9BZ.wI4ldZr00n1FX5q09/llbO');

Select * From Kullanicilar;

CREATE TABLE IF NOT EXISTS HarcamaNevleri(
	OKytNo			Int		Not Null AUTO_INCREMENT,
    KaydTarihi     		DATETIME DEFAULT CURRENT_TIMESTAMP,
    modification_time 	DATETIME ON UPDATE CURRENT_TIMESTAMP,	
	NevIsmi 			VarChar(180) NOT NULL,
	AnaOKytNo			Int     Not Null Default 0,
	OrgKodu 			varchar(100) NULL,
	Seviye 				int NULL,
	SiraNo 				int NULL,
	Kullaniliyor 		BOOLEAN NOT NULL DEFAULT FALSE,
	AltKategoriVarMi 	BOOLEAN NOT NULL DEFAULT FALSE,	
	CONSTRAINT PK__HarcamaNevleri__OKytNo PRIMARY KEY(OKytNo),
	CONSTRAINT HarcamaNevleri_UN UNIQUE KEY (NevIsmi)
);

/*Drop Table Harcamalar;*/
CREATE TABLE IF NOT EXISTS Harcamalar(
	OKytNo				Int				Not Null AUTO_INCREMENT,
    KaydTarihi     		DATETIME 		DEFAULT CURRENT_TIMESTAMP,
    modification_time 	DATETIME 		ON UPDATE CURRENT_TIMESTAMP,	
	Tarih 				Date 			NOT NULL,
	RbtNevler			Int				Not Null,
	Mikdar				Decimal(10,2)	Not Null,
	Izah				VarChar(100)	Null,	
	CONSTRAINT PK__Harcamalar__OKytNo PRIMARY KEY(OKytNo),
	CONSTRAINT FK__Harcamalar__RbtNevler FOREIGN KEY (RbtNevler) REFERENCES HarcamaNevleri(OKytNo)	
);

CREATE TABLE IF NOT EXISTS GelirNevleri(
	OKytNo			Int		Not Null AUTO_INCREMENT,
    KaydTarihi     		DATETIME DEFAULT CURRENT_TIMESTAMP,
    modification_time 	DATETIME ON UPDATE CURRENT_TIMESTAMP,	
	NevIsmi 			VarChar(180) NOT NULL,
	AnaOKytNo			Int     Not Null Default 0,
	OrgKodu 			varchar(100) NULL,
	Seviye 				int NULL,
	SiraNo 				int NULL,
	Kullaniliyor 		BOOLEAN NOT NULL DEFAULT FALSE,
	AltKategoriVarMi 	BOOLEAN NOT NULL DEFAULT FALSE,	
	CONSTRAINT PK__GelirNevleri__OKytNo PRIMARY KEY(OKytNo),
	CONSTRAINT GelirNevleri_UN UNIQUE KEY (NevIsmi)
);

CREATE TABLE IF NOT EXISTS Gelirler(
	OKytNo				Int				Not Null AUTO_INCREMENT,
    KaydTarihi     		DATETIME 		DEFAULT CURRENT_TIMESTAMP,
    modification_time 	DATETIME 		ON UPDATE CURRENT_TIMESTAMP,	
	Tarih 				Date 			NOT NULL,
	RbtNevler			Int				Not Null,
	Mikdar				Decimal(10,2)	Not Null,
	Izah				VarChar(100)	Null,	
	CONSTRAINT PK__Gelirler__OKytNo PRIMARY KEY(OKytNo),
	CONSTRAINT FK__Gelirler__RbtNevler FOREIGN KEY (RbtNevler) REFERENCES GelirNevleri(OKytNo)	
);

CREATE TABLE IF NOT EXISTS MevcudatNevleri(
	OKytNo			Int		Not Null AUTO_INCREMENT,
    KaydTarihi     		DATETIME DEFAULT CURRENT_TIMESTAMP,
    modification_time 	DATETIME ON UPDATE CURRENT_TIMESTAMP,	
	NevIsmi 			VarChar(180) NOT NULL,
	AnaOKytNo			Int     Not Null Default 0,
	OrgKodu 			varchar(100) NULL,
	Seviye 				int NULL,
	SiraNo 				int NULL,
	Kullaniliyor 		BOOLEAN NOT NULL DEFAULT FALSE,
	AltKategoriVarMi 	BOOLEAN NOT NULL DEFAULT FALSE,	
	CONSTRAINT PK__MevcudatNevleri__OKytNo PRIMARY KEY(OKytNo),
	CONSTRAINT MevcudatNevleri_UN UNIQUE KEY (NevIsmi)
);

CREATE TABLE IF NOT EXISTS Mevcudat(
	OKytNo				Int				Not Null AUTO_INCREMENT,
    KaydTarihi     		DATETIME 		DEFAULT CURRENT_TIMESTAMP,
    modification_time 	DATETIME 		ON UPDATE CURRENT_TIMESTAMP,	
	Tarih 				Date 			NOT NULL,
	RbtNevler			Int				Not Null,
	Mikdar				Decimal(10,2)	Not Null,
	Izah				VarChar(100)	Null,	
	CONSTRAINT PK__Mevcudat__OKytNo PRIMARY KEY(OKytNo),
	CONSTRAINT FK__Mevcudat__RbtNevler FOREIGN KEY (RbtNevler) REFERENCES MevcudatNevleri(OKytNo)	
);