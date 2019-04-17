use harcama_takib;
/* Gelir Nevleri*/
Insert Into GelirNevleri (NevIsmi,AnaOKytNo) VALUES
	('Maaş', 0),
	('Ek Ödeme', 0);

/* Varidat Nevleri*/
Insert Into VaridatNevleri (NevIsmi,AnaOKytNo, SiraNo) VALUES
	('Nakit', 0, 1),
    ('Banka', 0,10);
   
/* Harcama Nevleri*/
Insert Into HarcamaNevleri (NevIsmi,AnaOKytNo) VALUES
	('Sağlık', 0),
	('Gıda', 0),
	('Yakıt', 0),
	('Fatura', 0),	
	('Kırt-Eğitim', 0),	
	('Yol', 0),	
	('İkamet', 0),	
	('Temizlik', 0),
	('Hırd-Elt', 0),
	('Araba', 0),
	('Giyim-Tekstil', 0),
	('Mutfak', 0);

SELECT @AnaOKytNo := OKytNo from HarcamaNevleri WHERE NevIsmi = 'Gıda';
Insert Into HarcamaNevleri (NevIsmi,AnaOKytNo) VALUES	
	('Meyve', @AnaOKytNo),	
	('Sebze', @AnaOKytNo),	
	('Kahvaltılık', @AnaOKytNo),	
	('Şarküteri', @AnaOKytNo),	
	('Kuru-Baklagiller', @AnaOKytNo),
	('Unlu Mamüller', @AnaOKytNo);	
	
SELECT @AnaOKytNo := OKytNo from HarcamaNevleri WHERE NevIsmi = 'Kuru-Baklagiller';	
Insert Into HarcamaNevleri (NevIsmi,AnaOKytNo) VALUES	
	('Kuru Fasülye', @AnaOKytNo),	
	('Barbunya', @AnaOKytNo),	
	('Nohut', @AnaOKytNo),	
	('Mercimek', @AnaOKytNo);	
	
SELECT @AnaOKytNo := OKytNo from HarcamaNevleri WHERE NevIsmi = 'Unlu Mamüller';	
Insert Into HarcamaNevleri (NevIsmi,AnaOKytNo) VALUES	
	('Ekmek', @AnaOKytNo),	
	('Bisküvi', @AnaOKytNo);		

SELECT @AnaOKytNo := OKytNo from HarcamaNevleri WHERE NevIsmi = 'Giyim-Tekstil';	
Insert Into HarcamaNevleri (NevIsmi,AnaOKytNo) VALUES	
	('Örtü', @AnaOKytNo),
	('Ayakkabı', @AnaOKytNo),	
	('Giyim', @AnaOKytNo);	
	
