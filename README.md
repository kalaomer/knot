## EasyArray Nedir?
EasyArray dizi yönetimini kolaylaştırmak için tasarlanmış bir nesnedir.
Bir diziyi EasyArray nesnesine çevirebilir ya da yeni bir nesne oluşturarak hemen kullanmaya başlayabilirsiniz.

## Nasıl Kullanılır?

**Yeni bir EasyArray nesnesi oluşturalım**

```php
$EasyArray = ar(1,2,3,4,5);
```

**Zaten var olan bir diziyi EasyArray nesnesi ile oluşturalım**

```php
$array = array(1,2,3,4,5);

$EasyArray = arr($array);
```

**Referans olarak dizimizi EasyArray ile yönetelim**

```php
$array = array(1,2,3,4,5);

// Artık dizimizi hem değişkenimiz ile hem de EasyArray ile yönetebiliriz.
$EasyArray = arr_ref($array);
```

**Referans alınan dizimizi EasyArray nesnesine dönüştürelim**

```php
$array = array(1,2,3,4,5);

// Artık $array isimli dizimiz bir EasyArray nesnesi olmuştur.
arr_convert($array);
```

**Diziyi EasyArray nesnesi içerisinden çıkartalım**

```php
$EasyArray = ar(1,2,3,4,5);

// Artık $output isimli değişkenimiz EasyArray nesnesinden alınmış bir dizidir.
$output = $EasyArray->toArray();
```

**Dizim EasyArray nesnesi mi?**

```php
$EasyArray = ar(1,2,3,4,5);

// Gönderilen EasyArray nesnesi ise true dönecektir.
$result = is_ar($EasyArray);

var_dump($result);
```

**Diziyi HTML olarak çıktılama**

```php
$EasyArray = ar(1,2,3,4,5);

// Stil olarak var_dump öntanımlıdır.
$EasyArray->dump();

// Önce Argümanları sonra $EasyArray->toArray()'ı dump et.
$EasyArray->dump( "EasyArray->dump() sonucu" );
```
