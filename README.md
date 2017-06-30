# (Yet another) csv-utils CLI tool

This is rather a starting point than a finished tool.


## Available commands: 

```bash
bin/console list   
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
bin/console csv:column:uniques <path> <column_index>
```

Example

```bash
bin/console csv:columns:uniques share/examples/uniques.csv 1 
```

## License
 
MIT
