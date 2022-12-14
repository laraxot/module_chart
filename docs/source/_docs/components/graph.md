---
title: Graph
description: Graph
extends: _layouts.documentation
section: content
path: it/docs/components
---

# Graph {#graph}

Nome Componente:
```php
x-graph
```

Parametri:

```php
string $id
string $url
?string $type = 'graph' (solo graph per ora)
```

Esempio:

```php
<x-graph
id="1"
url=""
type = "graph"
>

</x-graph>
```

e ti restituisce il grafico fatto in Chartjs corrispondente.

Per altre informazioni leggere documentazione [ChartJs](https://www.chartjs.org/docs/latest/).