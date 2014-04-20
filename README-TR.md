# Knot

[![Build Status](https://travis-ci.org/kalaomer/knot.svg?branch=master)](https://travis-ci.org/kalaomer/knot) [![Dependency Status](https://www.versioneye.com/user/projects/53530290fe0d079af90001d5/badge.png)](https://www.versioneye.com/user/projects/53530290fe0d079af90001d5)

Knot güçlü bir PHP Array aracıdır. Array'ları nesne gibi kullanım imkanı vermektedir. Ek olarak zengin fonksiyonları vardır.

Basit bir örnek;
```
$obj = ar(1,2,3);

$obj->merge(array(3,3,4,5,6,7))->unique();

$obj->child = array("a", "b", "c");

$obj->toArray();
```

Burada ilk başta $obj için bir tane Knot oluşturuldu ve Knot datasına ```array(1,2,3)``` değeri verildi. Daha sonra bu $obj datası ```array(3,3,4,5,6,7)``` ile birleştirildi. Ardından $obj datasındaki benzer değerler çılarıldı. Sonraki satırda data içinde child ifadesi açılarak değeri ```array("a", "b", "c")``` arrayına eşitlendi. Son satırda $obj'nin datası Array şeklinde alındı.

## Yükleme

Composer ile kolay bir şekilde yüklenebilir.

```
{
    "require": {
        "kalaomer/knot": "v1.*"
    }
}
```

Ayrıca github üzerinden indirilebilir. [Github üzerinden indir.](https://github.com/kalaomer/knot/archive/master.zip)

## Başlangıç

Hızlı bir şekilde Knot oluşturmak için üç adet fonksiyon vardır.

### ar(...)

Bu fonksiyona yollanan argümanlar bir array içine alınarak Knot nesnesinin datasına eşitlenir.

Örnek:
```
$obj = ar(1,2,3);

// array(1,2,3) ifadesini verecektir.
$obj->toArray();
```

### arr($array)

Bu fonksiyona yollanan array argümanı Knot nesnesinin datasını oluşturmaktadır.

Örnek:
```
$obj = arr(array(1,2,3,'a'=>4));

// array(1,2,3,'a'=>4) ifadesini verecektir.
$obj->toArray();
```

### arr_ref(&$array)

Bu fonksiyon arr() fonksiyonuna ek olarak referansı alınması istenen değeri Knot nesnesine yollar. Böylece argümana yollanan array ile Knot datası aynı değeri temsil eder.

## Knot nesnesini kullanma

Knot nesnesinin data'sını Array şeklinde almak için ```toArray``` fonksiyonu kullanılmaktadır.

Örnek:
```
$obj = ar(1,2,3);

// array(1,2,3) değerini verecektir.
$obj->toArray();
```

Bu fonksiyon üzerinden Knot nesnesinin data'sının referansıda alınabilmektedir.

Örnek:
```
$obj = ar();

$array =& $obj->toArray();

$array["foo"] = 1;

// array("foo"=>1) ifadesini verecektir.
$obj->toArray();
```

### Array benzeri kullanımı

Knot nesnesi aynı Array'lar gibi kullanılabilmektedir. Yapısında [ArrayAccess](http://www.php.net/manual/en/class.arrayaccess.php) bulundurmaktadır.

Örnek:
```
$obj = ar();

$obj["new"]["way"] = "new way value";

$obj[][][][] = 1;
```

Bu kullanım şekli ile Knot nesnesinin data'sı içinde istenildiği gibi gezilip değer değiştirilebilmektedir.

### Diğer kullanımlar

Knot ayrıca ```__get``` ile data içerisine erişim imkanıda sunmaktadır. Bu kullanımın Array benzeri kullanımdan farklı olarak eğer ```__get``` çıktısı bir Array ise Knot otomatik olarak bu çıktıyı çocuk bir Knot yapısı içerisinde verir. Bu sayede çocuk değerler üzerinde Knot fonksiyonları kullanılabilmektedir.

Ayrıca ```__set``` kullanımı ile de Knot data'sı üzerinde düzenleme yapılabilmektedir.

Örnek:
```
$obj = ar();

$obj->new = array(
    "way" => "new value"
);

// array("way" => "new value") değerini verecektir.
$obj->new->toArray();
```

Bu yapıyı kullanırken dikkat edilmesi gerekilen nokta, varolmayan yollar açarken PHP bu yolları nesne gibi kabul ederek Knot data'sı içine stdClass nesnesi yerleştirmektedir.

Örnek:
```
$obj = ar();

$obj->new->way->foo = 1;
```

Burada $obj nesnesinin data'sında bulunan new key'ine sahip ifade stdClass nesnesine eşitlenmiştir.

Bu durumdan kaçınmak için bu özelliği var olan yollar için kullanılması gerekmektedir.

## Fonksiyonlar

Knot yapısında bulunan hazır fonksiyonlar ile hızlı bir şekilde fonksiyonlar çağrılabilir. Bu yapıya dışarıdan fonksiyon dahi eklenebilir veya sadece o Knot nesnesi için fonksiyon dahi oluşturulabilir.

### Knot yapısındaki fonksiyonlar

Knot bazı işlemleri kolaylatırmak için kendi fonksiyonlarına sahiptir.

#### get($path, [$default_value])

Knot, data içinde verilen adres eşliğinde hedef gösterilen bilgiyi bulabilmektedir. Bu sayede uzun ifade yazmaktansa Knot'a adres verilerek istenen veri alınabilir.

Knot adresleme için ```.``` ifadesini kullanır.

Örnek bir adres: ```foo.sub.target```

Burada ifade edilmek istenen Knot data'sı içinde foo içindeki sub'ın target değeridir.

Bu kullanım ile Knot içinden veri çekilebilmektedir.

Örnek:
```
$obj = arr(array(
    "foo" => array(
        "sub" => array(
            "target" => 123
        )
    )
));

// $obj["foo"]["sub"]["target"] değerini verecektir(yani 123).
$target = $obj->get("foo.sub.target");
```

Ayrıca ```get``` ile varsayılan değer kullanılabilir. Bu işlemde fonksiyon eğer verilen yol yok ise bu yolu oluşturur ve yola varsayılan değeri atar.

Eğer varsayılan değer yok ise ve yol geçerli değilse hata verir.

Ek olarak yol'un hedefi Array ise, Knot otomatik olarak hedefi çocuk Knot yapar ve çıktılar, böylece iç içe kullanım oluşturur.

#### set($path, $value)

```get``` fonksiyonundaki yol mantığını kullanır. Amacı yol'da belirtilen yere değeri yerleştirmektir.

Çıktısında eğer yerleştirilen değer Array ise Knot otomatik olarak çocuk Knot oluşturur ve iç içe işlem yaptırır. Aksi halde çıktı hedefe yollanan değerdir.

#### del($path)

```get``` fonksiyonunun yol mantığını kullanır. Amacı yol'da belirtilen yeri silmektir.

#### only_get($path, [$default_value])

```get``` fonksiyonunun yol mantığını kullanır. ```get``` fonksiyonundan farklı olarak, eğer belirtilen yol aktif değil ise varsayılan değeri belirtilen yola eşitlemez. Sadece varsayılan değeri döndürür.

#### kill()

Knot data'sını boş bir Array şekline dönüştürür.

#### path()

Knot eğer çocuk ise aile içindeki yolunu verir. Çocuk değilse buş değer dönecektir.


### PHP Array fonksiyonları

Knot, fonksiyonlar için hazırda bulunan PHP'nin Array fonksiyonlarını temel alır. Bunu yaparken sınıflandırma kullanılmıştır. Bunun nedeni bu fonksiyonların argüman girişlerinin ve çıkış değelerinin farklı olmasıdır.

PHP fonksiyonları Knot yapısında ```array_``` ekli olmadan çağrılır. Örneğin ```array_merge``` fonksiyonu Knot içinde ```merge``` olarak geçmektedir.

#### 1. sınıf fonksiyonlar

Bu sınıftaki fonksiyonların çıktısı Array'dır. Knot bu fonksiyonların çıktısını kendi datasına eşitler ve genel çıktıyı Knot nesnesi yapar, böylece Knot tekrar tekrar çağrılabilir.

Bu sınıftaki fonksiyonlar:      "array_change_key_case",
                           		"array_chunk",
                           		"array_combine",
                           		"array_diff_assoc",
                           		"array_diff_key",
                           		"array_diff_uassoc",
                           		"array_diff_ukey",
                           		"array_diff",
                           		"array_fill_keys",
                           		"array_filter",
                           		"array_flip",
                           		"array_intersect_assoc",
                           		"array_intersect_key",
                           		"array_intersect_uassoc",
                           		"array_intersect_ukey",
                           		"array_intersect",
                           		"array_merge_recursive",
                           		"array_merge",
                           		"array_pad",
                           		"array_reverse",
                           		"array_slice",
                           		"array_udiff_assoc",
                           		"array_udiff_uassoc",
                           		"array_udiff",
                           		"array_uintersect_assoc",
                           		"array_uintersect_uassoc",
                           		"array_uintersect",
                           		"array_unique"

Örnek kod:
```
$obj = ar();

$obj->merge(array(1,2,3), array(2,3,4))->unique();

// array(1,2,3,4) yapısını verecektir.
$obj->toArray();
```

#### 2. sınıf fonksiyonlar

Bu sınıftaki fonksiyonların çıktıları array değildir. Argüman olarak Knot kendi data'sının referans edilebilir halini yollamaktadır. Bu nedenden dolayı Knot datasına direk müdehale edebilirler.

Bu sınıftaki fonksiyonlar:      "array_column",
                                "array_count_values",
                                "array_keys",
                                "array_multisort",
                                "array_pop",
                                "array_product",
                                "array_push",
                                "array_rand",
                                "array_reduce",
                                "array_replace_recursive",
                                "array_replace",
                                "array_shift",
                                "array_splice",
                                "array_sum",
                                "array_unshift",
                                "array_values",
                                "array_walk_recursive",
                                "array_walk"

Örnek kod:
```
$obj = ar(1,2,3);

// $first_value = 1
$first_value = $obj->shift();

// array(2,3) yapısını verecektir.
$obj->toArray();
```

### Knot yapısındaki Callable'lar

Knot içerine callable bir veri eklendiği zaten bu yapıyı fonksiyon çağırır gibi çağırma imkanı vermektedir.

Örnek:
```
$obj = ar();

$obj->simple_function = function(&$data, $key, $value)
{
    $data[$key] = $value;
}

$obj->simple_function("simple", "value");
```

Burada $obj'nin içine önce simple_function adında bir değer açılarak Closure ifadeye eşitleniyor. Sonrasında bu ifadeyi fonksiyon gibi kullanarak çalıştırılıyor.

Array içine fonksiyon yazmak için callable yapısının argümanlarını ilk argümanı Knot yapısının datası gerisini fonksiyon tetiklenirken yollanan argümanlar olarak ayarlamalısınız. Knot yapısındaki data referans edilebilir olarak gönderilmektedir.

### Knot yardımcıları

Knot fonksiyon ihtiyacını dışarıdan yardımcılar ile sağlayabilmektedir. Bunun nedeni Array için yazılmış hazır kütüphaneleri Knot yapısında kullanımını sağlamak. Knot şu an için [underscore.php](http://brianhaveri.github.io/Underscore.php/) kütüphanesini yapısına ekleyen bir yardımcı kullanmaktadır.

#### Underscore

Underscore yapısındaki fonksiyonlar direk olarak Knot nesnesi üzerinden çağrılabilir. Bazı fonksiyon isimleri Array fonksiyonları ile çakıştığı için Underscore'un bazı fonksiyonlarına Knot üzerinden erişim imkanı olmayabilir. Bunun çözümü ileriki zamanlarda olacaktir.

Örnek bir Underscore kullanımı:
```
$obj = arr(array(
   array(
       'name'    =>  'Joe Bloggs',
       'id'      =>  1,
       'grade'   =>  72,
       'class'   =>  'A',
   ),
   array(
       'name'    =>  'Jack Brown',
       'id'      =>  2,
       'grade'   =>  67,
       'class'   =>  'B',
   ),
   ,
));

// array(
//     "A" => array(
//        array(
//           'name'    =>  'Joe Bloggs',
//           'id'      =>  1,
//           'grade'   =>  72,
//           'class'   =>  'A',
//       )
//    ),
//    "B" => array(
//        array(
//           'name'    =>  'Jack Brown',
//           'id'      =>  2,
//           'grade'   =>  67,
//           'class'   =>  'B',
//       ),
//        array(
//           'name'    =>  'Jill Beaumont',
//           'id'      =>  3,
//           'grade'   =>  81,
//           'class'   =>  'B',
//       )
//    )
//) ifadesi verecektir.

$obj->groupBy("class");
```

## Testler

PHPunit ve Travis yardımı ile testler yapılmaktadır. Ek olarak test ekleyebilirsiniz(!)

## Son olarak

İletişim için kalaomer@hotmail.com