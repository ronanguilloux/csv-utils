# csv-utils

`csv-utils` is (yet another) CLI tool for quick-win CSV manipulations
 
It mostly performs extractions. It's also a starting point for further complex, custom-dev based CSV manipulations.


## Available commands: 

```bash
bin/console list csv
```

## Headers

List, slug, unslug headers

```bash
bin/console csv:head <path>
bin/console csv:head:slug <path>
bin/console csv:head:unslug <path>
```

## Columns

Get a column's unique values

```bash
bin/console csv:column:uniques <path> <column_index_or_title>
```

Example

```bash
bin/console csv:cols:uniques share/examples/uniques.csv 5 
bin/console csv:cols:uniques share/examples/uniques.csv "C'est une colonne en Français" 
```

## Build it as a phar 

The phar PHP utility provides a way to put entire PHP applications
into a single file called a "phar" (PHP Archive)
for easy distribution and installation:

```
curl -LSs https://box-project.github.io/box2/installer.php | php
php box.phar build
chmod a+x csv-utils.phar
```


Then use it:

```bash
./csv-utils.phar help csv
```

## License
 
MIT
