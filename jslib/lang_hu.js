LANG_DATEFORMAT = {
    LANG_DAYNAMES: [
                    "v", "h", "k", "sze", "cs", "p", "szo",
                    "vasárnap", "hétfő", "kedd", "szerda", "csütörtök", "péntek", "szombat"
                    ],
                    LANG_MONTHNAMES: [
                                      "jan", "feb", "márc", "ápr", "máj", "jún", "júl", "aug", "szep", "okt", "nov", "dec",
                                      "január", "február", "március", "április", "május", "június", "július", "augusztus", "szeptember", "október", "november", "december"
                                      ]
};
LANG_AMPM = {
  LANG_AM: ["de", "De", "délelőtt", "Délelőtt"],
  LANG_PM: ["du", "Du", "délután", "Délután"]
};

LANG_HASH_STRING_REQUIRED = 'Kérem adjon meg kódolható/dekódolható szöveget!';
LANG_CONNECT_FAILED = 'Nem sikerült kapcsolódni a szerverhez!';
LANG_ERROR = 'Hiba';
LANG_DECODE_SUCCESS = 'Sikeres HASH visszafejtés!';
LANG_DECODE_FAILED = 'A visszafejtés sikertelen!';
LANG_ADDBOOKMARK_NOT_WORK_IN_CHROME = 'Ez a funkció nem működik a Google Chrome és Firefox böngészőkben! Kattintson a böngészősáv végén lévő csillag szimbólumra, vagy használja a CTRL + D (Mac: Command + D) billentyűkombinációkat.';
LANG_ADDBOOKMARK_NOT_WORK = 'Böngészője nem támogatja a könyvjelző hozzáadás funkciót!';
LANG_BTN_OK = 'OK';
LANG_LOADING = 'Betöltés';
LANG_MESSAGE_SEND_OK = 'Üzenet elküldve!<br />Köszönjük!';
LANG_MESSAGEFORM_ERROR_NOVALID_EMAIL = 'Helytelen email cím<br />';
LANG_MESSAGEFORM_ERROR_NAME_LEN = 'Névhez legalább két karaktert várok!<br />';
LANG_MESSAGEFORM_ERROR_TEXT_LEN = 'Üzenetnek legalább 10 karaktert várok!<br />';
LANG_MESSAGEFORM_ERROR_NOCAPTCHA = 'Nem adott meg ellenőrző kódot<br />';
LANG_NAMEDAY = 'napja';
LANG_BISSEXTILEYES = 'Igen, ez szökőév';
LANG_BISSEXTILENO = 'Nem, ez nem szökőév';

