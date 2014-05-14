# Knot'a eklenecek yapılar hakkında

## v1 ile gelecek özellikler.
- Composer üzerinden helper ekleme yapılacak.
- Helper alt yapısı değişecek.
	- Dinamik bir alt yapı sağlayacak. Static fonksiyon isimlendirme kalkacak.
	- Helper'lar regex ile fonksiyon tanımlayabilecek.
+ Yeni yapı inşa edilecek.
	+ Yapıda String kütüphanesi için de yer açılacak.
	+ Yapı:
		Knot
			Dict
				Dict
					- Üretici.
				AbstractBody
					- Ana Dict gövdesi.
				ParentDict
					- Aile Dict.
				ChildDict
					- Çocuk Dict.
				helpers.json
					- Yüklenecek Helper listesi.
				HelperManager
					Helper - Interface
					KnotPathHelper
					PHPArrayFuntionsHelper
					KnotAdditionHelper
			CharSeries

## v2 ile gelecek özellikler
- Extension haline getirilecek.
	- Zephir bu iş için uygun, fakat hala referans yapısını desteklememekte.
		- Referans yapısı illaki gerekmekte.