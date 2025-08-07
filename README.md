# mderrdx.infoblocks

1. и самое важное, работа с объектами, а не с массивами, что дает свои (огромные)плюсы
2. просто меньше рутинной работы

## Юзаем

Выбрать разделы или элементы из инфоблока, для начала выберем инфоблок по коду или ID(устанавливайте код для инфоблока...рекомендация)

```php
//return IBlock
$catalog = IBlockContainer::getByCode('catalog');
$catalog = IBlockContainer::getByID($id);
```

А теперь выбираем
```php
//return IBlockSection[]
$categories = $catalog->getSections($params);
//return IBlockSection
$category = $catalog->getSectionById($id);
$categpry = $catalog->getSectionByCode($code);

//return IBlockElement[]
$products = $catalog->getElements($params);
//return IBlockElement
$product = $catalog->getElementById($params);
$product = $catalog->getElemenByCode($params);
```
Свойства элемента
```php
//Разберетесь сами
$product->url();
$product->name();
//return Property (или другие объекты наследуемые от этого класса)
$property = $product->property('price');
$product->property('price')->value();
//return IBlockElement | IBlockSection | и так далее..
$product->property('brand')->value();
//нужен просто id
$product->property('brand')->rawValue();
```

И вот, неожиданно, нам нужно, прям хочется использовать свои объекты с нормальным именем отвечающим бизнес логике, правилам и бла. бла.. бла...

Определяем свои классы:
```php
class Catalog extends IBlock{}//...
class CatalogCategory extends IBlockSection {//...
    public function title() {
        return $this->name();
    }
}
class CatalogProduct extends IBlockElement {//...
    public function getPriceWithDiscount($discount) {}
}
```

Далее регистрируем эти классы для инфоблока(до вызова), естественно можно не все
```php
        IBlockContainer::setClassIBlock('catalog', '\App\Models\Catalog')
            ::setClassSection('catalog', '\App\Models\CatalogCategory')
            ::setClassElement('catalog', '\App\Models\CatalogProduct');

```
И получаем
```php
//return \App\Models\Catalog
$catalog = IBlockContainer::getByCode('catalog');
//return \App\Models\CatalogCategory
$category = $catalog->getByCoe($code);
//return \App\Models\CatalogProduct
$product = $catalog->getByCode($code);

```

Так же можно добавлять свой класс при выборке, если при данном запросе нужно на горячую поменять(переопределить) класс

```php
//return \App\Models\Catalog
$catalog = IBlockContainer::getByCode('catalog', '\App\Models\Catalog');
//return \App\Models\CatalogCategory
$category = $catalog->getByCoe($code, '\App\Models\CatalogCategory');
//return \App\Models\CatalogProduct
$product = $catalog->getByCode($code, '\App\Models\CatalogProduct');
```

Самый сумашедший вариант: определить класс в business, а в persistence его наследовать, но множественного наследования нет.
Используем `trait`

```php
//Core
namespace App\Core\Models;

abstract class News
{
    public abstract function title(): string;
    public abstract function date(): string ;
    public function titleWithDate()
    {
        return $this->title() . ': ' . $this->date();
    }
}

//Persistence
namespace App\Data\Models;
//...

class News extends App\Core\News 
{
    use IBlockElementTrait;

    public function __construct($data, $iblock){//...От конструктора избавиться увы не удается
    
    public function title(): string
    {
        return $this->name();
    }

}
```

примеры:
[тут](https://github.com/mderrdx5341/bitrix.is.db)