var LANG_NAMEDAYARRAY = function(Year, Month, Day){
  if (Month == 1){
    var Days = new initArray("ÚJÉV, Fruzsina","Ábel","Genovéva, Benjámin","Titusz, Leona",
    "Simon","Boldizsár","Attila, Ramóna","Gyöngyvér","Marcell",
    "Melánia","Ágota","Ern&#337;","Veronika","Bódog","Lóránt, Loránd",
    "Gusztáv","Antal, Antónia","Piroska","Sára, Márió","Fábián, Sebestyén",
    "Ágnes","Vince, Artúr","Zelma, Rajmund","Timót","Pál","Vanda, Paula",
    "Angelika","Károly, Karola","Adél","Martina, Gerda","Marcella","");
  }
  if (Month == 2){
    if (bissextile()){
      var Days = new initArray("Ignác","Karolina, Aida","Balázs","Ráhel, Csenge","Ágota, Ingrid",
      "Dorottya, Dóra","Tódor, Rómeó","Aranka","Abigél, Alex","Elvira",
      "Bertold, Marietta","Lívia, Lídia","Ella, Linda","Bálint, Valentin",
      "Kolos, Georgina","Julianna, Lilla","Donát","Bernadett","Zsuzsanna",
      "Aladár, Álmos","Eleonóra","Gerzson","Alfréd",
      "Szökőnap",
      "Mátyás","Géza","Edina","Ákos, Bátor","Elemér","","");
    }else{
      var Days = new initArray("Ignác","Karolina, Aida","Balázs","Ráhel, Csenge","Ágota, Ingrid",
      "Dorottya, Dóra","Tódor, Rómeó","Aranka","Abigél, Alex","Elvira",
      "Bertold, Marietta","Lívia, Lídia","Ella, Linda","Bálint, Valentin",
      "Kolos, Georgina","Julianna, Lilla","Donát","Bernadett","Zsuzsanna",
      "Aladár, Álmos","Eleonóra","Gerzson","Alfréd",
      "Mátyás","Géza","Edina","Ákos, Bátor","Elemér","",""); 
    }
  }
  if (Month == 3){ 
    var Days = new initArray("Albin","Lujza","Kornélia","Kázmér","Adorján, Adrián","Leonóra, Inez",
    "Tamás","NEMZ.N&#336;NAP, Zoltán","Franciska, Fanni","Ildikó","Szilárd",
    "Gergely","Krisztián, Ajtony","Matild","NEMZETI ÜNNEP, Kristóf",
    "Henrietta","Gertrúd, Patrik","Sándor, Ede","József, Bánk","Klaudia",
    "Benedek","Beáta, Izolda","Em&#337;ke","Gábor, Karina","Irén, Irisz",
    "Emánuel","Hajnalka","Gedeon, Johanna","Auguszta","Zalán","Árpád","" );
  }
  if (Month == 4){
    var Days = new initArray("Hugó","Áron","Buda, Richárd","Izidor","Vince","Vilmos, Bíborka",
    "Herman","Dénes","Erhard","Zsolt","Leó, Szaniszló","Gyula","Ida",
    "Tibor","Anasztázia, Tas","Csongor","Rudolf","Andrea, Ilma","Emma",
    "Tivadar","Konrád","Csilla, Noémi","Béla","György","Márk","Ervin",
    "Zita","Valéria","Péter","Katalin, Kitti","" );
  }
  if (Month == 5){ 
    var Days = new initArray("MUNKA ÜNN.,Fülöp, Jakab","Zsigmond","Tímea, Irma","Mónika, Flórián",
    "Györgyi","Ivett, Frida","Gizella","Mihály","Gergely","Ármin, Pálma",
    "Ferenc","Pongrác","Szervác, Imola","Bonifác","Zsófia, Szonja",
    "Mózes, Botond","Paszkál","Erik, Alexandra","Ivó, Milán",
    "Bernát, Felícia","Konstantin","Júlia, Rita","Dezs&#337;","Eszter, Eliza",
    "Orbán","Fülöp, Evelin","Hella","Emil, Csanád","Magdolna",
    "Janka, Zsanett","Angéla, Petronella","" );
  }
  if (Month == 6){
    var Days = new initArray("Tünde","Kármen, Anita","Klotild","Bulcsú","Fatime","Norbert, Cintia",
    "Róbert","Medárd","Félix","Margit, Gréta","Barnabás","Vill&#337;",
    "Antal, Anett","Vazul","Jolán, Vid","Jusztin","Laura, Alida",
    "Arnold, Levente","Gyárfás","Rafael","Alajos, Leila","Paulina",
    "Zoltán","Iván","Vilmos","János, Pál","László","Levente, Irén",
    "Péter, Pál","Pál","" );
  }
  if (Month == 7){
    var Days = new initArray("Tihamér, Annamária","Ottó","Kornél, Soma","Ulrik","Emese, Sarolta",
    "Csaba","Appolónia","Ellák","Lukrécia","Amália","Nóra, Lili",
    "Izabella, Dalma","Jen&#337;","Örs, Stella","Henrik, Roland","Valter",
    "Endre, Elek","Frigyes","Emília","Illés","Dániel, Daniella",
    "Magdolna","Lenke","Kinga, Kincs&#337;","Kristóf, Jakab","Anna, Anikó",
    "Olga, Liliána","Szabolcs","Márta, Flóra","Judit, Xénia","Oszkár","" );
  }
  if (Month == 8){
    var Days = new initArray("Boglárka","Lehel","Hermina","Domonkos, Dominika","Krisztina",
    "Berta, Bettina","Ibolya","László","Em&#337;d","L&#337;rinc",
    "Zsuzsanna, Tiborc","Klára","Ipoly","Marcell","Mária","Ábrahám",
    "Jácint","Ilona","Huba","ALKOTMÁNY ÜNN., István","Sámuel, Hajna",
    "Menyhért, Mirjam","Bence","Bertalan","Lajos, Patrícia","Izsó",
    "Gáspár","Ágoston","Beatrix, Erna","Rózsa","Erika, Bella");
  }
  if (Month == 9){
    var napok = new initArray("Egyed, Egon","Rebeka, Dorina","Hilda","Rozália","Viktor, L&#337;rinc",
    "Zakariás","Regina","Mária, Adrienn","Ádám","Nikolett, Hunor",
    "Teodóra","Mária","Kornél","Szeréna, Roxána","Enik&#337;, Melitta","Edit",
    "Zsófia","Diána","Vilhelmina","Friderika","Máté, Mirella","Móric",
    "Tekla","Gellért, Mercédesz","Eufrozina, Kende","Jusztina","Adalbert",
    "Vencel","Mihály","Jeromos","" );
  } 
  if (Month == 10){
    var Days = new initArray("Malvin","Petra","Helga","Ferenc","Aurél","Brúnó, Renáta","Amália",
    "Koppány","Dénes","Gedeon","Brigitta","Miksa","Kálmán, Ede","Helén",
    "Teréz","Gál","Hedvig","Lukács","Nándor","Vendel","Orsolya","El&#337;d",
    "Gyöngyi","Salamon","Blanka, Bianka","Dömötör",
    "Szabina","Simon, Szimonetta","Nárcisz","Alfonz","Farkas","" );
  }
  if (Month == 11){ 
    var Days = new initArray("Marianna","Achilles","Gy&#337;z&#337;","Károly","Imre","Lénárd","Rezs&#337;",
    "Zsombor","Tivadar","Réka","Márton","Jónás, Renátó","Szilvia",
    "Aliz","Albert, Lipót","Ödön","Hortenzia, Gerg&#337;","Jen&#337;","Erzsébet",
    "Jolán","Olivér","Cecília","Kelemen, Klementina","Emma","Katalin",
    "Virág","Virgil","Stefánia","Taksony","András, Andor","" );
  }
  if (Month == 12){
    var Days = new initArray("Elza","Melinda, Vivien","Ferenc, Olívia","Borbála, Barbara","Vilma",
    "Miklós","Ambrus","Mária","Natália","Judit","Árpád","Gabriella",
    "Luca, Otília","Szilárda","Valér","Etelka, Aletta","Lázár, Olimpia",
    "Auguszta","Viola","Teofil","Tamás","Zéno","Viktória","Ádám, Éva",
    "KARÁCSONY, Eugénia","KARÁCSONY, István","János","Kamilla",
    "Tamás, Tamara","Dávid","Szilveszter","");
  } 
  return Days[Day]
}