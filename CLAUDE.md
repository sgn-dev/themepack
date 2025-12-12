# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Projektübersicht

ThemePack ist ein proprietäres Contao 4.6+ Bundle (`sgn47gradnord/themepack`) zur Erstellung von Theme-basierten Websites. Es erweitert Contao um Custom Content Elements, Module und Templates für moderne Website-Layouts.

## Technologie-Stack

- **PHP**: ^7.1.0 || ^8.1 (aktuell in Umstellung auf PHP 8.3 Kompatibilität)
- **Contao**: ^4.6.12 Core Bundle
- **Namespace**: `Sgn47gradnord\Themepack`
- **Bundle-Typ**: contao-bundle

## Entwicklungskommandos

### Code-Formatierung
```bash
# PHP-CS-Fixer ausführen
vendor/bin/php-cs-fixer fix
```

Die Konfiguration befindet sich in `.php_cs` mit strikten Regeln:
- Strict types erforderlich
- Strict comparisons
- PSR-4 Autoloading
- Symfony Coding Standards

### Composer
```bash
# Dependencies installieren
composer install

# Dependencies aktualisieren
composer update
```

## Architektur

### Verzeichnisstruktur

```
src/
├── Backend/
│   └── Callback.php              # DCA Callbacks für Content-Validierung
├── ContaoManager/
│   └── Plugin.php                # Bundle-Registrierung (lädt nach CoreBundle)
├── Element/                      # Content Element Klassen
│   ├── AbstractElement.php
│   ├── Featurebox.php
│   ├── Gallerybox.php
│   ├── Imagebox.php
│   ├── Textbox.php
│   ├── TextImageBox.php
│   ├── Parallaxbox.php
│   ├── ContainerStart/Stop.php   # Wrapper Elements
│   ├── SectionStart/Stop.php     # Wrapper Elements
│   └── SwiperSlider/             # Slider-Komponenten
├── Module/                       # Frontend Module
│   ├── AbstractModule.php
│   ├── Headerbar.php
│   ├── Footerbar.php
│   └── Pagetitle.php
├── Resources/contao/
│   ├── config/config.php         # Globale Konfiguration, Element-Registrierung
│   ├── dca/                      # Data Container Arrays
│   ├── languages/de/             # Deutsche Übersetzungen
│   └── templates/                # HTML5 Templates
│       ├── overwrite/            # Contao Core Template Overrides
│       ├── element/              # Content Element Templates
│       └── module/               # Modul Templates
├── ContaoHelper.php              # Utility-Klasse für Bilder & URLs
└── ThemepackBundle.php           # Bundle-Einstiegspunkt
```

### Kern-Komponenten

#### 1. Content Elements (`src/Element/`)

Alle Elements erben von `AbstractElement` (welches von `Contao\ContentElement` erbt):

- **Featurebox**: Icon/Bild + Text mit optionalem Link
- **Textbox**: Reiner Textinhalt
- **Imagebox**: Einzelbild mit Link
- **TextImageBox**: Kombination Text + Bild
- **Gallerybox**: Multi-Bild Galerie
- **Parallaxbox**: Parallax-Effekt Bild
- **SwiperSlider**: Start/Item/Stop Wrapper für Slider
- **Container/Section**: Start/Stop Wrapper für Layout-Strukturen

Jedes Element:
- Hat ein `$strTemplate` Property
- Implementiert `compile()` Methode
- Nutzt `ContaoHelper` für Bildverarbeitung

#### 2. Module (`src/Module/`)

Alle Module erben von `AbstractModule` (welches von `Contao\Module` erbt):

- **Headerbar**: Verschiedene Header-Varianten (boxed, transparent, floating)
- **Footerbar**: Footer-Bereich
- **Pagetitle**: Seiten-Titel mit Breadcrumb

Helper-Methoden in `AbstractModule`:
- `getRootPageTitle()`: Root-Page Titel abrufen
- `getPageTitle()`: Aktuellen Seiten-Titel abrufen
- `generateWildcard()`: Backend-Platzhalter generieren

#### 3. ContaoHelper (`src/ContaoHelper.php`)

Zentrale Utility-Klasse mit statischen Methoden:

- **`addThemePackImageToTemplate()`**: Fügt Bild-Daten zu Templates hinzu
  - Verarbeitet Bildgrößen, Margins, Lightbox
  - Nutzt Contao Picture Factory für responsive Images
  - Lädt Meta-Daten aus FilesModel

- **`createUrl()`**: Generiert URLs mit optionalen Query-Parametern
  - Unterstützt PageModel jump-to
  - Merge von Query-Strings via League\Uri

- **`getRootPageUrl()`**: Root-Page URL abrufen

### Template-System

#### Template-Kategorien

1. **Overwrite Templates** (`templates/overwrite/`)
   - Überschreiben Contao Core Templates
   - **WICHTIG**: `nav_default.html5` und `fe_page.html5` haben temporäre Fixes in `/templates/` (siehe THEMEPACK.md)

