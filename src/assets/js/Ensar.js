export class Ensar2 {}
export class Ensar {
  constructor() {
    return this;
  }
  static clone(obj) {
    if (null == obj || "object" != typeof obj) return obj;
    var copy = obj.constructor();
    for (var attr in obj) {
      if (obj.hasOwnProperty(attr)) copy[attr] = obj[attr];
    }
    return copy;
  }

  static anahtarliDiziyeElemaniEkle(pAnaDizi, pEklenecek, pPoz) {
    //0 Elemanın silinmeyeceğini ifade eder.
    pAnaDizi.splice(pPoz, 0, pEklenecek);
  }

  static anahtarliDiziElemaniSil(pAnaDizi, pAlan, pDeger) {
    for (let i = 0; i < pAnaDizi.length; i++) {
      if (pAnaDizi[i][pAlan] == pDeger) {
        pAnaDizi.splice(i, 1);
        break;
      }
    }
  }

  static anahtarliDiziElemaniGuncelle(pAnaDizi, pAlan, pDeger, pVeriler) {
    pAnaDizi.forEach(diziElemani => {
      if (diziElemani[pAlan] == pDeger) {
        for (var k in diziElemani) {
          if (diziElemani.hasOwnProperty(k)) {
            diziElemani[k] = pVeriler[k];
          }
        }
      }
    });
  }

  static formatDate(stringDate) {
    var date = new Date(stringDate);
    return (
      ("0" + date.getDate()).slice(-2) +
      "." +
      ("0" + (date.getMonth() + 1)).slice(-2) +
      "." +
      date.getFullYear()
    );
  }
  static yilAyGunTarih(pTarih) {
    let tarih = new Date(pTarih);
    var day = ("0" + tarih.getDate()).slice(-2);
    var month = ("0" + (tarih.getMonth() + 1)).slice(-2);
    return tarih.getFullYear() + "-" + month + "-" + day;
  }

  static donemGetir(ilkTarih) {
    var gun = ilkTarih.getDate();
    if (gun < 15) {
      ilkTarih.setMonth(ilkTarih.getMonth() - 1);
    }
    ilkTarih.setDate(15);
    var sonTarih = new Date(ilkTarih);
    sonTarih.setMonth(sonTarih.getMonth() + 1);
    sonTarih.setDate(14);
    return {
      ilkTarih: this.yilAyGunTarih(ilkTarih),
      sonTarih: this.yilAyGunTarih(sonTarih)
    };
  }
}
