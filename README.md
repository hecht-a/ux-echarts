# 📊 Symfony UX ECharts

Symfony UX ECharts est un bundle UX permettant d’intégrer facilement [Apache ECharts](https://echarts.apache.org/) dans
vos templates Twig, en combinant PHP, Twig et Stimulus.

## ✅ Installation

```bash
composer require hecht-a/ux-echarts:dev-main
npm install --force
```

## 🚀 Utilisation

### Dans un contrôleur Symfony :

```php
<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use HechtA\UX\ECharts\Builder\EChartsBuilderInterface;
use HechtA\UX\ECharts\Model\ECharts;

final class HomeController extends AbstractController
{
    #[Route('/', name: 'home.index')]
    public function index(EChartsBuilderInterface $builder): Response
    {
        $chart = $builder->createECharts('weekly_chart')
            ->setOptions([
                'xAxis' => ['type' => 'category', 'data' => ['Mon', 'Tue', 'Wed']],
                'yAxis' => ['type' => 'value'],
            ])
            ->addSerie([
                'type' => ECharts::TYPE_LINE,
                'data' => [150, 230, 224],
            ]);

        return $this->render('chart/index.html.twig', [
            'chart' => $chart,
        ]);
    }
}

```

### Dans un template Twig :

```twig
{{ render_echarts(chart) }}
```

Cela génère un `<div>` avec tous les attributs `data-controller` nécessaires pour que Stimulus initialise
automatiquement le graphique.

## 🎨 Thèmes

Vous pouvez ajouter vos propres thèmes ECharts et choisir celui à utiliser :

```php
$chart
    ->addTheme('dark', [...])
    ->addTheme('vintage', [...])
    ->useTheme('dark');
```

> Ces thèmes seront automatiquement enregistrés via `echarts.registerTheme`.

## ⚡ Personnalisation HTML

Ajoutez des attributs personnalisés au conteneur HTML :

```php
$chart->setAttributes([
    'id' => 'custom-chart',
    'class' => 'my-chart mb-4',
]);
```

Si vous utilisez d'autres controllers Stimulus :

```php
$chart->setAttributes([
    'data-controller' => 'custom-controller',
]);
```

> Le controller `@hecht-a/ux-echarts/echarts` est toujours injecté automatiquement.

## 🧩 API PHP

| Méthode                   | Description                                                                            |
|---------------------------|----------------------------------------------------------------------------------------|
| `setOptions(array)`       | Définit les options ECharts. Se référer à la doc [Apache ECharts](https://echarts.apache.org/en/option.html) pour la liste des options |
| `addSerie(array)`         | Ajoute une série de données                                                            |
| `setSeries(array)`        | Définit toutes les séries                                                              |
| `addTheme(string, array)` | Enregistre un thème ECharts                                                            |
| `useTheme(string)`        | Définit le thème à utiliser                                                            |
| `setAttributes(array)`    | Attributs HTML : class, id, data-*, etc.                                               |
| `getId()`                 | Retourne l’ID HTML (si défini)                                                         |
| `createView()`            | Structure complète injectée en Stimulus                                                |

## 🧪 Exemple complet

```php
$chart = $builder->createECharts()
    ->setOptions([
        'title' => ['text' => 'Example'],
        'xAxis' => ['type' => 'category', 'data' => ['A', 'B', 'C']],
        'yAxis' => ['type' => 'value'],
    ])
    ->setSeries([
        ['type' => ECharts::TYPE_BAR, 'data' => [10, 20, 30]],
        ['type' => ECharts::TYPE_LINE, 'data' => [15, 25, 35]],
    ])
    ->addTheme('dark', [...])
    ->useTheme('dark')
    ->setAttributes(['class' => 'chart-container']);
```