2. **Element Templates** (`templates/element/`)
   - Ein Template pro Content Element
   - Namenskonvention: `ce_tp_*.html5`
   - Varianten möglich (z.B. `ce_tp_featurebox_icon_small.html5`)

3. **Module Templates** (`templates/module/`)
   - Ein Template pro Modul
   - Namenskonvention: `mod_tp_*.html5`
   - Varianten für Header: boxed, transparent, floating, transparent_full

#### Template-Variablen

Häufig verwendete Variablen in Templates:
- `$this->tp_*`: ThemePack-spezifische Felder
- `$this->picture`: Responsive Image Array
- `$this->sections`: Layout-Bereiche (bei fe_page.html5)
- `$item`: Navigation/Breadcrumb Items (bei nav_default.html5)

### DCA-System

#### tl_content.php

Definiert Paletten für alle ThemePack Content Elements:

- **Palettes**: Feld-Gruppen pro Element-Typ
- **Subpalettes**: Dynamisch eingeblendete Felder (z.B. bei `tp_forward`)
- **Selectors**: Trigger für Subpaletten (`tpfeatureboxtype`, `tp_forward`, etc.)
- **Fields**: Feld-Definitionen mit SQL-Schema

Callback-Integration:
```php
$GLOBALS['TL_DCA']['tl_content']['config']['onsubmit_callback'][] =
    ['Sgn47gradnord\Themepack\Backend\Callback', 'onsubmitCallbackTlContent'];
```

#### config.php

Registriert alle Komponenten:

```php
// Content Elements
$GLOBALS['TL_CTE']['themepack-elements'] = [...];
$GLOBALS['TL_CTE']['themepack-swiperslider'] = [...];

// Wrappers
$GLOBALS['TL_WRAPPERS']['start'][] = 'tp_swiperslider_start';
$GLOBALS['TL_WRAPPERS']['stop'][] = 'tp_swiperslider_stop';

// Frontend Modules
$GLOBALS['FE_MOD']['themepack'] = [...];

// Konstanten
$GLOBALS['THEMEPACK']['numberColumns'] = [...]; // Spalten-Layout
```

## PHP 8.3 Kompatibilität

**Aktueller Stand**: In aktiver Migration (siehe `THEMEPACK.md`)

### Kritische Probleme behoben

1. **nav_default.html5**: Undefined array keys für `subitems`, `accesskey`, `tabindex`, `target`, `rel`
2. **fe_page.html5**: Undefined array keys für `$this->sections`

### Best Practices für neue/geänderte Templates

```php
// NULL Coalescing Operator verwenden
<?= $item['subitems'] ?? '' ?>
<?= $this->tp_subHeadline ?? '' ?>

// !empty() statt direkte Prüfung
<?php if (!empty($item['accesskey'])): ?>
    <!-- Content -->
<?php endif; ?>

// Array-Key-Existenz prüfen
<?php if (array_key_exists('key', $array)): ?>
```

### Strict Types

Alle PHP-Dateien verwenden:
```php
declare(strict_types=1);
```

## Spalten-System

Das Bundle definiert ein eigenes Spalten-Layout-System (`$GLOBALS['THEMEPACK']['numberColumns']`):

- `col_full`: Einspaltig
- `col_half`: 2-spaltig
- `col_one_third`: 3-spaltig (1/3 Breite)
- `col_one_fourth`: 4-spaltig (1/4 Breite)
- `col_one_fifth`: 5-spaltig
- `col_one_sixth`: 6-spaltig
- `col_two_third`: 2/3 Breite
- `col_three_fourth`: 3/4 Breite
- `col_two_fifth`: 2/5 Breite
- `col_three_fifth`: 3/5 Breite

Verwendet in: Featurebox, Textbox, Imagebox, TextImageBox

## Git-Workflow

- **Main Branch**: `develop`
- **Aktuelle Warnings**: PHP 8 Warnungen wurden gefixed (siehe THEMEPACK.md)
- **Temporäre Fixes**: Befinden sich in `/templates/` - nach Bundle-Update löschen!

## Wichtige Hinweise

1. **Bildverarbeitung**: Immer `ContaoHelper::addThemePackImageToTemplate()` nutzen, niemals direkt Contao Image API
2. **URL-Generierung**: `ContaoHelper::createUrl()` für konsistente URL-Erzeugung
3. **Template-Variablen**: Immer mit `??` oder `!empty()` absichern (PHP 8.3)
4. **Wrappers**: Start/Stop Elements müssen in `$GLOBALS['TL_WRAPPERS']` registriert sein
5. **Code Style**: Vor Commit `php-cs-fixer fix` ausführen
6. **Strict Comparison**: Immer `===` statt `==` verwenden (siehe .php_cs Regeln)

## Copyright & Lizenz

- **Copyright**: 2008-2018, 47GradNord - Agentur für Internetlösungen
- **Lizenz**: Proprietary
- **Kontakt**: info@47gradnord.de
