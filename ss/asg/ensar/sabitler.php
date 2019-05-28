<?php
define('Tamam', 'Tamam');
define('Hata', 'Hata');
define('Veriler', 'Veriler');
define('BlokDisi', 'Blok Dışı');

class Sabitler
{
    public function koddanGetir($pKod)
    {
        return array_search($pKod, $this->sabitKodlari);
    }

    public function ikiKoddanGetir($pKod1, $pKod2)
    {

        return array($this->koddanGetir($pKod1) => $this->koddanGetir($pKod2));
    }

    public function koddanSabitDizisiGetir($pKod)
    {
        return array($pKod => $this->sabitKodlari[$pKod]);
    }

    private $sabitKodlari = array(
        'Netice' => 'Netice',
        'Tamam' => 'Tamam',
        'Hata!' => 'Hata',
        'Veriler' => 'Veriler',
        'Blok Dışı!' => 'BlokDisi',
        'Mesaj' => 'Mesaj',
        'Token' => 'Token',
    );

}
